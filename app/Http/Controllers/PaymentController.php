<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Riwayat Pembayaran';
        $payments = Payment::latest()->get();
        $totalAmountPayments =  Payment::sum('amount');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}