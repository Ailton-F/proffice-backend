<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighlitedLesson extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'shared',
        'media_url'
    ];
}
