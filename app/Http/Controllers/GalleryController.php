<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::ordered()->paginate(12);

        return view('pages.galeri', compact('photos'));
    }
}
