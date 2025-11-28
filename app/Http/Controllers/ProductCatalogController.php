<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductCatalogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin,admin'),
        ];
    }
    public function index()
    {
        $title = 'Katalog Produk';
        $products = Product::latest()->get();

        $banks = Bank::latest()->get();

        return view('dashboard.product-catalogs.index', compact('title', 'products', 'banks'));
    }
}
