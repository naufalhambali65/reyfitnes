<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceiptMail;
use App\Mail\UserQrCodeMail;
use App\Models\Member;
use App\Models\MemberMembership;
use App\Models\Payment;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller implements HasMiddleware
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
        $title = 'Riwayat Pembayaran';
        $payments = Payment::latest()->get();
        $totalAmountPayments =  'Rp. ' . number_format(Payment::where('status', 'completed')->sum('amount'), 2, ',', '.');
        $waitingPayments = Payment::where('status', 'pending')->count();
        $successPayments = Payment::where('status', 'completed')->count();
        $totalPayments = Payment::all()->count();

        return view('dashboard.payments.index', compact(
            'title',
            'payments',
            'totalAmountPayments',
            'waitingPayments',
            'successPayments',
            'totalPayments'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Payment $payment)
    {
        $title = 'Detail Pembayaran';
        return view('dashboard.payments.show', compact('title', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $user = User::where('id', $payment->user->id)->first();
        $validatedData = $request->validate([
            'status' => 'nullable|string|in:pending,completed,failed',
            'payment_proof' => 'image|file|max:5120|nullable|mimes:jpg,jpeg,png,webp',
        ]);

        $message = '';
        if ($request->file('payment_proof')) {
            if ($request->oldProof) {
                Storage::disk('public')->delete($request->oldProof);
            }
            $validatedData['payment_proof'] = $request->file('payment_proof')->store('payment-proof-image', 'public');
            $validatedData['proof_date'] = now();
            $message = 'Berhasil Upload Bukti Pembayaran!';
        } else {
            $memberMembership = MemberMembership::where('payment_id', $payment->id)->where('status', 'pending')->first();
            if ($memberMembership) {
                if($validatedData['status'] == 'completed') {
                        $data = [
                            'status' => 'active',
                            'start_date' => now(),
                            'end_date' => now()->addDays($memberMembership->membership->duration_days)
                        ];
                        $payload = [
                            'user_id' => $user->id,
                            'member_id' => $memberMembership->member_id,
                            'issued_at' => now()->toIsoString(),
                            'expires_at' => now()->addDays($memberMembership->membership->duration_days)->toIsoString()
                        ];

                        $encrypted = Crypt::encryptString(json_encode($payload));

                        $encryptedData = $encrypted;

                        $result = Builder::create()
                            ->data($encryptedData)
                            ->size(350)
                            ->margin(10)
                            ->build();

                        $filename = 'qr/' . uniqid() . '.png';

                        Storage::disk('public')->put($filename, $result->getString());

                        $data['qr_code'] = $filename;
                        MemberMembership::where('payment_id', $payment->id)->update($data);
                        Member::where('user_id', $payment->user_id)->update(['status' => 'active']);

                        Mail::to($payment->user->email)->send(new UserQrCodeMail($user, $filename));

                    $message ='Pembayaran Selesai!';
                } else if($validatedData['status'] == 'failed'){
                    $data = [
                            'status' => 'cancelled'
                        ];
                    MemberMembership::where('payment_id', $payment->id)->update($data);
                    $message = 'Pembayaran Gagal';
                }
            }
        }
        $payment->update($validatedData);
        Mail::to($payment->user->email)->send(new PaymentReceiptMail($payment));

        return redirect( route('payments.update', $payment->id) )->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->payment_proof) {
            Storage::disk('public')->deleteDirectory('payments-proof-image/' . $payment->id);
        }
        payment::destroy($payment->id);
        return redirect(route('payments.index'))->with('success', 'Data Berhasil Terhapus.');
    }
}