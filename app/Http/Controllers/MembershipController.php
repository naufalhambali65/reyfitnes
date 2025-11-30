<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use App\Models\MemberMembership;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MembershipController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth',

            // super_admin & admin boleh akses semua
            new Middleware('role:super_admin,admin'),

            // guest & member hanya bisa akses index/show
            new Middleware('role:guest,member,super_admin,admin', only: ['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Paket Membership';
        $memberships = Membership::all();
        return view('dashboard.memberships.index', compact('title', 'memberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Paket Membership';
        return view('dashboard.memberships.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
            'description' => 'required|string',
            'features' => 'required|string',
        ]);

        $validatedData['slug'] = generateUniqueSlug(Membership::class, $validatedData['name']);

        Membership::create($validatedData);

        return redirect( route('memberships.index') )->with('success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     */

    public function show(Membership $membership)
    {
        $title = 'Detail Paket Membership';
        // total customer (ever purchased this membership)
        $totalCustomer = MemberMembership::where('membership_id', $membership->id)->count();

        // total active customers (status = active & end_date >= today)
        $totalActiveCustomer = MemberMembership::where('membership_id', $membership->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->count();

        // progress percent
        $progressPercent = $totalCustomer > 0 ? round($totalActiveCustomer / $totalCustomer * 100, 1) : 0;

        // list members who purchased this membership (latest first)
        $membersList = MemberMembership::
            where('membership_id', $membership->id)
            ->orderByDesc('start_date')->get();

        // Prepare monthly data for chart (last 12 months)
        $months = collect();
        $counts = collect();
        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $label = $dt->format('M Y');
            $start = $dt->copy()->startOfMonth()->toDateString();
            $end = $dt->copy()->endOfMonth()->toDateString();

            $count = MemberMembership::where('membership_id', $membership->id)
                ->whereBetween('start_date', [$start, $end])
                ->count();

            $months->push($label);
            $counts->push($count);
        }

        // Class Included
        $classes = GymClass::where('membership_id', $membership->id)->latest()->get();


        return view('dashboard.memberships.show', compact(
            'title',
            'membership',
            'totalCustomer',
            'totalActiveCustomer',
            'progressPercent',
            'membersList',
            'months',
            'counts',
            'classes'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        $title = 'Edit Paket Membership';
        return view('dashboard.memberships.edit', compact('title', 'membership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
            'description' => 'required|string',
            'features' => 'required|string',
        ]);

        if ($request->name != $membership->name) {
            $validatedData['slug'] = generateUniqueSlug(Membership::class, $validatedData['name']);
        } else {
            $validatedData['slug'] = $membership->slug;
        }

        Membership::where('slug', $membership->slug)->update($validatedData);

        return redirect( route('memberships.index') )->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        Membership::destroy($membership->id);
        return redirect(route('memberships.index'))->with('success', 'Data berhasil dihapus.');
    }
}
