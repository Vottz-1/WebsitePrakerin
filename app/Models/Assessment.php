<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'user_id',
        'discipline_score',
        'skill_score',
        'attitude_score',
        'technical_scores',
        'non_technical_scores',
        'notes',
    ];

    protected $casts = [
        'technical_scores' => 'array',
        'non_technical_scores' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
