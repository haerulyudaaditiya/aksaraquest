<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\StoryContent;

class StoryContentSeeder extends Seeder
{
    public function run(): void
    {
        StoryContent::query()->delete();

        // --- Konten untuk "Sasakala Situ Bagendit" ---
        $story1 = Story::where('title', 'Sasakala Situ Bagendit')->first();
        if ($story1) {
            $content1 = [
                // Paragraf 1
                1 => [
                    ['aksara' => 'ᮓᮤ', 'latin' => 'Di'], ['aksara' => 'ᮠᮤᮏᮤ', 'latin' => 'hiji'],
                    ['aksara' => 'ᮓᮦᮞ', 'latin' => 'désa'], ['aksara' => 'ᮃᮚ', 'latin' => 'aya'],
                    ['aksara' => 'ᮠᮤᮏᮤ', 'latin' => 'hiji'], ['aksara' => 'ᮛᮔ᮪ᮓ', 'latin' => 'randa'],
                    ['aksara' => 'ᮊᮚ', 'latin' => 'kaya'], ['aksara' => 'ᮔᮥ', 'latin' => 'nu'],
                    ['aksara' => 'ᮍᮛᮔ᮪ᮔ', 'latin' => 'ngaranna'], ['aksara' => 'ᮑᮤ', 'latin' => 'Nyi'],
                    ['aksara' => 'ᮈᮔ᮪ᮓᮤᮒ᮪', 'latin' => 'Endit.'],
                ],
                // Paragraf 2
                2 => [
                    ['aksara' => 'ᮊᮊᮚᮃᮔ᮪ᮔ', 'latin' => 'Kekayaanana'], ['aksara' => 'ᮎᮥᮊᮥᮕ᮪', 'latin' => 'cukup'],
                    ['aksara' => 'ᮕᮤᮞᮔ᮪', 'latin' => 'pisan,'], ['aksara' => 'ᮒᮕᮤ', 'latin' => 'tapi'],
                    ['aksara' => 'ᮓᮀᮞᮁ', 'latin' => 'dasar'], ['aksara' => 'ᮊᮎᮤᮓ', 'latin' => 'kacida'],
                    ['aksara' => 'ᮕᮨᮓᮤᮒ᮪ᮔ', 'latin' => 'peditna.'],
                ],
            ];

            foreach ($content1 as $paraNum => $words) {
                foreach ($words as $index => $word) {
                    $story1->contents()->create([
                        'aksara_word' => $word['aksara'], 'latin_word' => $word['latin'],
                        'paragraph_number' => $paraNum, 'order_in_paragraph' => $index + 1,
                    ]);
                }
            }
        }

        // --- Konten untuk "Sangkuriang" ---
        $story2 = Story::where('title', 'Sangkuriang')->first();
        if ($story2) {
            $content2 = [
                // Paragraf 1
                1 => [
                    ['aksara' => 'ᮊᮎᮛᮤᮒᮊᮩᮔ᮪', 'latin' => 'Kacaritakeun'], ['aksara' => 'ᮠᮤᮏᮤ', 'latin' => 'hiji'],
                    ['aksara' => 'ᮝᮔᮧᮏ', 'latin' => 'wanoja'], ['aksara' => 'ᮌᮩᮜᮤᮞ᮪', 'latin' => 'geulis'],
                    ['aksara' => 'ᮍᮛᮔ᮪ᮔ', 'latin' => 'ngaranna'], ['aksara' => 'ᮓᮚᮀ', 'latin' => 'Dayang'],
                    ['aksara' => 'ᮞᮥᮙ᮪ᮘᮤ', 'latin' => 'Sumbi.'],
                ],
            ];

            foreach ($content2 as $paraNum => $words) {
                foreach ($words as $index => $word) {
                    $story2->contents()->create([
                        'aksara_word' => $word['aksara'], 'latin_word' => $word['latin'],
                        'paragraph_number' => $paraNum, 'order_in_paragraph' => $index + 1,
                    ]);
                }
            }
        }
    }
}
