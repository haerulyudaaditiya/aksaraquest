<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Lesson;
use App\Models\CertificationAttempt;
use App\Models\Aksara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Services\AchievementService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

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

        $quiz = $user->quizzes()->create(['type' => 'arena']);
        $quiz->questions()->attach($questions->shuffle()); // Acak urutan soal agar tidak monoton
        return redirect()->route('arena.quiz.show', $quiz);
    }

    public function show(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        // Muat relasi yang dibutuhkan untuk judul dinamis
        $quiz->load(['lesson', 'aksara']);

        $allQuestionIds = $quiz->questions()->pluck('questions.id');
        $answeredQuestionIds = $quiz->answers()->pluck('question_id');
        $nextQuestionId = $allQuestionIds->diff($answeredQuestionIds)->first();

        if (!$nextQuestionId) {
            return redirect()->route('arena.quiz.results', $quiz);
        }

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

        $skill = $quiz->user->skillLevels()->firstOrNew(['aksara_id' => $question->aksara_id]);

        // Selalu catat kapan terakhir dilatih
        $skill->last_practiced_at = now();

        if ($isCorrect) {
            // Jika jawaban benar, tingkatkan streak dan perpanjang jadwal tinjauan
            $skill->correct_streak += 1;

            switch ($skill->correct_streak) {
                case 1:
                    $skill->level = 1; // Level "Belajar"
                    $skill->next_review_at = now()->addDay(); // Tinjau 1 hari lagi
                    break;
                case 2:
                    $skill->level = 1;
                    $skill->next_review_at = now()->addDays(3); // Tinjau 3 hari lagi
                    break;
                case 3:
                    $skill->level = 2; // Level "Dikuasai"
                    $skill->next_review_at = now()->addDays(7); // Tinjau 1 minggu lagi
                    break;
                default:
                    // Jika sudah master (streak > 3), perpanjang terus
                    $skill->level = 2;
                    $skill->next_review_at = now()->addMonth(); // Tinjau 1 bulan lagi
            }

        } else {
            // Jika jawaban salah, reset streak dan jadwalkan tinjauan ulang SEGERA
            $skill->correct_streak = 0;
            $skill->level = 1; // Kembali ke level "Belajar"
            $skill->next_review_at = now()->addHour(); // Harus segera ditinjau lagi.
        }

        $skill->save();

        return redirect()->route('arena.quiz.show', $quiz);
    }

    /**
     * Menampilkan hasil kuis dan memproses semua logika pasca-kuis.
     */
    public function results(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        // 1. Hitung Skor
        $correctAnswers = $quiz->answers()->where('is_correct', true)->count();
        $totalQuestions = $quiz->questions()->count();
        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $quiz->update(['score' => $score]);

        $user = Auth::user();

        // 2. Hitung & Tambahkan XP
        $xpGained = $correctAnswers * 10;
        $levelBefore = $user->level;
        $user->increment('xp', $xpGained);

        // 3. Cek Kenaikan Level
        $user->refresh();
        $levelAfter = $user->level;
        $levelUp = ($levelAfter > $levelBefore);

        // 4. Logika Streak Harian
        $today = Carbon::today();
        $lastActivity = $user->last_activity_at ? Carbon::parse($user->last_activity_at)->today() : null;
        if ($lastActivity) {
            if ($lastActivity->isYesterday()) {
                $user->streak_count += 1;
            } else if (!$lastActivity->isToday()) {
                $user->streak_count = 1;
            }
        } else {
            $user->streak_count = 1;
        }
        $user->last_activity_at = now();
        $user->save();

        // 5. Logika Kontekstual Berdasarkan Tipe Kuis
        $certificationAttempt = null;
        $flashMessage = '';

        if ($quiz->type === 'lesson' && $score >= 80) {
            $user->lessonProgress()->updateOrCreate(
                ['user_id' => $user->id, 'lesson_id' => $quiz->lesson_id],
                ['completed_at' => now()]
            );
            $flashMessage = 'win';
        }
        else if ($quiz->type === 'certification') {
            $passed = $score >= 90;
            $certificationAttempt = CertificationAttempt::create([
                'user_id' => $user->id,
                'score' => $score,
                'passed' => $passed,
                'completed_at' => now(),
            ]);

            $flashMessage = $passed ? 'win' : 'lose';

        }
        else {
            $flashMessage = $score >= 80 ? 'win' : 'lose';
        }

        // 6. Cek & Berikan Achievement
        (new AchievementService())->checkAndAwardAchievements($user, $quiz);

        // 7. Kirim semua data ke Frontend
        return Inertia::render('Arena/Results', [
            'quiz' => $quiz,
            'score' => $score,
            'correct' => $correctAnswers,
            'total' => $totalQuestions,
            'xpGained' => $xpGained,
            'levelUp' => $levelUp,
            'newLevel' => $levelAfter,
            'certificationAttempt' => $certificationAttempt,
        ])->with('playSound', $flashMessage);
    }
}