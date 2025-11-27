<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedMail;
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
            new Middleware('role:super_admin,admin'),
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

    // Riwayat kelas yang pernah dibawakan trainer
    // Relasi: GymClass -> trainer_id
    $classHistories = GymClass::where('trainer_id', $trainer->id)
        ->latest()
        ->get();

    // Jadwal mengajar trainer (jika ada relasi schedule)
    // Sesuaikan nama model dan kolom jika berbeda
    // $schedules = \App\Models\ClassSchedule::where('trainer_id', $trainer->id)
    //     ->with('class')
    //     ->orderBy('day')
    //     ->get();

    return view('dashboard.trainers.show', compact(
        'title',
        'trainer',
        'classHistories',
        // 'schedules'
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
