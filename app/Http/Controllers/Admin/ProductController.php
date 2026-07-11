<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('primaryImage')
            ->when($request->filled('kategori'), fn ($q) => $q->where('category', $request->kategori))
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(['availability' => 'tersedia'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($request->input('slug') ?: $request->name);

        $product = Product::create($data);
        $this->syncNewImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dibuat.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin.products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($request->input('slug') ?: $request->name, $product->id);
        $product->update($data);

        // Hapus gambar terpilih
        foreach ((array) $request->input('delete_images', []) as $imageId) {
            if ($img = $product->images()->find($imageId)) {
                $this->deleteFile($img->image);
                $img->delete();
            }
        }

        $this->syncNewImages($request, $product);

        // Set gambar utama bila dipilih
        if ($request->filled('primary_image')) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $request->primary_image)->update(['is_primary' => true]);
        }
        $this->ensurePrimary($product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            $this->deleteFile($img->image);
        }
        $product->delete(); // product_images ikut terhapus (cascade)

        return back()->with('success', 'Produk dihapus.');
    }

    // --- helper ---

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'required|in:umkm,hasil_tani,olahan',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'seller_name' => 'required|string|max:120',
            'seller_wa' => 'nullable|string|max:30',
            'availability' => 'required|in:tersedia,habis,pre_order',
            'sort_order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:4096',
        ]) + ['is_published' => $request->boolean('is_published'), 'sort_order' => (int) $request->input('sort_order', 0)];
    }

    /** Simpan file gambar baru; jadikan yang pertama primary bila produk belum punya. */
    private function syncNewImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }
        foreach ($request->file('images') as $file) {
            $name = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $name);
            $product->images()->create([
                'image' => $name,
                'is_primary' => false,
                'sort_order' => $product->images()->count(),
            ]);
        }
        $this->ensurePrimary($product);
    }

    /** Pastikan tepat ada satu gambar utama. */
    private function ensurePrimary(Product $product): void
    {
        $product->refresh();
        if ($product->images()->where('is_primary', true)->exists()) {
            return;
        }
        if ($first = $product->images()->first()) {
            $first->update(['is_primary' => true]);
        }
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'produk';
        $slug = $base;
        $i = 2;
        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function deleteFile(?string $name): void
    {
        if ($name && is_file($path = public_path('uploads/products/'.$name))) {
            @unlink($path);
        }
    }
}
