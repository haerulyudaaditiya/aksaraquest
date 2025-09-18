<?php
namespace App\Http\Controllers;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AchievementController extends Controller
{
    public function index()
    {
        $allAchievements = Achievement::all();
        $userAchievements = Auth::user()->achievements()->pluck('achievement_id');

        return Inertia::render('Achievements/Index', [
            'achievements' => $allAchievements,
            'unlocked' => $userAchievements,
        ]);
    }
}
