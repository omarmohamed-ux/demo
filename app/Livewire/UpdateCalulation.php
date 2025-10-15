<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Calulation;
class UpdateCalulation extends Component
{
    public $calulationId;
    public $first_number;
    public $second_number;
    public $operation;
    public $the_answer;

    public function mount($id){
        //لجلب السجل الصحيح من قاعدة البيانات
        $calulation = Calulation::findOrFail($id);
        $this->calulationId = $id;
        $this->first_number = $calulation->first_number;
        $this->second_number = $calulation->second_number;
        $this->operation = $calulation->operation;
        $this->the_answer = $calulation->the_answer;
    }
    //تعديل نتيجه التعديل في قاعده البيانات
    public function updateCalulation()
    {
        // حساب النتيجة الجديدة بناءً على القيم المدخلة
        switch ($this->operation) {
            case '+':// لو كان جمع اجمع و خزن
                $this->the_answer = $this->first_number + $this->second_number;
                break;
            case '-':// لو كان طرح اطرح و خزن
                $this->the_answer = $this->first_number - $this->second_number;
                break;
            case '*':// لو كان ضرب اضرب و خزن
                $this->the_answer = $this->first_number * $this->second_number;
                break;
            case '/':// لو كان قسمه اقسم و خزن
                $this->the_answer = $this->first_number / $this->second_number;
                break;
        }
            
        // إيجاد السجل وتحديثه باستخدام ID
        $calulation = Calulation::find($this->calulationId);
        //حفظ و تعديل القيم الجديده بالقديمه
        $calulation->update([
            'first_number' => $this->first_number,
            'second_number' => $this->second_number,
            'operation' => $this->operation,
            'the_answer' => $this->the_answer,
        ]);
        // العودة إلى صفحة الآلة الحاسبة الرئيسية
        return redirect('/test');
    }
    

    public function render()
    {
        return view('livewire.update-calulation')
        ->layout('layouts.app');
    }
}
