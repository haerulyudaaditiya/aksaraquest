<?php

namespace App\Http\Controllers;

use App\Models\Aksara;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FocusController extends Controller
{
    /**
     * Menampilkan halaman "Fokus Latihan" dengan daftar aksara
     * yang sudah dikuasai dan yang perlu dilatih.
     */
    public function index()
    {
        $user = Auth::user();
        $allAksara = Aksara::all();
        $skillLevels = $user->skillLevels()->get()->keyBy('aksara_id');

        $masteredAksara = [];
        $weakAksara = [];

        foreach ($allAksara as $aksara) {
            $skill = $skillLevels->get($aksara->id);

            // Jika level skill 2 atau lebih, anggap sudah dikuasai
            if ($skill && $skill->level >= 2) {
                $masteredAksara[] = $aksara;
            } else {
                // Jika belum ada datanya atau level di bawah 2, anggap perlu dilatih
                $weakAksara[] = $aksara;
            }
        }

        return Inertia::render('Focus/Index', [
            'masteredAksara' => $masteredAksara,
            'weakAksara' => $weakAksara,
        ]);
    }

    /**
     * Memulai sesi kuis latihan khusus untuk satu aksara.
     */
    public function startPractice(Aksara $aksara)
    {
        $user = Auth::user();
        $practiceSize = 5; // Kita buat 5 soal untuk latihan fokus

        // Ambil 5 soal acak yang HANYA berhubungan dengan aksara ini
        $questions = Question::where('aksara_id', $aksara->id)
            ->inRandomOrder()
            ->take($practiceSize)
            ->pluck('id');

        // Pengecekan jika bank soal untuk aksara ini kurang
        if ($questions->count() < $practiceSize) {
            return redirect()->route('fokus.index')
                ->with('error', "Maaf, bank soal untuk aksara '{$aksara->latin}' belum cukup.");
        }

        // Buat sesi kuis baru dan lampirkan soal-soal latihan
        $quiz = $user->quizzes()->create();
        $quiz->questions()->attach($questions);

        // Arahkan ke halaman Arena yang sudah ada untuk mengerjakan kuis
        return redirect()->route('arena.quiz.show', $quiz);
    }
}
