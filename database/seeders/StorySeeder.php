<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Story;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        Story::query()->delete();

        Story::create([
            'title' => 'Sasakala Situ Bagendit',
            'description' => 'Dongeng rakyat Pasundan tentang asal-usul sebuah danau dan pelajaran tentang keserakahan.',
            'cover_image_url' => '/images/covers/situ-bagendit.jpg',
            'order' => 1,
        ]);

        Story::create([
            'title' => 'Sangkuriang',
            'description' => 'Legenda terkenal dari tatar Sunda tentang penciptaan Gunung Tangkuban Parahu.',
            'cover_image_url' => '/images/covers/sangkuriang.jpg',
            'order' => 2,
        ]);
    }
}
