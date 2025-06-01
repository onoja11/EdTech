<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'content',
        'subject',
        'grade_level',
        'created_by'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(LessonRecommendation::class);
    }
}
