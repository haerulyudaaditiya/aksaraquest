<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aksara;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Questions/Index', [
            'questions' => Question::with('aksara')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Questions/Create', [
            'aksaras' => Aksara::orderBy('latin')->get(['id', 'character', 'latin']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aksara_id' => 'required|exists:aksaras,id',
            'body' => 'required|string|max:255',
            'type' => ['required', Rule::in(['character_to_latin', 'latin_to_character', 'audio_to_latin', 'audio_to_character'])],
            'options' => 'required|array|min:4',
            'correct_answer' => 'required|string',
        ]);

        $aksara = Aksara::find($validated['aksara_id']);
        $validated['character'] = $aksara->character;

        Question::create($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Soal baru berhasil ditambahkan.');
    }

    public function edit(Question $question)
    {
        return Inertia::render('Admin/Questions/Edit', [
            'question' => $question,
            'aksaras' => Aksara::orderBy('latin')->get(['id', 'character', 'latin']),
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'aksara_id' => 'required|exists:aksaras,id',
            'body' => 'required|string|max:255',
            'type' => ['required', Rule::in(['character_to_latin', 'latin_to_character', 'audio_to_latin', 'audio_to_character'])],
            'options' => 'required|array|min:4',
            'correct_answer' => 'required|string',
        ]);

        $aksara = Aksara::find($validated['aksara_id']);
        $validated['character'] = $aksara->character;

        $question->update($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Data Soal berhasil diperbarui.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil dihapus.');
    }
}
