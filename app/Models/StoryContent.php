<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'aksara_word',
        'latin_word',
        'paragraph_number',
        'order_in_paragraph',
    ];

    /**
     * Satu konten kata dimiliki oleh satu Dongeng.
     */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
