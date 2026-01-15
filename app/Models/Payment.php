<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'package_id', // Added
        'package_data', // Added
        'proof_file',
        'duration_months',
        'status',
        'admin_note',
        'subscription_start',
        'subscription_end',
    ];

    protected $casts = [
        'package_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
