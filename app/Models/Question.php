<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    protected $fillable = ['assignment_sk', 'assignment_en', 'isMultiChoice'];

    protected $casts = [
        'isMultiChoice' => 'boolean',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, 'test_question')
            ->withPivot('isCorrect', 'time');
    }
}
