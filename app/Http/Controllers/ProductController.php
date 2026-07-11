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

        // "Produk lainnya": kategori sama, kecualikan yang dibuka, dibatasi.
        $others = Product::published()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->ordered()
            ->with('primaryImage')
            ->take(3)
            ->get();

        return view('pages.produk.show', compact('product', 'others'));
    }
}
