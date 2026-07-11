<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $query = Product::published()->ordered();

        if (in_array($kategori, ['umkm', 'hasil_tani', 'olahan'], true)) {
            $query->where('category', $kategori);
        } else {
            $kategori = 'all';
        }

        $products = $query->with('primaryImage')->paginate(9)->withQueryString();

        return view('pages.produk.index', compact('products', 'kategori'));
    }

    public function show(string $slug)
    {
        $product = Product::published()->where('slug', $slug)->with('images')->firstOrFail();

        // Desain detail produk hanya menyediakan tombol "Produk lainnya" menuju
        // katalog (bukan grid terkait), jadi tak perlu query produk lain di sini.
        return view('pages.produk.show', compact('product'));
    }
}
