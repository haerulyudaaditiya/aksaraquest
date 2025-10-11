<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['chapter_id', 'title', 'order'];

    /**
     * Satu Pelajaran dimiliki oleh satu Bab.
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Satu Pelajaran bisa memiliki banyak Aksara.
     */
    public function aksaras()
    {
        return $this->belongsToMany(Aksara::class, 'aksara_lesson');
    }
}
