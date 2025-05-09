<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name_sk', 'name_en'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
