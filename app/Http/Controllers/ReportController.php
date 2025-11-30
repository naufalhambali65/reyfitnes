<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Membership;
use App\Models\MemberMembership;
use App\Models\Attendance;
use App\Models\ClassBooking;
use App\Models\GymClass;
use App\Models\PaymentItem;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin'),
        ];
    }
    // public function index()
    // {
    // // === SUMMARY CARD ===
    //     $title = 'Halaman Laporan';

    //     $totalMembersActive     = MemberMembership::where('status', 'active')->count();
    //     $totalMembersExpired    = MemberMembership::where('status', 'expired')->count();
    //     $totalBookingToday      = ClassBooking::whereDate('created_at', today())->count();
    //     $lowStockProducts       = Product::whereColumn('stock', '<=', 'min_stock')->count();
    //     $incomeThisMonth        = Payment::whereMonth('created_at', now()->month)->sum('amount');


    //     // === CHART: MEMBERSHIP PER BULAN ===
    //     $membershipPerMonth = MemberMembership::selectRaw("MONTH(created_at) as month, COUNT(*) as total")
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('total', 'month');

    //     // === CHART: BOOKING KELAS PER HARI ===
    //     $bookingPerDay = ClassBooking::selectRaw("DATE(created_at) as date, COUNT(*) as total")
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->pluck('total', 'date');

    //     // === CHART: PENJUALAN / PEMBAYARAN PER BULAN ===
    //     $incomePerMonth = Payment::selectRaw("MONTH(created_at) as month, SUM(amount) as total")
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('total', 'month');




    //     return view('dashboard.reports.index', [
    //         'title' => $title,
    //         'totalMembersActive'   => $totalMembersActive,
    //         'totalMembersExpired'  => $totalMembersExpired,
    //         'totalBookingToday'    => $totalBookingToday,
    //         'lowStockProducts'     => $lowStockProducts,
    //         'incomeThisMonth'      => $incomeThisMonth,

    //         'membershipPerMonth'   => $membershipPerMonth,
    //         'bookingPerDay'        => $bookingPerDay,
    //         'incomePerMonth'       => $incomePerMonth,
    //     ]);
    // }

    public function index()
{
    $title = 'Halaman Laporan';

    // === SUMMARY CARD ===
    $totalMembersActive     = MemberMembership::where('status', 'active')->count();
    $totalMembersExpired    = MemberMembership::where('status', 'expired')->count();
    $totalBookingToday      = ClassBooking::whereDate('created_at', today())->count();
    $lowStockProducts       = Product::whereColumn('stock', '<=', 'min_stock')->count();

    $incomeThisMonth        = Payment::whereMonth('created_at', now()->month)->sum('amount');


    // === MEMBERSHIP INCOME (BULAN INI) ===
    $membershipIncomeThisMonth = PaymentItem::whereMonth('created_at', now()->month)
        ->where('item_type', 'App\\Models\\Membership')
        ->sum('subtotal');

    // === PRODUCT SALES (BULAN INI) ===
    $productSalesThisMonth = PaymentItem::whereMonth('created_at', now()->month)
        ->where('item_type', 'App\\Models\\Product')
        ->sum('subtotal');

    // === PRODUCT PROFIT (BULAN INI) ===
    $productProfitThisMonth = PaymentItem::whereMonth('payment_items.created_at', now()->month)
        ->where('payment_items.item_type', 'App\\Models\\Product')
        ->join('products', 'payment_items.item_id', '=', 'products.id')
        ->selectRaw('SUM((payment_items.price - products.cost) * payment_items.quantity) as profit')
        ->value('profit');



    // === CHART: MEMBERSHIP PER BULAN ===
    $membershipPerMonth = MemberMembership::selectRaw("MONTH(created_at) as month, COUNT(*) as total")
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // === CHART: BOOKING KELAS PER HARI ===
    $bookingPerDay = ClassBooking::selectRaw("DATE(created_at) as date, COUNT(*) as total")
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total', 'date');

    // === CHART: PAYMENT / INCOME PER BULAN ===
    $incomePerMonth = Payment::selectRaw("MONTH(created_at) as month, SUM(amount) as total")
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // === CHART: PRODUCT SALES PER BULAN ===
    $productSalesPerMonth = PaymentItem::where('item_type', 'App\\Models\\Product')
        ->selectRaw("MONTH(created_at) as month, SUM(subtotal) as total")
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // === CHART: MEMBERSHIP INCOME PER BULAN ===
    $membershipIncomePerMonth = PaymentItem::where('item_type', 'App\\Models\\Membership')
        ->selectRaw("MONTH(created_at) as month, SUM(subtotal) as total")
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');


    return view('dashboard.reports.index', [
        'title' => $title,

        'totalMembersActive'   => $totalMembersActive,
        'totalMembersExpired'  => $totalMembersExpired,
        'totalBookingToday'    => $totalBookingToday,
        'lowStockProducts'     => $lowStockProducts,
        'incomeThisMonth'      => $incomeThisMonth,

        'membershipIncomeThisMonth' => $membershipIncomeThisMonth,
        'productSalesThisMonth'     => $productSalesThisMonth,
        'productProfitThisMonth'    => $productProfitThisMonth,

        'membershipPerMonth'   => $membershipPerMonth,
        'bookingPerDay'        => $bookingPerDay,
        'incomePerMonth'       => $incomePerMonth,

        'productSalesPerMonth'      => $productSalesPerMonth,
        'membershipIncomePerMonth'  => $membershipIncomePerMonth,
    ]);
}


}
