<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aksara;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::query()->delete();

        // Ambil semua data aksara sebagai dasar pembuatan soal
        $aksaras = Aksara::all();

        if ($aksaras->count() < 4) {
            // Hentikan seeder jika data aksara kurang dari 4, karena sulit membuat pilihan ganda
            $this->command->warn('Tidak cukup data aksara untuk membuat soal (minimal 4).');
            return;
        }

        // Buat 1 soal untuk setiap aksara
        foreach ($aksaras as $correctAksara) {
            // Ambil 3 aksara lain secara acak sebagai pilihan jawaban yang salah
            $wrongOptions = $aksaras->where('id', '!=', $correctAksara->id)->random(3)->pluck('latin');

            // Gabungkan jawaban benar dan salah, lalu acak urutannya
            $options = $wrongOptions->push($correctAksara->latin)->shuffle()->values()->all();

            Question::create([
                'aksara_id' => $correctAksara->id,
                'character' => $correctAksara->character, // Tambahkan karakter untuk ditampilkan di soal
                'body' => 'Aksara ini dibaca...',
                'options' => $options, // Simpan sebagai JSON
                'correct_answer' => $correctAksara->latin,
            ]);
        }
    }
}
