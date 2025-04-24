<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassPlan extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'material_url'
    ];
}
