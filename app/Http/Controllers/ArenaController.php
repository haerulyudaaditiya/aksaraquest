<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // <-- Import Rule untuk validasi
use Inertia\Inertia;
use App\Services\AchievementService;
use Carbon\Carbon;

class ArenaController extends Controller
{
    public function index()
    {
        return Inertia::render('Arena/Index');
    }

    public function start()
    {
        $user = Auth::user();
        $quizSize = 10; // Jumlah total soal dalam satu kuis

        // 1. Ambil semua level skill pengguna untuk setiap aksara
        $skillLevels = $user->skillLevels()->get()->keyBy('aksara_id');

        // 2. Ambil semua ID aksara yang ada
        $allAksaraIds = \App\Models\Aksara::pluck('id');

        // 3. Pisahkan aksara yang "lemah" (belum pernah dicoba atau masih dipelajari)
        $weakAksaraIds = $allAksaraIds->filter(function ($id) use ($skillLevels) {
            // Dianggap lemah jika belum ada datanya (level 0) atau levelnya masih 1
            return !isset($skillLevels[$id]) || $skillLevels[$id]->level < 2;
        });

        // 4. Ambil soal dari aksara yang lemah terlebih dahulu (misal, 7 soal)
        $weakQuestions = Question::whereIn('aksara_id', $weakAksaraIds)
            ->inRandomOrder()
            ->take(7)
            ->pluck('id');

        $questions = $weakQuestions;
        $remainingSize = $quizSize - $questions->count();

        // 5. Jika soal masih kurang, ambil sisanya dari semua soal yang ada
        if ($remainingSize > 0) {
            $remainingQuestions = Question::whereNotIn('id', $questions) // Hindari duplikat
                ->inRandomOrder()
                ->take($remainingSize)
                ->pluck('id');

            $questions = $questions->merge($remainingQuestions);
        }

        if ($questions->count() < $quizSize) {
            return redirect()->route('arena.index')
                ->with('error', 'Maaf, bank soal tidak cukup untuk memulai kuis saat ini.');
        }

        $quiz = $user->quizzes()->create();
        $quiz->questions()->attach($questions->shuffle()); // Acak urutan soal agar tidak monoton
        return redirect()->route('arena.quiz.show', $quiz);
    }

    public function show(Quiz $quiz)
    {
        // Pengecekan kepemilikan kuis (sudah bagus)
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $allQuestionIds = $quiz->questions()->pluck('questions.id');
        $answeredQuestionIds = $quiz->answers()->pluck('question_id');
        $nextQuestionId = $allQuestionIds->diff($answeredQuestionIds)->first();

        if (!$nextQuestionId) {
            return redirect()->route('arena.quiz.results', $quiz);
        }

        // PENYEMPURNAAN 2: Gunakan Eager Loading untuk efisiensi query.
        $question = Question::with('aksara')->find($nextQuestionId);

        return Inertia::render('Arena/Quiz', [
            'quiz' => $quiz,
            'question' => $question,
            'totalQuestions' => $allQuestionIds->count(),
            'answeredCount' => $answeredQuestionIds->count(),
        ]);
    }

    public function answer(Request $request, Quiz $quiz)
    {
        // PENYEMPURNAAN 3: Validasi bahwa soal adalah bagian dari kuis.
        $questionIdsInThisQuiz = $quiz->questions()->pluck('questions.id');

        $request->validate([
            'question_id' => ['required', 'exists:questions,id', Rule::in($questionIdsInThisQuiz)],
            'user_answer' => 'required|string',
        ]);

        $question = Question::find($request->question_id);
        $isCorrect = ($question->correct_answer === $request->user_answer);

        $quiz->answers()->create([
            'question_id' => $request->question_id,
            'user_answer' => $request->user_answer,
            'is_correct' => $isCorrect,
        ]);

        // ... (Logika skill level sudah bagus)
        $skill = $quiz->user->skillLevels()->firstOrNew(['aksara_id' => $question->aksara_id]);
        if ($isCorrect) {
            $skill->correct_streak += 1;
            if ($skill->correct_streak >= 3 && $skill->level < 2) { $skill->level = 2; }
            else { $skill->level = 1; }
        } else {
            $skill->correct_streak = 0;
        }
        $skill->save();

        return redirect()->route('arena.quiz.show', $quiz);
    }

    public function results(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        // Kode perhitungan skor dan XP yang sudah ada
        $correctAnswers = $quiz->answers()->where('is_correct', true)->count();
        $totalQuestions = $quiz->questions()->count();
        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $quiz->update(['score' => $score]);
        $xpGained = $correctAnswers * 10;

        $user = Auth::user();

        // Logika Level Up yang sudah ada
        $levelBefore = $user->level;
        $user->increment('xp', $xpGained);
        $user->refresh();
        $levelAfter = $user->level;
        $levelUp = ($levelAfter > $levelBefore);

        // --- LOGIKA STREAK BARU DIMASUKKAN DI SINI ---
        $today = Carbon::today();
        // Ambil tanggal aktivitas terakhir, jika ada
        $lastActivity = $user->last_activity_at ? Carbon::parse($user->last_activity_at)->today() : null;

        if ($lastActivity) {
            // Jika aktivitas terakhir adalah kemarin, lanjutkan streak
            if ($lastActivity->isYesterday()) {
                $user->streak_count += 1;
            }
            // Jika aktivitas terakhir bukan hari ini DAN bukan kemarin, reset streak ke 1
            else if (!$lastActivity->isToday()) {
                $user->streak_count = 1;
            }
            // Jika sudah bermain hari ini, streak tidak berubah, hanya update waktunya
        } else {
            // Jika ini aktivitas pertama kali, mulai streak dari 1
            $user->streak_count = 1;
        }

        // Selalu perbarui waktu aktivitas terakhir ke sekarang
        $user->last_activity_at = now();
        $user->save();
        // --- AKHIR LOGIKA STREAK ---

        // Pengecekan Achievement yang sudah ada
        (new AchievementService())->checkAndAwardAchievements($user);

        return Inertia::render('Arena/Results', [
            'quiz' => $quiz,
            'score' => $score,
            'correct' => $correctAnswers,
            'total' => $totalQuestions,
            'xpGained' => $xpGained,
            'levelUp' => $levelUp,
            'newLevel' => $levelAfter,
        ]);
    }
}
