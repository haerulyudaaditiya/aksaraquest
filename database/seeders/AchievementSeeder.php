<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::query()->delete();

        $achievements = [
            [
                'name' => 'Langkah Pertama',
                'description' => 'Selesaikan kuis pertamamu.',
                'icon_url' => 'check-badge',
                'criteria_class' => 'FirstQuizCompleted' // Ini nama Class Logic Checker-nya nanti
            ],
            [
                'name' => 'Murid Rajin',
                'description' => 'Login selama 3 hari berturut-turut.',
                'icon_url' => 'star',
                'criteria_class' => 'ThreeDayStreak'
            ],
            [
                'name' => 'Novice Ngalagena',
                'description' => 'Kuasai 5 aksara Ngalagena.',
                'icon_url' => 'academic-cap',
                'criteria_class' => 'MasterFiveAksara'
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
