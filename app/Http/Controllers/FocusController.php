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

        $skillLevels = $user->skillLevels()->get();
        $dueAksaraIds = [];
        $masteredAksaraIds = [];

        foreach ($skillLevels as $skill) {
            if (is_null($skill->next_review_at) || $skill->next_review_at->isPast()) {
                $dueAksaraIds[] = $skill->aksara_id;
            } else {
                $masteredAksaraIds[] = $skill->aksara_id;
            }
        }

        $allAksaraIds = Aksara::pluck('id');
        $practicedAksaraIds = $skillLevels->pluck('aksara_id');
        $newAksaraIds = $allAksaraIds->diff($practicedAksaraIds);
        $reviewAksaraIds = collect($dueAksaraIds)->merge($newAksaraIds);
        $aksaraToReview = Aksara::whereIn('id', $reviewAksaraIds)->get();
        $masteredAksara = Aksara::whereIn('id', $masteredAksaraIds)->get();

        return Inertia::render('Focus/Index', [
            'masteredAksara' => $masteredAksara,
            'dueAksara' => $aksaraToReview, 
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
        $quiz = $user->quizzes()->create(['type' => 'focus', 'aksara_id' => $aksara->id]);
        $quiz->questions()->attach($questions);

        // Arahkan ke halaman Arena yang sudah ada untuk mengerjakan kuis
        return redirect()->route('arena.quiz.show', $quiz);
    }
}
