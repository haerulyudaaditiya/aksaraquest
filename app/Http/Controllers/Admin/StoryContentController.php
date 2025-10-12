<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\StoryContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoryContentController extends Controller
{
    /**
     * Menampilkan editor konten untuk satu dongeng.
     */
    public function index(Story $story)
    {
        // Ambil data dongeng beserta semua kontennya, dikelompokkan per paragraf
        $story->load('contents');
        $paragraphs = $story->contents->groupBy('paragraph_number');

        return Inertia::render('Admin/Stories/ContentEditor', [
            'story' => $story,
            'paragraphs' => $paragraphs,
        ]);
    }

    /**
     * Menyimpan kata baru ke dalam sebuah dongeng.
     */
    public function store(Request $request, Story $story)
    {
        $validated = $request->validate([
            'aksara_word' => 'required|string',
            'latin_word' => 'required|string',
            'paragraph_number' => 'required|integer|min:1',
        ]);

        // Tentukan urutan kata baru di dalam paragraf
        $lastOrder = $story->contents()->where('paragraph_number', $validated['paragraph_number'])->max('order_in_paragraph');

        $story->contents()->create([
            'aksara_word' => $validated['aksara_word'],
            'latin_word' => $validated['latin_word'],
            'paragraph_number' => $validated['paragraph_number'],
            'order_in_paragraph' => $lastOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Kata baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data satu kata.
     */
    public function update(Request $request, StoryContent $content)
    {
        $validated = $request->validate([
            'aksara_word' => 'required|string',
            'latin_word' => 'required|string',
        ]);

        $content->update($validated);

        return redirect()->back()->with('success', 'Kata berhasil diperbarui.');
    }

    /**
     * Menghapus satu kata dari dongeng.
     */
    public function destroy(StoryContent $content)
    {
        $content->delete();
        return redirect()->back()->with('success', 'Kata berhasil dihapus.');
    }
}
