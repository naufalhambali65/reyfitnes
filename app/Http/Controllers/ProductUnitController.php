<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductUnitController extends Controller implements HasMiddleware
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductUnit $productUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductUnit $productUnit)
    {
        //
    }
}
