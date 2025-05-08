<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    protected $fillable = ['assignment_sk', 'assignment_en', 'isMultiChoice'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, 'test_question')
            ->withPivot('isCorrect', 'time');
    }
}
