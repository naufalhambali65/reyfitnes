<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Member;
use App\Models\MemberMembership;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin,admin'),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Anggota';
        $members = Member::latest()->get();
        return view('dashboard.members.index', compact('title', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Berlangganan Membership';
        $users = User::where('role', 'guest')->latest()->get();
        $members = Member::latest()->get();
        $memberships = Membership::with('gymClasses')->where('status', 'available')->get();
        $banks = Bank::where('status', 'active')->get();

        return view('dashboard.members.create', compact('title', 'users', 'members', 'memberships', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $title = 'Detail Anggota - ' . $member->user->name;
        $user = $member->user; // relasi: Member belongsTo User

        // Membership aktif (jika ada)
        $activeMembership = $member->memberMemberships()->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->orderByDesc('end_date')
            ->first();

        // Riwayat membership
        $historyMemberships = $member->memberMemberships()
            ->orderByDesc('created_at')
            ->get();

        // dd($historyMemberships);

        // Riwayat absensi
        $attendances = $member->attendances()
            ->orderByDesc('check_in_at')
            ->get();

        // Riwayat pembayaran
        // $payments = $historyMemberships->payment->orderByDesc('created_at')
        //     ->get();
        // dd($payments);

        // $member->payments()
        //     ->orderByDesc('created_at')
        //     ->get();

        return view('dashboard.members.show', compact(
            'title',
            'member',
            'user',
            'activeMembership',
            'historyMemberships',
            'attendances'));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }

    public function payment(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|email',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'required|date|before:today',
            'phone' => 'required|regex:/^[0-9+\s\-]{8,15}$/',
            'image' => 'image|file|max:5120|nullable|mimes:jpg,jpeg,png,webp',
        ]);

        $validatedPayment = $request->validate([
            'bank_id' => 'nullable',
            'amount'=> 'required',
            'payment_method' => 'required|in:transfer,qris',
            'status' => 'nullable|in:pending,completed,failed',
            'notes' => 'string|nullable'
        ]);

        $membership = Membership::where('slug', $request->membership_slug)->first();


        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('user-profile-image', 'public');
        }

        $validatedData['role'] = 'member';

        User::where('id', $user->id)->update($validatedData);

        $validatedPayment['user_id'] = $user->id;
        $payment = Payment::create($validatedPayment);

        $paymentItem = new PaymentItem();
        $paymentItem->payment_id = $payment->id;
        $paymentItem->quantity = 1;
        $paymentItem->price = $validatedPayment['amount'];
        $paymentItem->subtotal = $paymentItem->price * $paymentItem->quantity;

        $paymentItem->item()->associate($membership);
        $paymentItem->save();

        $memberData = [
            'user_id' => $user->id,
            'status' => 'inactive',
            'join_date' => now()
        ];

        $member = Member::create($memberData);

        $memberMembershipData = [
            'member_id' => $member->id,
            'membership_id' => $membership->id,
            'payment_id' => $payment->id,
            'status' => 'pending',
        ];

        MemberMembership::create($memberMembershipData);

        return redirect()->route('payments.show', $payment->id)->with('success', 'Pembayaran dibuat, harap segera diselesaikan!');
    }


}