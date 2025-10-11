<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aksara;

class AksaraSeeder extends Seeder
{
    public function run(): void
    {
        Aksara::query()->delete();

        $aksaras = [
            // --- AKSARA NGALAGENA (DASAR) ---
            ['character' => 'ᮊ', 'latin' => 'ka', 'philosophy' => 'Aksara dasar untuk bunyi /ka/.'],
            ['character' => 'ᮌ', 'latin' => 'ga', 'philosophy' => 'Aksara dasar untuk bunyi /ga/.'],
            ['character' => 'ᮍ', 'latin' => 'nga', 'philosophy' => 'Aksara dasar untuk bunyi /nga/.'],
            ['character' => 'ᮎ', 'latin' => 'ca', 'philosophy' => 'Aksara dasar untuk bunyi /ca/.'],
            ['character' => 'ᮏ', 'latin' => 'ja', 'philosophy' => 'Aksara dasar untuk bunyi /ja/.'],
            ['character' => 'ᮑ', 'latin' => 'nya', 'philosophy' => 'Aksara dasar untuk bunyi /nya/.'],
            ['character' => 'ᮒ', 'latin' => 'ta', 'philosophy' => 'Aksara dasar untuk bunyi /ta/.'],
            ['character' => 'ᮓ', 'latin' => 'da', 'philosophy' => 'Aksara dasar untuk bunyi /da/.'],
            ['character' => 'ᮔ', 'latin' => 'na', 'philosophy' => 'Aksara dasar untuk bunyi /na/.'],
            ['character' => 'ᮕ', 'latin' => 'pa', 'philosophy' => 'Aksara dasar untuk bunyi /pa/.'],
            ['character' => 'ᮘ', 'latin' => 'ba', 'philosophy' => 'Aksara dasar untuk bunyi /ba/.'],
            ['character' => 'ᮙ', 'latin' => 'ma', 'philosophy' => 'Aksara dasar untuk bunyi /ma/.'],
            ['character' => 'ᮚ', 'latin' => 'ya', 'philosophy' => 'Aksara dasar untuk bunyi /ya/.'],
            ['character' => 'ᮛ', 'latin' => 'ra', 'philosophy' => 'Aksara dasar untuk bunyi /ra/.'],
            ['character' => 'ᮜ', 'latin' => 'la', 'philosophy' => 'Aksara dasar untuk bunyi /la/.'],
            ['character' => 'ᮝ', 'latin' => 'wa', 'philosophy' => 'Aksara dasar untuk bunyi /wa/.'],
            ['character' => 'ᮞ', 'latin' => 'sa', 'philosophy' => 'Aksara dasar untuk bunyi /sa/.'],
            ['character' => 'ᮠ', 'latin' => 'ha', 'philosophy' => 'Aksara dasar untuk bunyi /ha/.'],

            // --- CONTOH AKSARA DENGAN RARANGKÉN (VOKALISASI) ---
            ['character' => 'ᮊᮤ', 'latin' => 'ki', 'philosophy' => "Kombinasi 'Ka' dengan Panghulu untuk vokal /i/."],
            ['character' => 'ᮌᮤ', 'latin' => 'gi', 'philosophy' => "Kombinasi 'Ga' dengan Panghulu untuk vokal /i/."],
            ['character' => 'ᮓᮤ', 'latin' => 'di', 'philosophy' => "Kombinasi 'Da' dengan Panghulu untuk vokal /i/."],

            ['character' => 'ᮊᮥ', 'latin' => 'ku', 'philosophy' => "Kombinasi 'Ka' dengan Panyuku untuk vokal /u/."],
            ['character' => 'ᮌᮥ', 'latin' => 'gu', 'philosophy' => "Kombinasi 'Ga' dengan Panyuku untuk vokal /u/."],
            ['character' => 'ᮓᮥ', 'latin' => 'du', 'philosophy' => "Kombinasi 'Da' dengan Panyuku untuk vokal /u/."],

            ['character' => 'ᮊᮦ', 'latin' => 'ké', 'philosophy' => "Kombinasi 'Ka' dengan Panéléng untuk vokal /é/."],
            ['character' => 'ᮌᮦ', 'latin' => 'gé', 'philosophy' => "Kombinasi 'Ga' dengan Panéléng untuk vokal /é/."],

            ['character' => 'ᮊᮨ', 'latin' => 'ke', 'philosophy' => "Kombinasi 'Ka' dengan Pamepet untuk vokal /e/."],
            ['character' => 'ᮌᮨ', 'latin' => 'ge', 'philosophy' => "Kombinasi 'Ga' dengan Pamepet untuk vokal /e/."],

            ['character' => 'ᮊᮧ', 'latin' => 'ko', 'philosophy' => "Kombinasi 'Ka' dengan Panolong untuk vokal /o/."],
            ['character' => 'ᮌᮧ', 'latin' => 'go', 'philosophy' => "Kombinasi 'Ga' dengan Panolong untuk vokal /o/."],

            // --- CONTOH AKSARA DENGAN RARANGKÉN (KONSONAN AKHIR) ---
            ['character' => 'ᮊᮡ', 'latin' => 'kya', 'philosophy' => "Kombinasi 'Ka' dengan Pamingkal untuk sisipan /y/."],
            ['character' => 'ᮌᮡ', 'latin' => 'gya', 'philosophy' => "Kombinasi 'Ga' dengan Pamingkal untuk sisipan /y/."],

            ['character' => 'ᮊᮢ', 'latin' => 'kra', 'philosophy' => "Kombinasi 'Ka' dengan Panyakra untuk sisipan /r/."],
            ['character' => 'ᮕᮢ', 'latin' => 'pra', 'philosophy' => "Kombinasi 'Pa' dengan Panyakra untuk sisipan /r/."],

            ['character' => 'ᮊᮣ', 'latin' => 'kla', 'philosophy' => "Kombinasi 'Ka' dengan Panyiku untuk sisipan /l/."],
            ['character' => 'ᮌᮣ', 'latin' => 'gla', 'philosophy' => "Kombinasi 'Ga' dengan Panyiku untuk sisipan /l/."],

            ['character' => 'ᮊᮂ', 'latin' => 'kah', 'philosophy' => "Kombinasi 'Ka' dengan Pangwisad untuk akhiran /h/."],
            ['character' => 'ᮊᮀ', 'latin' => 'kang', 'philosophy' => "Kombinasi 'Ka' dengan Panyecek untuk akhiran /ng/."],

            ['character' => 'ᮊ᮪', 'latin' => 'k', 'philosophy' => "Kombinasi 'Ka' dengan Pamaéh untuk mematikan vokal /a/."],
            ['character' => 'ᮕ᮪', 'latin' => 'p', 'philosophy' => "Kombinasi 'Pa' dengan Pamaéh untuk mematikan vokal /a/."],
        ];

        foreach ($aksaras as $aksaraData) {
            Aksara::create([
                'character'    => $aksaraData['character'],
                'latin'        => $aksaraData['latin'],
                'philosophy'   => $aksaraData['philosophy'],
                'audio_url'    => '/storage/audio/' . $aksaraData['latin'] . '.mp3',
            ]);
        }
    }
}
