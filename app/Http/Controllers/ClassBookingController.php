<?php

namespace App\Http\Controllers;

use App\Models\ClassBooking;
use App\Models\Member;
use App\Models\MemberMembership;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClassBookingController extends Controller implements HasMiddleware
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
        $title = 'Booking Kelas';

        $classBookings = ClassBooking::latest()->get();

        $members = Member::whereHas('memberMemberships', function ($query) {
            $query->where('status', 'active')
                ->where('end_date', '>=', today());
        })->get();

        return view('dashboard.class-bookings.index', compact('title', 'members', 'classBookings'));
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
        $validatedData = $request->validate([
            'member_id'        => 'required',
            'gym_class_id' => 'required',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'
        ]);


        ClassBooking::create($validatedData);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassBooking $classBooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassBooking $classBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassBooking $classBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassBooking $classBooking)
    {
        //
    }
}