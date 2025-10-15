<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title','is_completed','category_id','user_id'
    ];
    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
