<?php
namespace App\Services;

use App\Models\User;
use App\Models\Quiz;

class AchievementService
{
    public function checkAndAwardAchievements(User $user, Quiz $quiz = null)
    {
        $this->checkFirstQuizCompleted($user);
        $this->checkFiveQuizzesCompleted($user);
        $this->checkLevelFiveReached($user);
        $this->checkThreeDayStreak($user);
        $this->checkMasterFiveAksara($user);

        if ($quiz) {
            $this->checkPerfectScore($user, $quiz);
        }
    }

    private function checkFirstQuizCompleted(User $user) {
        $achievementId = 1;
        if ($user->achievements()->where('achievement_id', $achievementId)->exists()) return;
        if ($user->quizzes()->count() >= 1) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }

    private function checkThreeDayStreak(User $user) {
        $achievementId = 2;
        if ($user->achievements()->where('achievement_id', $achievementId)->exists()) return;
        if ($user->streak_count >= 3) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }

    private function checkMasterFiveAksara(User $user) {
        $achievementId = 3;
        if ($user->achievements()->where('achievement_id', $achievementId)->exists()) return;
        $masteredCount = $user->skillLevels()->where('level', 2)->count();
        if ($masteredCount >= 5) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }

    private function checkFiveQuizzesCompleted(User $user) {
        $achievementId = 4;
        if ($user->achievements()->where('achievement_id', $achievementId)->exists()) return;
        if ($user->quizzes()->count() >= 5) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }

    private function checkLevelFiveReached(User $user) {
        $achievementId = 5;
        if ($user->achievements()->where('achievement_id', $achievementId)->exists()) return;
        if ($user->level >= 5) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }

    private function checkPerfectScore(User $user, Quiz $quiz) {
        $achievementId = 6;
        if ($user->achievements()->where('achievement_id', $achievementId)->exists()) return;
        if ($quiz->score >= 100) {
            $user->achievements()->attach($achievementId, ['unlocked_at' => now()]);
        }
    }
}
