<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Answer extends Model
{
    protected $fillable = ['answer', 'isCorrect'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
