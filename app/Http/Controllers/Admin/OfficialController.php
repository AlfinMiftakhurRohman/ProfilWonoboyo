<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::ordered()->get()->groupBy('group');

        return view('admin.officials.index', compact('officials'));
    }

    public function create()
    {
        return view('admin.officials.form', ['official' => new Official(['group' => 'perangkat', 'sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['photo'] = $this->storeUpload($request);

        $official = Official::create($data);
        $this->enforceSingleHead($official);

        return redirect()->route('admin.officials.index')->with('success', 'Perangkat desa ditambahkan.');
    }

    public function edit(Official $official)
    {
        return view('admin.officials.form', compact('official'));
    }

    public function update(Request $request, Official $official)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $this->deleteFile($official->photo);
            $data['photo'] = $this->storeUpload($request);
        }
        if ($request->boolean('remove_photo')) {
            $this->deleteFile($official->photo);
            $data['photo'] = null;
        }

        $official->update($data);
        $this->enforceSingleHead($official);

        return redirect()->route('admin.officials.index')->with('success', 'Data perangkat diperbarui.');
    }

    public function destroy(Official $official)
    {
        $this->deleteFile($official->photo);
        $official->delete();

        return back()->with('success', 'Perangkat desa dihapus.');
    }

    // --- helper ---

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'group' => 'required|in:perangkat,bpd',
            'sort_order' => 'nullable|integer',
            'is_head' => 'nullable|boolean',
            'photo' => 'nullable|image|max:4096',
        ]) + ['is_head' => $request->boolean('is_head'), 'sort_order' => (int) $request->input('sort_order', 0)];
    }

    /** Kepala desa hanya boleh satu: bila baris ini head, batalkan head lainnya. */
    private function enforceSingleHead(Official $official): void
    {
        if ($official->is_head) {
            Official::where('id', '!=', $official->id)->where('is_head', true)->update(['is_head' => false]);
        }
    }

    private function storeUpload(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }
        $file = $request->file('photo');
        $name = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/officials'), $name);
        return $name;
    }

    private function deleteFile(?string $name): void
    {
        if ($name && is_file($path = public_path('uploads/officials/' . $name))) {
            @unlink($path);
        }
    }
}
