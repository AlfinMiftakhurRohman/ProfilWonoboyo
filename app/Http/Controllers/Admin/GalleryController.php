<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::orderBy('sort_order')->orderByDesc('id')->paginate(24);

        return view('admin.gallery.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['photo' => new Gallery(['ratio' => '1/1', 'sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->storeUpload($request);

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto ditambahkan ke galeri.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.form', ['photo' => $gallery]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deleteFile($gallery->image);
            $data['image'] = $this->storeUpload($request);
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->deleteFile($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Foto dihapus dari galeri.');
    }

    // --- helper ---

    private function validated(Request $request, bool $requireImage = false): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string|max:255',
            'ratio' => 'required|in:1/1,4/3,3/4,3/2,2/3,16/9',
            'sort_order' => 'nullable|integer',
            'image' => ($requireImage ? 'required' : 'nullable').'|image|max:4096',
        ]) + ['sort_order' => (int) $request->input('sort_order', 0)];
    }

    private function storeUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }
        $file = $request->file('image');
        $name = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/galleries'), $name);

        return $name;
    }

    private function deleteFile(?string $name): void
    {
        if ($name && is_file($path = public_path('uploads/galleries/'.$name))) {
            @unlink($path);
        }
    }
}
