<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserSkillLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aksara_id',
        'level',
        'correct_streak',
        'last_practiced_at',
        'next_review_at',
    ];

    protected $casts = [
        'last_practiced_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];
}
