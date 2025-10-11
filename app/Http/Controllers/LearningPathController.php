<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;

class LearningPathController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil SEMUA Chapter, beserta relasi lessons-nya
        $chapters = Chapter::with(['lessons' => function ($query) {
            $query->with('aksaras')->orderBy('order'); // Pastikan aksaras juga di-load
        }])->orderBy('order')->get();

        // 2. Ambil SEMUA ID pelajaran yang sudah diselesaikan
        $completedLessonIds = $user->lessonProgress()->whereNotNull('completed_at')->pluck('lesson_id');

        // 3. Cek apakah SEMUA pelajaran dari SEMUA bab sudah selesai
        $totalLessons = Lesson::count();
        $allLessonsCompleted = ($completedLessonIds->count() >= $totalLessons && $totalLessons > 0);

        // 4. Kirim data yang dibutuhkan oleh view Duolingo
        return Inertia::render('LearningPath/Index', [
            'chapters' => $chapters,
            'completedLessonIds' => $completedLessonIds->toArray(),
            'allLessonsCompleted' => $allLessonsCompleted,
        ]);
    }

    public function startLessonQuiz(Lesson $lesson)
    {
        $user = Auth::user();
        $aksaraIdsInLesson = $lesson->aksaras()->pluck('aksaras.id');

        // Ambil 5 soal acak dari aksara yang ada di pelajaran ini
        $questions = Question::whereIn('aksara_id', $aksaraIdsInLesson)
            ->inRandomOrder()
            ->take(5)
            ->pluck('id');

        // Pastikan ada cukup soal
        if ($questions->count() < 5) {
            return redirect()->back()->with('error', 'Bank soal untuk pelajaran ini belum cukup.');
        }

        // Buat kuis baru dan tandai bahwa ini adalah kuis untuk pelajaran ini
        $quiz = $user->quizzes()->create(['lesson_id' => $lesson->id, 'type' => 'lesson']);
        $quiz->questions()->attach($questions);

        return redirect()->route('arena.quiz.show', $quiz);
    }

    public function showLesson(Lesson $lesson)
    {
        // Ambil data pelajaran beserta semua aksara di dalamnya
        $lesson->load('aksaras');

        return Inertia::render('LearningPath/ShowLesson', [
            'lesson' => $lesson,
        ]);
    }
}
