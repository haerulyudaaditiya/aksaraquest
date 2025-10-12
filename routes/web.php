<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\AtlasController;
use App\Http\Controllers\FocusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\AksaraController as AdminAksaraController;
use App\Http\Controllers\Admin\ChapterController as AdminChapterController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\Admin\StoryController as AdminStoryController;
use App\Http\Controllers\Admin\StoryContentController as AdminStoryContentController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/atlas', [AtlasController::class, 'index'])->name('atlas.index');
    Route::get('/atlas/{aksara}', [AtlasController::class, 'show'])->name('atlas.show');

    Route::get('/arena', [ArenaController::class, 'index'])->name('arena.index');
    Route::post('/arena/start', [ArenaController::class, 'start'])->name('arena.start');
    Route::get('/arena/quiz/{quiz}', [ArenaController::class, 'show'])->name('arena.quiz.show');
    Route::post('/arena/quiz/{quiz}/answer', [ArenaController::class, 'answer'])->name('arena.quiz.answer');
    Route::get('/arena/quiz/{quiz}/results', [ArenaController::class, 'results'])->name('arena.quiz.results');

    Route::get('/prestasi', [AchievementController::class, 'index'])->name('prestasi.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/fokus', [FocusController::class, 'index'])->name('fokus.index');
    Route::post('/fokus/latih/{aksara}', [FocusController::class, 'startPractice'])->name('fokus.startPractice');

    Route::get('/belajar', [LearningPathController::class, 'index'])->name('belajar.index');
    Route::post('/belajar/latihan/{lesson}', [LearningPathController::class, 'startLessonQuiz'])->name('belajar.quiz');
    Route::get('/belajar/pelajaran/{lesson}', [LearningPathController::class, 'showLesson'])->name('belajar.lesson.show');

    Route::get('/papan-peringkat', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::get('/dongeng', [StoryController::class, 'index'])->name('dongeng.index');
    Route::get('/dongeng/{story}', [StoryController::class, 'show'])->name('dongeng.show');
});

Route::middleware(['auth'])->prefix('sertifikasi')->name('sertifikasi.')->group(function () {
    Route::post('/mulai', [CertificationController::class, 'startExam'])->name('start');
    Route::get('/hasil/{attempt}', [CertificationController::class, 'showResult'])->name('result.show');
    Route::get('/sertifikat-saya', [CertificationController::class, 'viewCertificate'])->name('view');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/aksara', [AdminAksaraController::class, 'index'])->name('aksara.index');
    Route::get('/aksara/{aksara}/edit', [AdminAksaraController::class, 'edit'])->name('aksara.edit');
    Route::put('/aksara/{aksara}', [AdminAksaraController::class, 'update'])->name('aksara.update');
    Route::get('/aksara/create', [AdminAksaraController::class, 'create'])->name('aksara.create');
    Route::post('/aksara', [AdminAksaraController::class, 'store'])->name('aksara.store');
    Route::delete('/aksara/{aksara}', [AdminAksaraController::class, 'destroy'])->name('aksara.destroy');

    Route::get('/chapters', [AdminChapterController::class, 'index'])->name('chapters.index');
    Route::get('/chapters/create', [AdminChapterController::class, 'create'])->name('chapters.create');
    Route::post('/chapters', [AdminChapterController::class, 'store'])->name('chapters.store');
    Route::get('/chapters/{chapter}/edit', [AdminChapterController::class, 'edit'])->name('chapters.edit');
    Route::put('/chapters/{chapter}', [AdminChapterController::class, 'update'])->name('chapters.update');
    Route::delete('/chapters/{chapter}', [AdminChapterController::class, 'destroy'])->name('chapters.destroy');

    Route::get('/lessons', [AdminLessonController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/create', [AdminLessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [AdminLessonController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{lesson}/edit', [AdminLessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}', [AdminLessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [AdminLessonController::class, 'destroy'])->name('lessons.destroy');

    Route::get('/questions', [AdminQuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [AdminQuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [AdminQuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');

    Route::resource('stories', AdminStoryController::class)->except(['show']);
    Route::get('/stories/{story}/content', [AdminStoryContentController::class, 'index'])->name('stories.content.index');
    Route::post('/stories/{story}/content', [AdminStoryContentController::class, 'store'])->name('stories.content.store');
    Route::put('/story-contents/{content}', [AdminStoryContentController::class, 'update'])->name('story-contents.update');
    Route::delete('/story-contents/{content}', [AdminStoryContentController::class, 'destroy'])->name('story-contents.destroy');
});

require __DIR__.'/auth.php';
