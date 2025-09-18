<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;

class AchievementService
{
    public function checkAndAwardAchievements(User $user)
    {
        $this->checkFirstQuizCompleted($user);
    }

    private function checkFirstQuizCompleted(User $user)
    {
        $achievementId = 1;

        $alreadyHasAchievement = $user->achievements()->where('achievement_id', $achievementId)->exists();
        if ($alreadyHasAchievement) {
            return;
        }

        if ($user->quizzes()->count() >= 1) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }
}
