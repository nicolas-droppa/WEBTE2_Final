<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['title'];

    public function questions()
    {
        // pivot table: test_question
        return $this->belongsToMany(
            Question::class,
            'test_question',   // pivot table
            'test_id',         // this model’s FK on pivot
            'question_id'      // related model’s FK on pivot
        );
    }

    public function historyTests()
    {
        return $this->hasMany(HistoryTest::class, 'test_id');
    }
}
