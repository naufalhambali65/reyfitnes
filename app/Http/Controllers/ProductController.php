<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller implements HasMiddleware
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
        $title = 'List Produk';

        $products = Product::latest()->get();

        return view('dashboard.product-stocks.index', compact('title', 'products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'List Produk';

        $categories = ProductCategory::latest()->get();
        $units = ProductUnit::latest()->get();

        return view('dashboard.product-stocks.create', compact('title', 'categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'category_id' => 'required|exists:product_categories,id',
        'unit_id'     => 'required|exists:product_units,id',
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'cost'        => 'nullable|numeric',
        'stock'       => 'required|integer|min:0',
        'min_stock'   => 'required|integer|min:0',
        'description' => 'nullable|string',
        'image'       => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        'status'      => 'required|in:available,unavailable',
    ]);

    $validatedData['slug'] = generateUniqueSlug(Product::class, $validatedData['name']);

    // Upload image (jika ada)
    if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('product-image', 'public');
        }


    // Simpan ke database
    $result = Product::create($validatedData);

    if($result->stock > 0) {
        $logsData = [
            'product_id' => $result->id,
            'quantity' => $result->stock,
            'type' => 'in'
        ];

        StockLog::create($logsData);
    }

    return redirect()
        ->route('product-stocks.index')
        ->with('success', 'Produk berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product_stock)
    {
        $title = 'Detail Produk';
        $product = $product_stock;
        $stockLogs = $product->stockLogs()->latest()->get();

        // 12 bulan terakhir (untuk chart)
        $months = collect(range(0, 11))->map(function ($i) {
            return now()->subMonths($i)->translatedFormat('M Y');
        })->reverse()->values();

        $stockCounts = collect(range(0, 11))->map(function ($i) use ($product) {
            return $product->stockLogs()
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->count();
        })->reverse()->values();

        $monthlyProfits = collect(range(0, 11))->map(function ($i) use ($product) {
            $month = now()->subMonths($i)->month;
            $year = now()->subMonths($i)->year;

            // Ambil semua stock logs keluar untuk bulan ini
            $sales = $product->stockLogs()
                ->where('type', 'out')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get();

            // Hitung keuntungan
            $profit = $sales->sum(function ($log) use ($product) {
                return $log->quantity * ($product->price - $product->cost);
            });

            return $profit;
        })->reverse()->values();


        return view('dashboard.product-stocks.show',  compact('title', 'product', 'stockLogs', 'months', 'stockCounts', 'monthlyProfits'));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product_stock)
    {
        $title = 'Update Produk';

        $categories = ProductCategory::latest()->get();
        $units = ProductUnit::latest()->get();

        $product = $product_stock;

        return view('dashboard.product-stocks.edit', compact('title', 'categories', 'units', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product_stock)
    {
        $validatedData = $request->validate([
        'category_id' => 'required|exists:product_categories,id',
        'unit_id'     => 'required|exists:product_units,id',
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'cost'        => 'nullable|numeric',
        'stock'       => 'required|integer|min:0',
        'min_stock'   => 'required|integer|min:0',
        'description' => 'nullable|string',
        'image'       => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        'status'      => 'required|in:available,unavailable',
    ]);

    if ($request->name != $product_stock->name) {
            $validatedData['slug'] = generateUniqueSlug(Product::class, $validatedData['name']);
        } else {
            $validatedData['slug'] = $product_stock->slug;
        }

    if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('product-image', 'public');
        }


    if($validatedData['stock'] > 0 && $validatedData['stock'] > $product_stock->stock) {
        $logsData = [
            'product_id' => $product_stock->id,
            'quantity' => $validatedData['stock'] - $product_stock->stock,
            'type' => 'in'
        ];

        StockLog::create($logsData);
    }

    $product_stock->update($validatedData);
    return redirect()
        ->route('product-stocks.index')
        ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product_stock)
    {
        if($product_stock->image) {
            Storage::disk('public')->delete($product_stock->image);
        }

        $product_stock->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}