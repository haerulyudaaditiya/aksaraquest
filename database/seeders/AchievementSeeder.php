<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        Achievement::query()->delete();

        $achievements = [
            // --- Dari Versi Awal ---
            [
                'name' => 'Langkah Pertama',
                'description' => 'Selesaikan kuis pertamamu.',
                'icon_url' => 'check-badge',
                'criteria_class' => 'FirstQuizCompleted'
            ],
            [
                'name' => 'Murid Rajin',
                'description' => 'Lanjutkan streak harian selama 3 hari.',
                'icon_url' => 'star',
                'criteria_class' => 'ThreeDayStreak'
            ],
            [
                'name' => 'Novice Ngalagena',
                'description' => 'Kuasai 5 aksara Ngalagena.',
                'icon_url' => 'academic-cap',
                'criteria_class' => 'MasterFiveAksara'
            ],
            // --- Dari Versi Terakhir ---
            [
                'name' => 'Pejuang Arena',
                'description' => 'Selesaikan 5 sesi kuis di Arena.',
                'icon_url' => 'trophy',
                'criteria_class' => 'CompletedFiveQuizzes'
            ],
            [
                'name' => 'Pakar Muda',
                'description' => 'Capai Level 5.',
                'icon_url' => 'bolt',
                'criteria_class' => 'ReachedLevelFive'
            ],
            [
                'name' => 'Tanpa Celah',
                'description' => 'Dapatkan skor 100 di sebuah kuis.',
                'icon_url' => 'sparkles',
                'criteria_class' => 'PerfectScore'
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
