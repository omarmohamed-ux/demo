<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name','Date_of_birth' 
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }
}
