<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\AtlasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\FocusController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AksaraController as AdminAksaraController;


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
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/aksara', [AdminAksaraController::class, 'index'])->name('aksara.index');
    Route::get('/aksara/{aksara}/edit', [AdminAksaraController::class, 'edit'])->name('aksara.edit');
    Route::put('/aksara/{aksara}', [AdminAksaraController::class, 'update'])->name('aksara.update');
    Route::get('/aksara/create', [AdminAksaraController::class, 'create'])->name('aksara.create');
    Route::post('/aksara', [AdminAksaraController::class, 'store'])->name('aksara.store');
    Route::delete('/aksara/{aksara}', [AdminAksaraController::class, 'destroy'])->name('aksara.destroy');
});

require __DIR__.'/auth.php';
