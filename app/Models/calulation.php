<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calulation extends Model
{
    protected $fillable = [
        'first_number',
        'second_number',
        'operation',
        'the_answer',
    ];
}
