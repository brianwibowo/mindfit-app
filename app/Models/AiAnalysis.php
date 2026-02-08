<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'age',
        'height',
        'weight',
        'health_history',
        'exercise_frequency',
        'gym_experience',
        'diet_pattern',
        'target',
        'complaint',
        'bmi_score',
        'bmi_status',
        'bmr',
        'tdee',
        'recommendation_package',
        'ai_diagnosis',
        'recommendation_data',
    ];

    protected $casts = [
        'recommendation_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
