<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoachProfile extends Model
{
    protected $fillable = ['user_id', 'specialization', 'bio'];

    // Mengetahui User akun si Coach
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Mendapatkan list Klien yang dibimbing coach ini
    public function clients(): HasMany
    {
        return $this->hasMany(ClientProfile::class, 'coach_id');
    }
}