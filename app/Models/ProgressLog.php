<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    protected $fillable = ['client_id', 'type', 'photo', 'description'];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class, 'progress_id');
    }
}
