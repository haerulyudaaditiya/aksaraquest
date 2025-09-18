<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aksara;

class AksaraSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        // 1. Kosongkan tabel aksaras terlebih dahulu untuk menghindari data ganda.
        Aksara::query()->delete();

        // 2. Siapkan data lengkap 18 Aksara Ngalagena.
        $aksaras = [
            ['character' => 'ᮊ', 'latin' => 'ka', 'philosophy' => 'Filosofi untuk Ka...'],
            ['character' => 'ᮌ', 'latin' => 'ga', 'philosophy' => 'Filosofi untuk Ga...'],
            ['character' => 'ᮍ', 'latin' => 'nga', 'philosophy' => 'Filosofi untuk Nga...'],
            ['character' => 'ᮎ', 'latin' => 'ca', 'philosophy' => 'Filosofi untuk Ca...'],
            ['character' => 'ᮏ', 'latin' => 'ja', 'philosophy' => 'Filosofi untuk Ja...'],
            ['character' => 'ᮑ', 'latin' => 'nya', 'philosophy' => 'Filosofi untuk Nya...'],
            ['character' => 'ᮒ', 'latin' => 'ta', 'philosophy' => 'Filosofi untuk Ta...'],
            ['character' => 'ᮓ', 'latin' => 'da', 'philosophy' => 'Filosofi untuk Da...'],
            ['character' => 'ᮔ', 'latin' => 'na', 'philosophy' => 'Filosofi untuk Na...'],
            ['character' => 'ᮕ', 'latin' => 'pa', 'philosophy' => 'Filosofi untuk Pa...'],
            ['character' => 'ᮘ', 'latin' => 'ba', 'philosophy' => 'Filosofi untuk Ba...'],
            ['character' => 'ᮙ', 'latin' => 'ma', 'philosophy' => 'Filosofi untuk Ma...'],
            ['character' => 'ᮚ', 'latin' => 'ya', 'philosophy' => 'Filosofi untuk Ya...'],
            ['character' => 'ᮛ', 'latin' => 'ra', 'philosophy' => 'Filosofi untuk Ra...'],
            ['character' => 'ᮜ', 'latin' => 'la', 'philosophy' => 'Filosofi untuk La...'],
            ['character' => 'ᮝ', 'latin' => 'wa', 'philosophy' => 'Filosofi untuk Wa...'],
            ['character' => 'ᮞ', 'latin' => 'sa', 'philosophy' => 'Filosofi untuk Sa...'],
            ['character' => 'ᮠ', 'latin' => 'ha', 'philosophy' => 'Filosofi untuk Ha...'],
        ];

        // 3. Lakukan perulangan untuk setiap item data dan simpan ke database.
        foreach ($aksaras as $aksaraData) {
            Aksara::create([
                'character'    => $aksaraData['character'],
                'latin'        => $aksaraData['latin'],
                'philosophy'   => $aksaraData['philosophy'],
                // Path ke file audio dibuat secara dinamis berdasarkan nama latin
                'audio_url'    => '/storage/audio/' . $aksaraData['latin'] . '.mp3',
            ]);
        }
    }
}
