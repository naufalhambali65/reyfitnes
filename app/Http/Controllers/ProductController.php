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
        'image'       => 'nullable|file|image|mimes:jpeg,png,jpg|max:5120',
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

        // PERBAIKAN: Hitung profit dari payment_items (bukan stock_logs)
        $monthlyProfits = collect(range(0, 11))->map(function ($i) use ($product) {

            $month = now()->subMonths($i)->month;
            $year = now()->subMonths($i)->year;

            // Ambil payment_item untuk produk ini di bulan tsb
            $sales = \App\Models\PaymentItem::where('item_type', 'App\\Models\\Product')
                ->where('item_id', $product->id)
                ->whereMonth('payment_items.created_at', $month)
                ->whereYear('payment_items.created_at', $year)
                ->join('payments', 'payment_items.payment_id', '=', 'payments.id')
                ->where('payments.status', 'completed') // hanya transaksi sukses
                ->select('payment_items.quantity', 'payment_items.price')
                ->get();

            // Hitung keuntungan
            $profit = $sales->sum(function ($item) use ($product) {
                return $item->quantity * ($item->price - $product->cost);
            });

            return $profit;

        })->reverse()->values();


        return view('dashboard.product-stocks.show', compact(
            'title',
            'product',
            'stockLogs',
            'months',
            'stockCounts',
            'monthlyProfits'
        ));
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
        'image'       => 'nullable|file|image|mimes:jpeg,png,jpg|max:5120',
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

    public function stockAdjust(Request $request)
    {
        $validatedData = $request->validate([
        'product_slug' => 'required|exists:products,slug',
        'quantity'     => 'required|integer|min:1',
        'note'        => 'nullable|string|max:255',
        ]);

        $product = Product::where('slug', $validatedData['product_slug'])->first();

        if($request->action == 'add') {
            $stock = $product->stock + $validatedData['quantity'];
            $product->update([
                'stock' => $stock,
                'status' => 'available'
            ]);

            $logsData = [
            'product_id' => $product->id,
            'quantity' => $validatedData['quantity'],
            'type' => 'in'
            ];

            StockLog::create($logsData);
        } else if ($request->action == 'subtract') {
            $stock = $product->stock - $validatedData['quantity'];
            if ($stock < 0) {
                return back()->with('error', 'Stok tidak boleh kurang dari 0.');
            }
            $status = $stock == 0 ? 'unavailable' : 'available';
            $product->update(['stock' => $stock, 'status' => $status]);

            $logsData = [
            'product_id' => $product->id,
            'quantity' => $validatedData['quantity'],
            'type' => 'out'
            ];
            StockLog::create($logsData);
        }

        return redirect()
        ->route('product-stocks.index')
        ->with('success', 'Stock berhasil diupdate');
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
