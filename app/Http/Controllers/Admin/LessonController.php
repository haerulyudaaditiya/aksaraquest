<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Aksara;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lessons/Index', [
            'lessons' => Lesson::with('chapter')->orderBy('chapter_id')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Lessons/Create', [
            'chapters' => Chapter::orderBy('order')->get(['id', 'title']),
            'aksaras' => Aksara::orderBy('latin')->get(['id', 'character', 'latin']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
            'chapter_id' => 'required|exists:chapters,id',
            'aksara_ids' => 'required|array',
        ]);

        $lesson = Lesson::create($validated);
        $lesson->aksaras()->sync($validated['aksara_ids']);

        return redirect()->route('admin.lessons.index')->with('success', 'Pelajaran baru berhasil ditambahkan.');
    }

    public function edit(Lesson $lesson)
    {
        $lesson->load('aksaras'); // Muat data aksara yang sudah terhubung
        return Inertia::render('Admin/Lessons/Edit', [
            'lesson' => $lesson,
            'chapters' => Chapter::orderBy('order')->get(['id', 'title']),
            'aksaras' => Aksara::orderBy('latin')->get(['id', 'character', 'latin']),
            'selectedAksaraIds' => $lesson->aksaras->pluck('id'),
        ]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
            'chapter_id' => 'required|exists:chapters,id',
            'aksara_ids' => 'required|array',
        ]);

        $lesson->update($validated);
        $lesson->aksaras()->sync($validated['aksara_ids']);

        return redirect()->route('admin.lessons.index')->with('success', 'Data Pelajaran berhasil diperbarui.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->aksaras()->detach(); // Lepaskan semua hubungan dengan aksara
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Pelajaran berhasil dihapus.');
    }
}
