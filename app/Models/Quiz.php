<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model {
    use HasFactory;
    protected $fillable = ['score', 'user_id', 'lesson_id', 'type', 'aksara_id'];
    public function user() { return $this->belongsTo(User::class); }
    public function questions() { return $this->belongsToMany(Question::class); }
    public function answers() { return $this->hasMany(Answer::class); }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Relasi baru: Satu Kuis bisa jadi untuk satu Aksara (untuk mode Fokus).
     */
    public function aksara()
    {
        return $this->belongsTo(Aksara::class);
    }
}
