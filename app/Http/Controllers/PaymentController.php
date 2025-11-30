<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceiptMail;
use App\Mail\UserQrCodeMail;
use App\Models\Member;
use App\Models\MemberMembership;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        // dd($request);
        $validatedPayment = $request->validate([
            'bank_id' => 'nullable',
            'amount'=> 'required',
            'payment_method' => 'required|in:transfer,qris',
            'status' => 'nullable|in:pending,completed,failed',
            'notes' => 'string|nullable',
            'items' => 'required|array',
            'items.*.item_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',

        ]);

        $validatedPayment['user_id'] = Auth::user()->id;
        $items = $validatedPayment['items'];
        unset($validatedPayment['items']);


        DB::beginTransaction();

        try {
            $payment = Payment::create($validatedPayment);

            foreach($items as $item) {
                $paymentItem = new PaymentItem();
                $paymentItem->payment_id = $payment->id;
                $paymentItem->quantity = $item['quantity'];
                $paymentItem->price = $item['price'];
                $paymentItem->subtotal = $item['subtotal'];

                $paymentItem->item_type = Product::class;
                $paymentItem->item_id = $item['item_id'];
                $paymentItem->save();

                // 2. Kurangi stok produk
                $product = Product::find($item['item_id']);

                if (!$product) {
                    throw new \Exception("Produk ID {$item['item_id']} tidak ditemukan");
                }

                // Cek apakah stok cukup
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi");
                }

                $product->stock -= $item['quantity'];

                if($product->stock > 0) {
                    $product->status = 'available';
                } else {
                    $product->status = 'unavailable';
                }

                if ($product->stock <= $product->min_stock) {

                    $adminIds = User::whereIn('role', ['admin', 'super_admin'])->pluck('id');

                    foreach($adminIds as $adminId) {
                        Notification::create([
                            'user_id' => $adminId,
                            'title'   => 'Stok Produk Menipis',
                            'type'    => 'warning',
                            'icon'    => 'fas fa-box-open',
                            'link'    => '/dashboard/product-stocks/' . $product->id,
                            'message' => "Stok produk <strong>{$product->name}</strong> tersisa {$product->stock} item (batas minimum: {$product->min_stock}).
                                        Segera lakukan restock!",
                        ]);

                    }
                }
                $product->save();

                // 3. Catat ke stock_logs
                StockLog::create([
                    'product_id' => $product->id,
                    'type'       => 'out',
                    'quantity'   => $item['quantity'],
                    'note'       => 'Pengurangan stok dari transaksi pembayaran #' . $payment->id,
                ]);

            }

            DB::commit();

        return redirect()->route('payments.show', $payment->id)->with('success', 'Pembayaran dibuat, harap segera diselesaikan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pembayaran!');
        }

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
      $validatedData = $request->validate([
            'status' => 'required|string|in:pending,completed,failed',
        ]);

        $message = '';
        $memberMembership = MemberMembership::where('payment_id', $payment->id)->where('status', 'pending')->first();
        if ($memberMembership) {
            if($validatedData['status'] == 'completed') {
                    $duration = $memberMembership->membership->duration_days;
                    $data = [
                        'status' => 'active',
                        'start_date' => now(),
                        'end_date' => now()->addDays($duration)
                    ];
                    $payload = [
                        'user_id' => $payment->user->id,
                        'member_id' => $memberMembership->member_id,
                        'issued_at' => now()->toIsoString(),
                        'expires_at' => now()->addDays($duration)->toIsoString()
                    ];

                    $encrypted = Crypt::encryptString(json_encode($payload));

                    $encryptedData = $encrypted;

                    $result = Builder::create()
                        ->data($encryptedData)
                        ->size(350)
                        ->margin(10)
                        ->build();

                    $filename = 'qr/' . Str::uuid() . '.png';

                    Storage::disk('public')->put($filename, $result->getString());

                    $data['qr_code'] = $filename;
                    $memberMembership->update($data);
                    Member::where('user_id', $payment->user_id)->update(['status' => 'active']);

                    Mail::to($payment->user->email)->send(new UserQrCodeMail($payment->user, $filename));

                $message ='Pembayaran Selesai!';
            } else if($validatedData['status'] == 'failed'){
                $data = [
                        'status' => 'cancelled'
                    ];
                $memberMembership->update($data);
                $message = 'Pembayaran Gagal';
            }
        } else {
            if($validatedData['status'] == 'completed'){
                $message = 'Pembayaran Selesai';

            } else if($validatedData['status'] == 'failed') {
                $allItems = $payment->items;

                foreach($allItems as $item) {
                    $product = Product::find($item->item_id);
                    $product->stock = $product->stock + $item->quantity;

                    StockLog::create([
                        'product_id' => $item->item_id,
                        'type'       => 'in',
                        'quantity'   => $item->quantity,
                        'note'       => 'Penambahan stok dari transaksi pembayaran #' . $payment->id . '. Karena pembayaran gagal!',
                    ]);

                    $product->update();

                }
                $message = 'Pembayaran Gagal';

            }
        }

        $payment->update($validatedData);

        if($payment->user->role == 'guest' || $payment->user->role == 'member') {
            Mail::to($payment->user->email)->send(new PaymentReceiptMail($payment));
        }

        return redirect( route('payments.show', $payment->id) )->with('success', $message);
    }

    public function updatePaymentProof(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'payment_proof' => 'image|file|max:5120|mimes:jpg,jpeg,png,webp'
        ]);

        $validatedData['payment_proof'] = $request->file('payment_proof')->store('payment-proof-image', 'public');
        $validatedData['proof_date'] = now();
        $message = 'Berhasil Upload Bukti Pembayaran!';

        $payment->update($validatedData);

        return redirect( route('payments.show', $payment->id) )->with('success', $message);
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