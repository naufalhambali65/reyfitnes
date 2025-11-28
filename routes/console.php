<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\MemberMembership;
use App\Models\Notification;
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
            Notification::create([
                'user_id' => $id,
                'title' => 'Membership Kadaluarsa | ' . $membership->user->name,
                'type' => 'warning',
                'icon'  => 'fas fa-exclamation-triangle',
                'link'  => '/dashboard/members/' . $membership->member_id,  // sesuaikan dengan route detailmu
                'message' => "Membership atas nama ". $membership->user->name . " kadaluarsa pada tanggal " .
                    Carbon::parse($membership->end_date)->translatedFormat('d M Y'),
            ]);
        }
    }

    Log::info("Expired memberships processed: {$expiredMemberships->count()}");
})->daily();
