<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['progress_id', 'user_id', 'parent_id', 'content'];

    public function progress() {
        return $this->belongsTo(ProgressLog::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk membalas feedback (Threaded)
    public function replies() {
        return $this->hasMany(Feedback::class, 'parent_id');
    }
}
