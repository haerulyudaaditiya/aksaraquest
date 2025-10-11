<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLessonProgress extends Model
{
    use HasFactory;

    // Nama tabelnya kita tentukan secara eksplisit agar tidak salah
    protected $table = 'user_lesson_progress';

    protected $fillable = ['user_id', 'lesson_id', 'completed_at'];
}
