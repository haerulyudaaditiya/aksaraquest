<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        Chapter::query()->delete();

        Chapter::create([
            'title' => 'Aksara Ngalagena (Dasar)',
            'description' => 'Mulai perjalananmu dengan mempelajari 18 aksara dasar dalam Aksara Sunda.',
            'order' => 1,
        ]);

        Chapter::create([
            'title' => 'Rarangkén (Vokalisasi)',
            'description' => 'Pelajari cara mengubah bunyi vokal dasar /a/ menjadi vokal lainnya seperti /i/, /u/, /e/, /o/, dan /é/.',
            'order' => 2,
        ]);
    }
}
