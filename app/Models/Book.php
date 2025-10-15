<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name','publication_year','book_type_id','author_id'
    ];
    // إضافة العلاقة مع نموذج BookType
    public function bookType()
    {
        return $this->belongsTo(bookType::class, 'book_type_id');
    }

    public function Author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
