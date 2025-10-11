<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'order'];

    /**
     * Satu Bab memiliki banyak Pelajaran.
     */
    public function lessons()
    {
        // Otomatis urutkan pelajaran berdasarkan kolom 'order'
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
}
