<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTest extends Model
{
    // Laravel will infer table 'history_tests'
    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'city',
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'history_test_question',
            'history_test_id',
            'question_id'
        )
        ->withPivot(['answer_id','written_answer','time']);
        //->withTimestamps();
    }
}
