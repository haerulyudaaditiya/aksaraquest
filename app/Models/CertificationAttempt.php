<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationAttempt extends Model
{
    use HasFactory;

    /**
     * Properti ini mendaftarkan kolom mana saja yang boleh
     * diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'score',
        'passed',
        'completed_at',
    ];

    /**
     * Mendefinisikan relasi bahwa satu percobaan ujian
     * dimiliki oleh satu Pengguna (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
