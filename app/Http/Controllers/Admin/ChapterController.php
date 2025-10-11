<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChapterController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Chapters/Index', [
            'chapters' => Chapter::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Chapters/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        Chapter::create($validated);
        return redirect()->route('admin.chapters.index')->with('success', 'Bab baru berhasil ditambahkan.');
    }

    public function edit(Chapter $chapter)
    {
        return Inertia::render('Admin/Chapters/Edit', [
            'chapter' => $chapter,
        ]);
    }

    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $chapter->update($validated);
        return redirect()->route('admin.chapters.index')->with('success', 'Data Bab berhasil diperbarui.');
    }

    public function destroy(Chapter $chapter)
    {
        // Pastikan pelajaran di dalamnya juga terhapus (karena ada cascadeOnDelete)
        $chapter->delete();
        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil dihapus.');
    }
}
