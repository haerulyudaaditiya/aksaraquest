<?php

namespace App\Http\Controllers;

use App\Models\Aksara;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AtlasController extends Controller
{
    /**
     * Menampilkan halaman utama The Atlas.
     */
    public function index()
    {
        // 1. Ambil semua data aksara dari database, urutkan berdasarkan abjad latin.
        $aksaras = Aksara::orderBy('latin', 'asc')->get();

        // 2. Kirim data ke komponen Vue menggunakan Inertia.
        return Inertia::render('Atlas/Index', [
            'aksaras' => $aksaras,
        ]);
    }

    public function show(Aksara $aksara)
    {
        $aksara->load('lessons');

        return Inertia::render('Atlas/Show', [
            'aksara' => $aksara,
            'lesson' => $aksara->lessons->first(),
        ]);
    }
}
