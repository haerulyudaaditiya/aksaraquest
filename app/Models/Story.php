<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image_url',
        'order',
    ];

    /**
     * Satu Dongeng memiliki banyak konten (kata per kata).
     */
    public function contents()
    {
        // Otomatis urutkan kata berdasarkan nomor paragraf, lalu urutan di dalam paragraf
        return $this->hasMany(StoryContent::class)->orderBy('paragraph_number')->orderBy('order_in_paragraph');
    }
}
