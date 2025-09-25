<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aksara;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::query()->delete();
        $aksaras = Aksara::all();
        if ($aksaras->count() < 4) { return; }

        $types = ['character_to_latin', 'latin_to_character', 'audio_to_latin', 'audio_to_character'];

        foreach ($aksaras as $correctAksara) {
            // Buat beberapa soal untuk setiap aksara agar bank soal cukup
            for ($i = 0; $i < 2; $i++) {
                foreach ($types as $type) {
                    // Pastikan soal audio hanya dibuat jika ada file audionya
                    if (str_starts_with($type, 'audio_') && !$correctAksara->audio_url) {
                        continue;
                    }

                    $wrongOptions = $aksaras->where('id', '!=', $correctAksara->id)->random(3);
                    $body = '';
                    $options = [];
                    $correctAnswer = '';

                    switch ($type) {
                        case 'character_to_latin':
                            $body = 'Aksara ini dibaca...';
                            $options = $wrongOptions->pluck('latin')->push($correctAksara->latin)->shuffle()->all();
                            $correctAnswer = $correctAksara->latin;
                            break;
                        case 'latin_to_character':
                            $body = "Pilih aksara untuk '" . $correctAksara->latin . "'";
                            $options = $wrongOptions->pluck('character')->push($correctAksara->character)->shuffle()->all();
                            $correctAnswer = $correctAksara->character;
                            break;
                        case 'audio_to_latin':
                            $body = 'Dengarkan suara ini dan pilih nama yang benar.';
                            $options = $wrongOptions->pluck('latin')->push($correctAksara->latin)->shuffle()->all();
                            $correctAnswer = $correctAksara->latin;
                            break;
                        case 'audio_to_character':
                            $body = 'Dengarkan suara ini dan pilih aksara yang benar.';
                            $options = $wrongOptions->pluck('character')->push($correctAksara->character)->shuffle()->all();
                            $correctAnswer = $correctAksara->character;
                            break;
                    }

                    Question::create([
                        'aksara_id' => $correctAksara->id,
                        'character' => $correctAksara->character,
                        'body' => $body,
                        'type' => $type,
                        'options' => $options,
                        'correct_answer' => $correctAnswer,
                    ]);
                }
            }
        }
    }
}
