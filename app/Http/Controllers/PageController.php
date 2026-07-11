<?php

namespace App\Http\Controllers;

use App\Models\Official;

class PageController extends Controller
{
    public function profil()
    {
        return view('pages.profil');
    }

    public function pemerintahan()
    {
        $head = Official::head();
        $perangkat = Official::perangkat()->ordered()->get();
        $bpd = Official::bpd()->ordered()->get();

        return view('pages.pemerintahan', compact('head', 'perangkat', 'bpd'));
    }

    public function potensi()
    {
        return view('pages.potensi');
    }

    public function kontak()
    {
        return view('pages.kontak');
    }
}
