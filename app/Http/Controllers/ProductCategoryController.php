<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductCategoryController extends Controller implements HasMiddleware
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
        $title = 'Daftar Kategori Produk';
        $categories = ProductCategory::latest()->get();
        $productUnits = ProductUnit::latest()->get();

        return view('dashboard.product-categories.index', compact('title', 'categories', 'productUnits'));
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
            'name'        => 'required|string|max:255'
        ]);

        $validatedData['slug'] = generateUniqueSlug(ProductCategory::class, $validatedData['name']);


        ProductCategory::create($validatedData);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255'
        ]);

        if ($request->name != $productCategory->name) {
            $validatedData['slug'] = generateUniqueSlug(ProductCategory::class, $validatedData['name']);
        } else {
            $validatedData['slug'] = $productCategory->slug;
        }


        ProductCategory::where('id', $productCategory->id)->update($validatedData);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->back()->with('success', 'Kategori produk berhasil dihapus!');
    }
}