<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\bookType;

class AddBookType extends Component
{
public $type;


    // دالة لحفظ نوع الكتاب في قاعدة البيانات
    public function save()
    {
        // التحقق من صحة البيانات وإنشاء السجل مباشرة
        bookType::create([

            'type' => $this->type,
        ]);
       
        // إعادة ضبط حقل الإدخال بعد الحفظ
        $this->reset('type');

        // رسالة تأكيد (يمكنك استخدامها في الواجهة)
        session()->flash('message', 'تم إضافة نوع الكتاب بنجاح.');
        $this->redirect('/viewbook', navigate: true);
    }

    
    public function render()
    {
        return view('livewire.add-book-type')
        ->layout('layouts.app');
    }
}
