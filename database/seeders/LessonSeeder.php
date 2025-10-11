<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Aksara;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        Lesson::query()->delete();
        DB::table('aksara_lesson')->delete();

        // --- Mengisi Pelajaran untuk Bab 1 ---
        $chapter1 = Chapter::where('order', 1)->first();
        if ($chapter1) {
            $lessonsData1 = [
                ['title' => 'Pelajaran 1: Ka, Ga, Nga', 'aksaras' => ['ka', 'ga', 'nga']],
                ['title' => 'Pelajaran 2: Ca, Ja, Nya', 'aksaras' => ['ca', 'ja', 'nya']],
                ['title' => 'Pelajaran 3: Ta, Da, Na', 'aksaras' => ['ta', 'da', 'na']],
                ['title' => 'Pelajaran 4: Pa, Ba, Ma', 'aksaras' => ['pa', 'ba', 'ma']],
                ['title' => 'Pelajaran 5: Ya, Ra, La', 'aksaras' => ['ya', 'ra', 'la']],
                ['title' => 'Pelajaran 6: Wa, Sa, Ha', 'aksaras' => ['wa', 'sa', 'ha']],
            ];
            foreach ($lessonsData1 as $index => $data) {
                $lesson = $chapter1->lessons()->create(['title' => $data['title'], 'order' => $index + 1]);
                $aksaraIds = Aksara::whereIn('latin', $data['aksaras'])->pluck('id');
                $lesson->aksaras()->attach($aksaraIds);
            }
        }

        // --- Mengisi Pelajaran untuk Bab 2 ---
        $chapter2 = Chapter::where('order', 2)->first();
        if ($chapter2) {
            $lessonsData2 = [
                ['title' => 'Pelajaran 7: Vokal /i/ (Panghulu)', 'aksaras' => ['ki', 'gi', 'di']],
                ['title' => 'Pelajaran 8: Vokal /u/ (Panyuku)', 'aksaras' => ['ku', 'gu', 'du']],
                ['title' => 'Pelajaran 9: Vokal /é/ & /e/', 'aksaras' => ['ké', 'gé', 'ke', 'ge']],
                ['title' => 'Pelajaran 10: Vokal /o/ (Panolong)', 'aksaras' => ['ko', 'go']],
            ];
             foreach ($lessonsData2 as $index => $data) {
                $lesson = $chapter2->lessons()->create(['title' => $data['title'], 'order' => $index + 1]);
                $aksaraIds = Aksara::whereIn('latin', $data['aksaras'])->pluck('id');
                $lesson->aksaras()->attach($aksaraIds);
            }
        }
    }
}
