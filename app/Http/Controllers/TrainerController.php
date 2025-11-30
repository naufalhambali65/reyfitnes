<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedMail;
use App\Models\ClassBooking;
use App\Models\GymClass;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class TrainerController extends Controller implements HasMiddleware
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
        $title = 'Daftar Instruktur';
        $trainers = Trainer::latest()->get();

        return view('dashboard.trainers.index', compact('title', 'trainers'));
    }

    public function toggleStatus(Trainer $trainer)
    {
        $trainer->status = $trainer->status === 'active' ? 'inactive' : 'active';
        $trainer->save();

        return back()->with('success', 'Status berhasil diubah!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Instruktur';

        return view('dashboard.trainers.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|email',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'required|date|before:today',
            'phone' => 'required|regex:/^[0-9+\s\-]{8,15}$/',
            'image' => 'image|file|max:5120|nullable|mimes:jpg,jpeg,png,webp',
        ]);

        $validatedTrainerData = $request->validate([
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'years_experience' => 'integer|required',
        ]);
        $rawPassword = $request->password;

        $validatedData['password'] = bcrypt($validatedData['password']);

        $validatedData['role'] = 'trainer';

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('user-profile-image', 'public');
        }

        $user = User::create($validatedData);

        $validatedTrainerData['user_id'] = $user->id;

        Trainer::create($validatedTrainerData);

        // Kirim email
        Mail::to($user->email)->send(new UserCreatedMail($user, $rawPassword));
        return redirect()->route('trainers.index')->with('success', 'Instruktur berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainer $trainer)
    {
        $title = 'Detail Trainer';

        $classHistories = GymClass::where('trainer_id', $trainer->id)
            ->latest()
            ->get();

        $classBookings = ClassBooking::whereIn('gym_class_id', $classHistories->pluck('id'))->orderBy('gym_class_id')
        ->orderByRaw("
            FIELD(day,
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            )
        ")
        ->get();


        return view('dashboard.trainers.show', compact(
            'title',
            'trainer',
            'classHistories',
            'classBookings'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainer $trainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trainer $trainer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainer $trainer)
    {
        //
    }
}
