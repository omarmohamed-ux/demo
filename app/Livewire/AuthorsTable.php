<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Author;

class AuthorsTable extends Component
{
    public $name;
    public $author_id;
    public $Date_of_birth;

    public function submit()
    {
        
        Author::create([
            'name' => $this->name,
            'author_id' => $this->author_id, // حفظ اسم المؤلف
            'Date_of_birth'=>$this->Date_of_birth,
        ]);

        // إظهار رسالة نجاح للمستخدم
        session()->flash('message', 'تم إضافة الكتاب بنجاح!');

        // إعادة ضبط قيم الخصائص لتفريغ حقول الإدخال
        $this->reset(['name', 'Date_of_birth', 'author_id']);
        $this->redirect('/viewbook', navigate: true);
    }



    public function render()
    {
        $authors = Author::all();
        return view('livewire.authors-table',compact('authors'))
        ->layout('layouts.app');
    }
}
