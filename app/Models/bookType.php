<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bookType extends Model
{
    protected $fillable = [
        'type',
    ];
    // إضافة العلاقة مع نموذج Book
    public function books()
    {
        return $this->hasMany(Book::class, 'book_type_id');
    }
}
