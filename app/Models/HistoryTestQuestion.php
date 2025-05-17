<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTestQuestion extends Model
{
    protected $table = 'history_test_question';
    public $timestamps = false; // unless you added timestamps

    protected $fillable = [
      'history_test_id','question_id',
      'answer_id','written_answer','time'
    ];

    public function historyTest()
    {
        return $this->belongsTo(HistoryTest::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}

