<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalQuizzes = $user->quizzes()->count();
        $totalAnswers = $user->answers()->count(); // Mengambil semua jawaban melalui relasi di User model
        $correctAnswers = $user->answers()->where('is_correct', true)->count();

        $accuracy = ($totalAnswers > 0) ? round(($correctAnswers / $totalAnswers) * 100) : 0;

        return Inertia::render('Dashboard', [
            'totalQuizzes' => $totalQuizzes,
            'accuracy' => $accuracy,
        ]);
    }
}
