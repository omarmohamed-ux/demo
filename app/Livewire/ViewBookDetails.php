<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookType ;//استدعاء مودل من قاعده البيانات محتاجه شرح***
use App\Models\Book; 
use App\Models\Author; 
use App\Livewire\InfoBookTable; 
use App\Livewire\EditAll; 
class ViewBookDetails extends Component
{
    public $name;
    public $author_id;
    public $book_type_id;
    public $publication_year;

    public $bookCount;
    public $bookTypes ; // تعريف خاصية عامة لتخزين أنواع الكتب
    public $books; 
    public $authors; 

    
    //داله mountتظهر مع بدايه الصفحه و تظهر معلومات الكتاب
    public function mount()
    {
        // استخدام Model BookType لجلب كل السجلات من الجدول
        $this->bookTypes = BookType::all();
        $this->books = Book::all();
        $this->authors = Author::all();

    }

    public function save()
    {
        
 
        // إنشاء سجل جديد في جدول books وحفظ البيانات
        Book::create([
            'name' => $this->name,
            'author_id' => $this->author_id, // حفظ اسم المؤلف
            'book_type_id' => $this->book_type_id,
            'publication_year' => $this->publication_year,
        ]);

        // إظهار رسالة نجاح للمستخدم
        session()->flash('message', 'تم إضافة الكتاب بنجاح!');

        // إعادة ضبط قيم الخصائص لتفريغ حقول الإدخال
        $this->reset(['name', 'book_type_id', 'publication_year']);
        $this->redirect('/viewbook', navigate: true);
    }
    public function deleteBookType($bookId)
    {
        // استخدام دالة destroy لحذف الكتاب مباشرة
        BookType::destroy($bookId);

        // تحديث قائمة الكتب بعد الحذف
        $this->bookTypes = BookType::all();
    }

    
    
    public function render()
    {   
        $bookTypes = BookType::all(); 
        $books = Book::all();
        $authors = Author::all();

        $this->bookCount = Book::count();
        
        
        return view('livewire.view-book-details', compact('bookTypes', 'books','authors'))
            ->layout('layouts.app');
    }
}