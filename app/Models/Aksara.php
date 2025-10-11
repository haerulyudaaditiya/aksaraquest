<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class Aksara extends Model
{
    use HasFactory;

    /**
     * Daftarkan semua kolom yang boleh diisi/diubah secara massal.
     * Kita perlu pastikan 'philosophy' ada di sini.
     */
    protected $fillable = [
        'character',
        'latin',
        'audio_url',
        'philosophy', // <-- KEMUNGKINAN BESAR INI YANG HILANG
    ];

    /**
     * Cast 'stroke_data' (jika ada) agar otomatis diubah menjadi array.
     */
    protected $casts = [
        'stroke_data' => 'array',
    ];

    /**
     * Relasi ke model Question.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'aksara_lesson');
    }
}
