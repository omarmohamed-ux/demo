<?php

namespace App\Livewire;

use App\Models\calulation;
use Livewire\Component;

class Test extends Component
{
    public $count = 0;
    public $count2 = 0;
    public $answer = 0;
    public $history = [];
    

    // دالة لتسجيل العمليات في قاعدة البيانات
    private function saveInCalculation(string $operation): void
    {
        // إنشاء سجل جديد في جدول 'calculations'
     calulation::create([
            'first_number' => $this->count,
            'second_number' => $this->count2,
            'operation' => $operation,
            'the_answer' => $this->answer,
        ]);

        // تحديث سجل العمليات بعد الحفظ
        $this->loadHistory();
    }

    // دالة لاسترجاع سجل العمليات من قاعدة البيانات
    public function loadHistory(): void
    {
        // استرجاع كل العمليات وترتيبها من الأحدث للأقدم
        $this->history = calulation::orderBy('created_at', 'desc')->get();
    }

    public function mount(): void
    {
        // تحميل السجل عند بداية تشغيل الحاسبه
        $this->loadHistory();
    }

    public function add(): void
    {
        $this->answer = $this->count + $this->count2;
        $this->saveInCalculation('+');
    }

    public function sub(): void
    {
        $this->answer = $this->count - $this->count2;
        $this->saveInCalculation('-');
    }

    public function multi(): void
    {
        $this->answer = $this->count * $this->count2;
        $this->saveInCalculation('*');
    }

    public function div(): void
    {
        if ($this->count2 != 0) {
            $this->answer = $this->count / $this->count2;
            $this->saveInCalculation('/');
        } else {
            // يمكنك إضافة رسالة خطأ هنا
        }
    }
    //داله حذف عنصر واحد من العمليات الحسابيه
    public function deleteItem($id){
      calulation::destroy($id);
      //استدعاء الداله لتحديث الواجهه
      $this->loadHistory();

    }
    //داله حذف جميع العناصر من العمليات الحسابيه
    public function deleteAllItems():void{
        calulation::truncate();
      //استدعاء الداله لتحديث الواجهه
        $this->loadHistory();

    }
    public function render()
    {
        return view('livewire.test')
        ->layout('layouts.app');
    }
}
