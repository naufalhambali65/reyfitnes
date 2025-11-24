<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BankController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Bank';
        $banks = Bank::all();
        return view('dashboard.banks.index', compact('title', 'banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Rekening Bank';
        return view('dashboard.banks.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'status' => 'required|in:active,inactive',
            'description' => 'required|string',
        ]);

        $validatedData['slug'] = generateUniqueSlug(Bank::class, $validatedData['name']);

        Bank::create($validatedData);

        return redirect( route('banks.index') )->with('success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        $title = 'Detail Rekening Bank';

        return view('dashboard.banks.show', compact('title', 'bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        $title = 'Edit Rekening Bank';
        return view('dashboard.banks.edit', compact('title', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'status' => 'required|in:active,inactive',
            'description' => 'required|string',
        ]);

        if ($request->name != $bank->name) {
            $validatedData['slug'] = generateUniqueSlug(Bank::class, $validatedData['name']);
        } else {
            $validatedData['slug'] = $bank->slug;
        }

        Bank::where('slug', $bank->slug)->update($validatedData);

        return redirect( route('banks.index') )->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        Bank::destroy($bank->id);
        return redirect(route('banks.index'))->with('success', 'Data berhasil dihapus.');
    }
}
