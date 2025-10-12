<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoryController extends Controller
{
    /**
     * Menampilkan halaman daftar dongeng (rak buku).
     */
    public function index()
    {
        return Inertia::render('Story/Index', [
            'stories' => Story::orderBy('order')->get(),
        ]);
    }

    /**
     * Menampilkan halaman untuk membaca satu dongeng.
     */
    public function show(Story $story)
    {
        // Ambil data dongeng beserta semua kontennya (kata per kata)
        $story->load('contents');

        // Kelompokkan konten berdasarkan nomor paragraf
        $paragraphs = $story->contents->groupBy('paragraph_number');

        return Inertia::render('Story/Show', [
            'story' => $story,
            'paragraphs' => $paragraphs,
        ]);
    }
}
