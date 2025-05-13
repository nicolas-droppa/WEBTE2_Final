<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['assignment_sk','assignment_en','isMultiChoice'];

    public function tests()
    {
        return $this->belongsToMany(
            Test::class,
            'test_question',
            'question_id',
            'test_id'
        );
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'question_tag',
            'question_id',
            'tag_id'
        );
    }

    public function historyTests()
    {
        return $this->belongsToMany(
            HistoryTest::class,
            'history_test_question',
            'question_id',
            'history_test_id'
        )
        ->withPivot(['answer_id','written_answer','time']);
        //->withTimestamps();
    }
}
