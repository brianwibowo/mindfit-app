<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'specialization',
        'avatar',
        'is_premium',
        'premium_until',
    ];

    /**
     * Kolom yang disembunyikan saat serialization
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast tipe data kolom
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'premium_until' => 'datetime',
            'is_premium' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /* ==================================================
     | RELATIONSHIPS
     |==================================================*/

    /**
     * Relasi ke profil coach
     */
    public function coachProfile()
    {
        return $this->hasOne(CoachProfile::class);
    }

    /**
     * Relasi ke profil client
     */
    public function clientProfile()
    {
        return $this->hasOne(ClientProfile::class);
    }

    /**
     * Coach memiliki banyak client
     */
    /**
     * Coach memiliki banyak client
     */
    public function clients()
    {
        return $this->belongsToMany(
            User::class,
            'coach_client',
            'coach_id',
            'client_id'
        )->withPivot('type');
    }

    /**
     * Client memiliki banyak coach
     */
    /**
     * Client memiliki banyak coach
     */
    public function coaches()
    {
        return $this->belongsToMany(
            User::class,
            'coach_client',
            'client_id',
            'coach_id'
        )->withPivot('type');
    }

    /**
     * Relasi ke pembayaran
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relasi ke progress log (khusus client)
     */
    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class, 'client_id');
    }
}
