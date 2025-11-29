<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin')
        ];
    }

        public function toggleRole(User $user)
    {
        $user->role = $user->role === 'admin' ? 'super_admin' : 'admin';
        $user->save();

        return back()->with('success', 'Role berhasil diubah!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Manajemen Admin';

       $admins = User::whereIn('role', ['admin', 'super_admin'])
        ->orderByRaw("CASE WHEN role = 'super_admin' THEN 1 ELSE 2 END")
        ->get();

        return view('dashboard.admins.index', compact('title', 'admins'));
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
    public function show(User $admin)
    {
        $title = 'Detail Admin';

        $user = $admin;
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        return view('dashboard.admins.show', compact('user', 'title'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}