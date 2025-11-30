<?php

namespace App\Http\Controllers;

use App\Models\ClassCategory;
use App\Models\GymClass;
use App\Models\Membership;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class GymClassController extends Controller implements HasMiddleware
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
        $title = 'Daftar Semua Kelas';
        $categories = ClassCategory::latest()->get();
        $gymClasses = GymClass::latest()->get();

        return view('dashboard.classes.index', compact('title', 'categories', 'gymClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kelas Gym';
        $trainers = Trainer::where('status', 'active')->latest()->get();
        $memberships = Membership::where('status', 'available')->latest()->get();
        $categories = ClassCategory::all();

        return view('dashboard.classes.create', compact('title', 'trainers', 'memberships', 'categories' ));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'trainer_id' => 'required|exists:trainers,id',
            'membership_id' => 'required|exists:memberships,id',
            'category_id' => 'required|exists:class_categories,id',
            'status' => 'required|in:active,inactive',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120|nullable',
            'description' => 'nullable|string',
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('class-image', 'public');
        }

        $validatedData['slug'] = generateUniqueSlug(GymClass::class, $validatedData['name']);

        GymClass::create($validatedData);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil dibuat!');
    }


    /**
     * Display the specified resource.
     */
    public function show(GymClass $class)
    {
        $title = 'Detail Kelas Gym';

        return view('dashboard.classes.show', compact('title', 'class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GymClass $class)
    {
        $title = 'Tambah Kelas Gym';
        $trainers = Trainer::where('status', 'active')->latest()->get();
        $memberships = Membership::where('status', 'available')->latest()->get();
        $categories = ClassCategory::all();

        return view('dashboard.classes.edit', compact('title', 'trainers', 'memberships', 'categories', 'class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GymClass $class)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'trainer_id' => 'required|exists:trainers,id',
            'membership_id' => 'required|exists:memberships,id',
            'category_id' => 'required|exists:class_categories,id',
            'status' => 'required|in:active,inactive',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120|nullable',
            'description' => 'nullable|string',
        ]);

        if ($request->name != $class->name) {
            $validatedData['slug'] = generateUniqueSlug(GymClass::class, $validatedData['name']);
        } else {
            $validatedData['slug'] = $class->slug;
        }

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('class-image', 'public');
        }

        GymClass::where('id', $class->id)->update($validatedData);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GymClass $class)
    {
        if ($class->image) {
            Storage::disk('public')->delete($class->image);
        }
        GymClass::destroy($class->id);
        return redirect(route('classes.index'))->with('success', 'Data berhasil dihapus.');
    }
}
