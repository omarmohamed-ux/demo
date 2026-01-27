<?php

namespace App\Livewire;

use Livewire\Component;

class Employee extends Component
{
   // حالة ظهور الـ Popup الأساسي
    public $showMainModal = false;
    
    // حالة ظهور نموذج إضافة وحدة جديدة (Popup فرعي أو تبديل محتوى)
    public $showAddUnitForm = false;

    // دالة لفتح الـ Popup الأساسي
    public function toggleMainModal()
    {
        $this->showMainModal = !$this->showMainModal;
        $this->showAddUnitForm = false; // لإعادة التعيين عند الفتح
    }
    // دالة للانتقال لنموذج الإضافة
    public function openAddUnit()
    {
        $this->showAddUnitForm = true;
    }
    
    public function render()
    {
        return view('livewire.employee')->layout('layouts.app');
    }
}
