<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookType;
use App\Models\Book;

class UpdateDeleteBook extends Component
{
 public $books; // تعريف خاصية عامة لتخزين قائمة الكتب

    /**
     * دالة mount يتم تشغيلها تلقائيا عند تحميل المكون.
     * وظيفتها هي جلب كل الكتب من قاعدة البيانات.
     */
    public function mount()
    {
        // استخدام Model Book لجلب كل السجلات من الجدول
        // "with('bookType')" يجلب نوع الكتاب المرتبط بكل كتاب
        $this->books = Book::with('bookType')->get();
    }

    public function deleteBook($bookId)
    {
        // استخدام دالة destroy لحذف الكتاب مباشرة
        Book::destroy($bookId);

        // تحديث قائمة الكتب بعد الحذف
        $this->books = Book::with('bookType')->get();
    }
    
    public function render()
    {
        return view('livewire.update-delete-book')
        ->layout('layouts.app');
    }
}
