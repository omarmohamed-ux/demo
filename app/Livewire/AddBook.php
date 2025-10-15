<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book; // استيراد Model الكتاب
use App\Models\BookType; // استيراد Model نوع الكتاب
use App\Models\Author;

class AddBook extends Component
{

    // الخصائص العامة لكل حقل في جدول الكتب
    public $name;
    public $book_type_id;
    public $publication_year;
    public $bookTypes; // خاصية لتخزين أنواع الكتب من قاعدة البيانات
    public $author_id;
    
   
    // دالة save() تُنفذ عند إرسال النموذج لحفظ الكتاب
    public function save()
    {
        
 //dump($this->name, $this->Author_name, $this->book_type_id, $this->publication_year);
        // إنشاء سجل جديد في جدول books وحفظ البيانات
        Book::create([
            'name' => $this->name,
            'author_id' => $this->author_id, 
            'book_type_id' => $this->book_type_id,
            'publication_year' => $this->publication_year,
        ]);

        // إظهار رسالة نجاح للمستخدم
        session()->flash('message', 'تم إضافة الكتاب بنجاح!');

        // إعادة ضبط قيم الخصائص لتفريغ حقول الإدخال
        $this->reset(['name', 'book_type_id', 'publication_year']);
        //$this->redirect('/viewbook', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.add-book')
        ->layout('layouts.app');
    }
}
