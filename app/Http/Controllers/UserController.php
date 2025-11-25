<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
    return [
            'auth',
            new Middleware('role:super_admin,admin')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'required|date|before:today',
            'phone' => 'required|regex:/^[0-9+\s\-]{8,15}$/',
            'image' => 'image|file|max:5120|nullable|mimes:jpg,jpeg,png,webp',
        ]);

        $rawPassword = $request->password;

        $validatedData['password'] = bcrypt($validatedData['password']);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('user-profile-image', 'public');
        }

        $user = User::create($validatedData);

        // Kirim email
        Mail::to($user->email)->send(new UserCreatedMail($user, $rawPassword));

        if($request->member){
            return redirect()->route('members.index')->with('success', 'Akun berhasil dibuat!');
        }
        else {
            return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
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
        dd($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}