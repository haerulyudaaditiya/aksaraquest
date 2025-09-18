<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Quiz;
use App\Models\UserSkillLevel;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function skillLevels()
    {
        return $this->hasMany(UserSkillLevel::class);
    }

    protected function level(): Attribute
    {
        return Attribute::make(
            get: function () {
                $xp = $this->xp;
                // Definisikan ambang batas XP untuk setiap level
                if ($xp >= 1000) return 5;
                if ($xp >= 600) return 4;
                if ($xp >= 300) return 3;
                if ($xp >= 100) return 2;
                return 1; // Level Awal
            },
        );
    }

    public function achievements()
    {
        // Relasi many-to-many ke model Achievement melalui tabel pivot 'user_achievements'
        return $this->belongsToMany(Achievement::class, 'user_achievements')
                    ->withPivot('unlocked_at') // Sertakan kolom tambahan dari tabel pivot
                    ->withTimestamps(); // Otomatis kelola created_at/updated_at di tabel pivot
    }
}
