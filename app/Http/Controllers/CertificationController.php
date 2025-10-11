<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\CertificationAttempt;
use Illuminate\Support\Facades\Redirect;

class CertificationController extends Controller
{
    public function startExam()
    {
        $user = Auth::user();
        $totalLessons = Lesson::count();
        $completedLessons = $user->lessonProgress()->whereNotNull('completed_at')->count();

        if ($completedLessons < $totalLessons && $totalLessons > 0) {
            return redirect()->route('belajar.index')->with('error', 'Anda harus menyelesaikan semua pelajaran terlebih dahulu!');
        }

        $questions = Question::inRandomOrder()->take(30)->pluck('id');

        if ($questions->count() < 30) {
            return redirect()->route('belajar.index')->with('error', 'Bank soal tidak cukup untuk memulai ujian sertifikasi.');
        }

        // Buat kuis dengan tipe 'certification'
        $quiz = $user->quizzes()->create(['type' => 'certification']);
        $quiz->questions()->attach($questions);

        // Langsung arahkan ke Arena untuk mengerjakan ujian
        return redirect()->route('arena.quiz.show', $quiz);
    }

    public function showResult(CertificationAttempt $attempt)
    {
        // Keamanan: Pastikan hanya pemilik sertifikat yang bisa melihat
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Render komponen Vue baru untuk sertifikat
        return Inertia::render('Certification/Result', [
            'attempt' => $attempt
        ]);
    }

    public function viewCertificate()
    {
        $user = Auth::user();

        // Cari percobaan ujian terakhir yang LULUS
        $latestPassedAttempt = $user->certificationAttempts()->where('passed', true)->latest('completed_at')->first();

        // Jika tidak ada, kembalikan ke dashboard
        if (!$latestPassedAttempt) {
            return redirect()->route('dashboard');
        }

        // Jika ada, tampilkan halaman hasil/sertifikat dengan data tersebut
        // Kita gunakan kembali komponen Result.vue yang sudah ada!
        return Inertia::render('Certification/Result', [
            'attempt' => $latestPassedAttempt
        ]);
    }
}
