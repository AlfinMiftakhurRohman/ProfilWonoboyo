<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->filled('kategori'), fn ($q) => $q->where('category', $request->kategori))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($request->input('slug') ?: $request->title);
        $data['image'] = $this->storeUpload($request, 'image');
        [$data['attachment'], $data['attachment_name']] = $this->storeAttachment($request);
        $data['published_at'] = $this->resolvePublishedAt($data);

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($request->input('slug') ?: $request->title, $post->id);

        if ($request->hasFile('image')) {
            $this->deleteFile($post->image);
            $data['image'] = $this->storeUpload($request, 'image');
        }
        if ($request->boolean('remove_image')) {
            $this->deleteFile($post->image);
            $data['image'] = null;
        }

        if ($request->hasFile('attachment')) {
            $this->deleteFile($post->attachment);
            [$data['attachment'], $data['attachment_name']] = $this->storeAttachment($request);
        }

        $data['published_at'] = $this->resolvePublishedAt($data, $post);

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $this->deleteFile($post->image);
        $this->deleteFile($post->attachment);
        $post->delete();

        return back()->with('success', 'Berita dihapus.');
    }

    // --- helper ---

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'required|in:berita,pengumuman',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'author' => 'nullable|string|max:120',
            'image_caption' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:4096',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:8192',
        ]) + ['is_published' => $request->boolean('is_published')];
    }

    /** Tanggal tayang: dipakai apa adanya bila diisi; jika terbit tapi kosong → now. */
    private function resolvePublishedAt(array $data, ?Post $post = null)
    {
        if (! empty($data['published_at'])) {
            return $data['published_at'];
        }
        if (! empty($data['is_published'])) {
            return $post?->published_at ?? now();
        }

        return $post?->published_at;
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'berita';
        $slug = $base;
        $i = 2;
        while (Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storeUpload(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }
        $file = $request->file($field);
        $name = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/posts'), $name);

        return $name;
    }

    private function storeAttachment(Request $request): array
    {
        if (! $request->hasFile('attachment')) {
            return [null, null];
        }
        $file = $request->file('attachment');
        $name = Str::random(20).'.'.$file->getClientOriginalExtension();
        $original = $file->getClientOriginalName();
        $file->move(public_path('uploads/posts'), $name);

        return [$name, $original];
    }

    private function deleteFile(?string $name): void
    {
        if ($name && is_file($path = public_path('uploads/posts/'.$name))) {
            @unlink($path);
        }
    }
}
