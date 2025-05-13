<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['answer_sk','answer_en','isCorrect'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
