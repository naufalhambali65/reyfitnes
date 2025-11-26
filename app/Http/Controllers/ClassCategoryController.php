<?php

namespace App\Http\Controllers;

use App\Models\ClassCategory;
use Illuminate\Http\Request;

class ClassCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Kategori Kelas';

        $classCategories = ClassCategory::latest()->get();

        return view('dashboard.class-categories.index', compact('title', 'classCategories'));
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validatedData['slug'] = generateUniqueSlug(ClassCategory::class, $validatedData['name']);


        ClassCategory::create($validatedData);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassCategory $classCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassCategory $classCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassCategory $classCategory)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->name != $classCategory->name) {
            $validatedData['slug'] = generateUniqueSlug(ClassCategory::class, $validatedData['name']);
        } else {
            $validatedData['slug'] = $classCategory->slug;
        }


        ClassCategory::where('id', $classCategory->id)->update($validatedData);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassCategory $classCategory)
    {
        $classCategory->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
