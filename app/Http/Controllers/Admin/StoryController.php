<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Stories/Index', [
            'stories' => Story::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Stories/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'order' => 'required|integer',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        Story::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'cover_image_url' => $coverPath ? Storage::url($coverPath) : null,
        ]);

        return redirect()->route('admin.stories.index')->with('success', 'Dongeng baru berhasil ditambahkan.');
    }

    public function edit(Story $story)
    {
        return Inertia::render('Admin/Stories/Edit', [
            'story' => $story,
        ]);
    }

    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'order' => 'required|integer',
        ]);

        $coverPath = $story->cover_image_url;
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($story->cover_image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $story->cover_image_url));
            }
            $coverPath = Storage::url($request->file('cover_image')->store('covers', 'public'));
        }

        $story->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'cover_image_url' => $coverPath,
        ]);

        return redirect()->route('admin.stories.index')->with('success', 'Data dongeng berhasil diperbarui.');
    }

    public function destroy(Story $story)
    {
        // Hapus gambar sampul dari storage
        if ($story->cover_image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $story->cover_image_url));
        }
        $story->delete();
        return redirect()->route('admin.stories.index')->with('success', 'Dongeng berhasil dihapus.');
    }
}
