<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Ambil 10 pengguna dengan XP tertinggi, KECUALI admin
        $topXpUsers = User::where('role', 'user')
            ->orderBy('xp', 'desc')
            ->take(10)
            ->get(['id', 'name', 'xp']); // Kita hanya meminta kolom yang benar-benar ada di database

        // Ambil 10 pengguna dengan Streak terpanjang, KECUALI admin
        $topStreakUsers = User::where('role', 'user')
            ->orderBy('streak_count', 'desc')
            ->take(10)
            ->get(['id', 'name', 'streak_count']);

        return Inertia::render('Leaderboard/Index', [
            'topXpUsers' => $topXpUsers,
            'topStreakUsers' => $topStreakUsers,
        ]);
    }
}
