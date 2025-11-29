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
    public function index()
    // {
    //     $title = 'Halaman Laporan';

    //     // =======================
    //     // PAYMENT REPORT
    //     // =======================
    //     $paymentsData = Payment::select(
    //             DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
    //             DB::raw("COUNT(*) as total")
    //         )
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('total', 'month')
    //         ->toArray();

    //     $paymentsPerMonthLabels = array_keys($paymentsData);
    //     $paymentsPerMonthValues = array_values($paymentsData);

    //     // Revenue Completed Only
    //     $revenueData = Payment::where('status', 'completed')
    //         ->select(
    //             DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
    //             DB::raw("SUM(amount) as total")
    //         )
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('total', 'month')
    //         ->toArray();

    //     $revenuePerMonthLabels = array_keys($revenueData);
    //     $revenuePerMonthValues = array_values($revenueData);

    //     // Payment Status
    //     $paymentStatusData = Payment::select('status', DB::raw('COUNT(*) as total'))
    //         ->groupBy('status')
    //         ->pluck('total', 'status')
    //         ->toArray();

    //     $paymentStatusLabels = array_keys($paymentStatusData);
    //     $paymentStatusValues = array_values($paymentStatusData);


    //     // =======================
    //     // PRODUCT REPORT
    //     // =======================
    //     $topProductsData = DB::table('payment_items')
    //         ->join('products', 'payment_items.item_id', '=', 'products.id')
    //         ->select('products.name', DB::raw('SUM(payment_items.quantity) as qty'))
    //         ->groupBy('products.name')
    //         ->orderByDesc('qty')
    //         ->limit(10)
    //         ->pluck('qty', 'name')
    //         ->toArray();

    //     $topProductsLabels = array_keys($topProductsData);
    //     $topProductsValues = array_values($topProductsData);


    //     $stockMovementData = StockLog::select(
    //             DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
    //             DB::raw("SUM(CASE WHEN type='in' THEN quantity ELSE -quantity END) as total")
    //         )
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('total', 'month')
    //         ->toArray();

    //     $stockMovementLabels = array_keys($stockMovementData);
    //     $stockMovementValues = array_values($stockMovementData);

    //     $lowStock = Product::whereColumn('stock', '<=', 'min_stock')->get();


    //     // =======================
    //     // MEMBERSHIP REPORT
    //     // =======================
    //     $membershipSalesData = MemberMembership::join('memberships', 'member_memberships.membership_id', '=', 'memberships.id')
    //         ->select('memberships.name', DB::raw('COUNT(*) as total'))
    //         ->groupBy('memberships.name')
    //         ->pluck('total', 'name')
    //         ->toArray();

    //     $membershipSalesLabels = array_keys($membershipSalesData);
    //     $membershipSalesValues = array_values($membershipSalesData);


    //     $membershipStatusData = MemberMembership::select('status', DB::raw('COUNT(*) as total'))
    //         ->groupBy('status')
    //         ->pluck('total', 'status')
    //         ->toArray();

    //     $membershipStatusLabels = array_keys($membershipStatusData);
    //     $membershipStatusValues = array_values($membershipStatusData);


    //     // =======================
    //     // ATTENDANCE REPORT
    //     // =======================
    //     $attendanceData = Attendance::select(
    //             DB::raw("DATE(check_in_at) as day"),
    //             DB::raw("COUNT(*) as total")
    //         )
    //         ->groupBy('day')
    //         ->orderBy('day')
    //         ->pluck('total', 'day')
    //         ->toArray();

    //     $attendancePerDayLabels = array_keys($attendanceData);
    //     $attendancePerDayValues = array_values($attendanceData);


    //     $attendanceStatusData = Attendance::select('status', DB::raw('COUNT(*) as total'))
    //         ->groupBy('status')
    //         ->pluck('total', 'status')
    //         ->toArray();

    //     $attendanceStatusLabels = array_keys($attendanceStatusData);
    //     $attendanceStatusValues = array_values($attendanceStatusData);


    //     // =======================
    //     // CLASS REPORT
    //     // =======================
    //     $popularClassesData = GymClass::select('name', DB::raw('COUNT(*) as total'))
    //         ->groupBy('name')
    //         ->pluck('total', 'name')
    //         ->toArray();

    //     $popularClassesLabels = array_keys($popularClassesData);
    //     $popularClassesValues = array_values($popularClassesData);


    //     return view('dashboard.reports.index', compact(
    //         'title',

    //         'paymentsPerMonthLabels',
    //         'paymentsPerMonthValues',

    //         'revenuePerMonthLabels',
    //         'revenuePerMonthValues',

    //         'paymentStatusLabels',
    //         'paymentStatusValues',

    //         'topProductsLabels',
    //         'topProductsValues',

    //         'stockMovementLabels',
    //         'stockMovementValues',

    //         'lowStock',

    //         'membershipSalesLabels',
    //         'membershipSalesValues',

    //         'membershipStatusLabels',
    //         'membershipStatusValues',

    //         'attendancePerDayLabels',
    //         'attendancePerDayValues',

    //         'attendanceStatusLabels',
    //         'attendanceStatusValues',

    //         'popularClassesLabels',
    //         'popularClassesValues'
    //     ));
    // }
    {
    // === SUMMARY CARD ===
        $title = 'Halaman Laporan';

        $totalMembersActive     = MemberMembership::where('status', 'active')->count();
        $totalMembersExpired    = MemberMembership::where('status', 'expired')->count();
        $totalBookingToday      = ClassBooking::whereDate('created_at', today())->count();
        $lowStockProducts       = Product::whereColumn('stock', '<=', 'min_stock')->count();
        $incomeThisMonth        = Payment::whereMonth('created_at', now()->month)->sum('amount');


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

        // === CHART: PENJUALAN / PEMBAYARAN PER BULAN ===
        $incomePerMonth = Payment::selectRaw("MONTH(created_at) as month, SUM(amount) as total")
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

            'membershipPerMonth'   => $membershipPerMonth,
            'bookingPerDay'        => $bookingPerDay,
            'incomePerMonth'       => $incomePerMonth,
        ]);
    }

}