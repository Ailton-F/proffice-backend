<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'type',
        'reminder'
    ];

    public static $types = ['test', 'meeting', 'travel', 'other'];
}
