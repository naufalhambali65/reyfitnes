<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberMembership;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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

        return view('dashboard.members.create', compact('title', 'users', 'members', 'memberships'));
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
        //
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

    public function payment()
    {
}
}