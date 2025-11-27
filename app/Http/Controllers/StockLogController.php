<?php

namespace App\Http\Controllers;

use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StockLogController extends Controller implements HasMiddleware
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
    public function show(StockLog $stockLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockLog $stockLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockLog $stockLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockLog $stockLog)
    {
        //
    }
}
