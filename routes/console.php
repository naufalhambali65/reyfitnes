<?php

use App\Models\ClassBooking;
use Illuminate\Support\Facades\Schedule;
use App\Models\MemberMembership;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

Schedule::call(function () {

    // === 1. Membership yang expired hari ini ===
    $expiredMemberships = MemberMembership::where('end_date', '<', today())
        ->where('status', '=', 'active')
        ->get();

    if ($expiredMemberships->isEmpty()) {
        Log::info("No expired memberships today.");
        return;
    }

    $adminIds = User::where('role', 'admin')->pluck('id');

    foreach ($expiredMemberships as $membership) {

        // Update status
        Storage::disk('public')->delete($membership->qr_code);
        $membership->update(['status' => 'expired', 'qr_code' => '']);

        // Buat notifikasi
        Notification::create([
            'user_id' => $membership->user->id,
            'title' => 'Membership Kadaluarsa',
            'type' => 'warning',
            'icon'  => 'fas fa-exclamation-triangle',
            'link'  => '/dashboard/members/' . $membership->member_id,  // sesuaikan dengan route detailmu
            'message' => "Membership Anda telah kadaluarsa pada tanggal " .
                Carbon::parse($membership->end_date)->translatedFormat('d M Y'),
        ]);

        foreach ($adminIds as $id) {

            $phone = preg_replace('/^0/', '62', $membership->user->phone); // ganti 0 menjadi 62
            $text = urlencode("Halo," . $membership->user->name . ", paket membership {$membership->name} anda telah kadaluarsa pada tanggal " .
                Carbon::parse($membership->end_date)->translatedFormat('d M Y')
            );

            $whatsappLink = "https://api.whatsapp.com/send?phone={$phone}&text={$text}";

            Notification::create([
                'user_id' => $id,
                'title' => 'Membership Kadaluarsa | ' . $membership->user->name,
                'type'  => 'warning',
                'icon'  => 'fas fa-exclamation-triangle',
                'link'  => $whatsappLink, // 🔥 langsung menuju chat WhatsApp
                'message' => "Membership atas nama ". $membership->user->name .
                    " kadaluarsa pada tanggal " .
                    Carbon::parse($membership->end_date)->translatedFormat('d M Y'),
            ]);
        }
    }

    Log::info("Expired memberships processed: {$expiredMemberships->count()}");
})->daily();

// === 2. Membership yang akan expired dalam 5 hari ===
Schedule::call(function () {

    $targetDate = today()->addDays(5);

    $expiringMemberships = MemberMembership::where('end_date', '=', $targetDate)
        ->where('status', 'active')
        ->get();

    if ($expiringMemberships->isEmpty()) {
        Log::info("No memberships expiring in 5 days.");
        return;
    }

    $adminIds = User::where('role', 'admin')->pluck('id');

    foreach ($expiringMemberships as $membership) {

        // Cegah double notifikasi: cek apakah notif sudah pernah dibuat
        $alreadyNotified = Notification::where('user_id', $membership->user->id)
            ->where('title', 'LIKE', "%akan kadaluarsa%")
            ->whereDate('created_at', today())
            ->exists();

        if ($alreadyNotified) {
            continue;
        }

        // === Notifikasi untuk Member ===
        Notification::create([
            'user_id' => $membership->user->id,
            'title' => 'Membership Akan Kadaluarsa',
            'type' => 'warning',
            'icon'  => 'fas fa-hourglass-half',
            'link'  => '/dashboard/members/' . $membership->member_id,
            'message' => "Membership Anda akan kadaluarsa pada tanggal " .
                Carbon::parse($membership->end_date)->translatedFormat('d M Y') .
                " (dalam 5 hari).",
        ]);

        // === Notifikasi untuk Semua Admin ===
        foreach ($adminIds as $id) {

            // Nomor member → ubah 0 jadi 62
            $phone = preg_replace('/^0/', '62', $membership->user->phone);

            // Pesan WA
            $text = urlencode(
                "Halo" . $membership->user->name .", paket membership {$membership->name} anda ".
                "akan kadaluarsa pada tanggal " .
                Carbon::parse($membership->end_date)->translatedFormat('d M Y') .
                " (dalam 5 hari)."
            );

            // Buat deep-link WhatsApp
            $whatsappLink = "https://api.whatsapp.com/send?phone={$phone}&text={$text}";

            Notification::create([
                'user_id' => $id,
                'title' => 'Membership Akan Kadaluarsa | ' . $membership->user->name,
                'type'  => 'warning',
                'icon'  => 'fas fa-hourglass-half',
                'link'  => $whatsappLink, // 🔥 langsung klik → buka WhatsApp
                'message' => "Membership atas nama ". $membership->user->name .
                    " akan kadaluarsa pada tanggal " .
                    Carbon::parse($membership->end_date)->translatedFormat('d M Y') .
                    " (dalam 5 hari).",
            ]);
        }

    }

    Log::info("Membership expiring in 5 days processed: {$expiringMemberships->count()}");
})->daily();

// === 3. Notifikasi Kelas yang Berlangsung Hari Ini ===
Schedule::call(function () {

    $today = strtolower(today()->dayName); // contoh: "monday"

    // Ambil booking yang kelasnya dijadwalkan hari ini
    $todayBookings = ClassBooking::where('day', $today)
        ->where('status', 'active')
        ->with(['gymClass', 'member.user', 'gymClass.trainer.user'])
        ->get();

    if ($todayBookings->isEmpty()) {
        Log::info("No classes scheduled for today: $today");
        return;
    }

    foreach ($todayBookings as $booking) {

        $class = $booking->gymClass;
        $memberUser = $booking->member->user;
        $trainerUser = $class->trainer->user;

        // Cegah double notifikasi (member)
        $alreadyNotifiedMember = Notification::where('user_id', $memberUser->id)
            ->where('title', 'LIKE', "%Kelas Hari Ini%")
            ->whereDate('created_at', today())
            ->exists();

        if (! $alreadyNotifiedMember) {
            Notification::create([
                'user_id' => $memberUser->id,
                'title' => 'Kelas Hari Ini',
                'type' => 'info',
                'icon' => 'fas fa-dumbbell',
                'link' => '/dashboard/classes/' . $class->id,
                'message' => "Anda memiliki kelas *{$class->name}* hari ini.",
            ]);
        }

        // Cegah double notifikasi (trainer)
        $alreadyNotifiedTrainer = Notification::where('user_id', $trainerUser->id)
            ->where('title', 'LIKE', "%Melatih Hari Ini%")
            ->whereDate('created_at', today())
            ->exists();

        if (! $alreadyNotifiedTrainer) {
            Notification::create([
                'user_id' => $trainerUser->id,
                'title' => 'Melatih Hari Ini',
                'type' => 'info',
                'icon' => 'fas fa-user-clock',
                'link' => '/dashboard/classes/' . $class->id,
                'message' => "Anda melatih kelas *{$class->name}* hari ini.",
            ]);
        }
    }

    Log::info("Class reminders sent today: {$todayBookings->count()}");

})->dailyAt('06:00'); // kirim jam 06:00 pagi


// === 3. Produk mencapai atau kurang dari min_stock ===
// Schedule::call(function () {

//     // Ambil produk yang stock-nya <= min_stock
//     $products = Product::whereColumn('stock', '<=', 'min_stock')
//         ->where('status', 'available') // hanya produk aktif
//         ->get();

//     if ($products->isEmpty()) {
//         Log::info("No products with minimum stock today.");
//         return;
//     }

//     // Ambil admin + super_admin
//     $admins = User::whereIn('role', ['admin', 'super_admin'])->get();

//     foreach ($products as $product) {

//         foreach ($admins as $admin) {

//             // Cegah double notify di hari yang sama
//             $already = Notification::where('user_id', $admin->id)
//                 ->where('title', 'LIKE', "%Restock Produk%")
//                 ->where('message', 'LIKE', "%{$product->name}%")
//                 ->whereDate('created_at', today())
//                 ->exists();

//             if ($already) continue;

//             // === Link ke halaman detail produk ===
//             $productLink = '/dashboard/product-stocks/' . $product->slug;

//             // === Simpan Notifikasi ===
//             Notification::create([
//                 'user_id'   => $admin->id,
//                 'title'     => "Restock Produk: {$product->name}",
//                 'type'      => 'warning',
//                 'icon'      => 'fas fa-box-open',
//                 'link'      => $productLink,
//                 'message'   => "Stok produk <b>{$product->name}</b> tinggal ".
//                                "<b>{$product->stock}</b>, sudah mencapai batas minimum ".
//                                "({$product->min_stock}). Harap lakukan restock.",
//             ]);
//         }
//     }

//     Log::info("Products below min_stock processed: {$products->count()}");
// })->daily();