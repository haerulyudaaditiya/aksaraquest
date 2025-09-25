<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'aksara_id',
        'character',
        'body',
        'type',
        'options',
        'correct_answer'
    ];

    /**
     * Instruksi WAJIB untuk mengubah 'options' dari teks JSON menjadi array.
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Relasi ke model Aksara.
     */
    public function aksara()
    {
        return $this->belongsTo(Aksara::class);
    }

    /**
     * Relasi ke model Quiz.
     */
    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }
}
