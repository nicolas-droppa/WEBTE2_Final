<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name_sk','name_en'];

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'question_tag',
            'tag_id',
            'question_id'
        );
    }
}
