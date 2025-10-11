<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aksara;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AksaraController extends Controller
{
    /**
     * Menampilkan daftar semua aksara untuk dikelola.
     */
    public function index()
    {
        return Inertia::render('Admin/Aksara/Index', [
            'aksaras' => Aksara::orderBy('latin')->get(['id', 'character', 'latin']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Aksara/Create');
    }

    /**
     * METHOD BARU: Menyimpan aksara baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi semua input
        $validated = $request->validate([
            'character' => 'required|string|max:10',
            'latin' => 'required|string|max:255',
            'philosophy' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3', // Validasi file audio
        ]);

        $audioPath = null;
        if ($request->hasFile('audio')) {
            // Simpan file audio ke storage/app/public/audio
            // dan dapatkan path-nya untuk disimpan ke database
            $audioPath = $request->file('audio')->store('audio', 'public');
        }

        Aksara::create([
            'character' => $validated['character'],
            'latin' => $validated['latin'],
            'philosophy' => $validated['philosophy'],
            'audio_url' => $audioPath ? Storage::url($audioPath) : null, // Simpan URL publik
        ]);

        return redirect()->route('admin.aksara.index')->with('success', 'Aksara baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit satu aksara.
     */
    public function edit(Aksara $aksara)
    {
        return Inertia::render('Admin/Aksara/Edit', [
            'aksara' => $aksara,
        ]);
    }

    /**
     * Memproses dan menyimpan perubahan data aksara.
     */
    public function update(Request $request, Aksara $aksara)
    {
        // Validasi data yang masuk
        $request->validate([
            'philosophy' => 'required|string',
        ]);

        // Update data di database
        $aksara->update([
            'philosophy' => $request->philosophy,
        ]);

        // Kembalikan ke halaman daftar aksara
        return redirect()->route('admin.aksara.index')->with('success', 'Data Aksara berhasil diperbarui.');
    }

    public function destroy(Aksara $aksara)
    {
        // Hapus file audio dari storage jika ada
        if ($aksara->audio_url) {
            // Konversi URL publik kembali ke path storage
            $path = str_replace('/storage/', '', $aksara->audio_url);
            Storage::disk('public')->delete($path);
        }

        // Hapus record dari database
        $aksara->delete();

        return redirect()->route('admin.aksara.index')->with('success', 'Aksara berhasil dihapus.');
    }
}
