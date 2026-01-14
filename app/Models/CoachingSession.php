<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingSession extends Model
{
    use HasFactory;

    protected $fillable = ['coach_id', 'client_id', 'date', 'title', 'type', 'notes', 'status'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
