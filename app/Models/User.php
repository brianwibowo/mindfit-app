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
        'role',
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
            'premium_until'     => 'datetime',
            'is_premium'        => 'boolean',
            'password'          => 'hashed',
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
    public function assignedClients()
    {
        return $this->belongsToMany(
            User::class,
            'coach_client',
            'coach_id',
            'client_id'
        );
    }

    /**
     * Client memiliki banyak coach
     */
    public function assignedCoaches()
    {
        return $this->belongsToMany(
            User::class,
            'coach_client',
            'client_id',
            'coach_id'
        );
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
