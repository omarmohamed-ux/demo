<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;

class AdminDashboard extends Component
{
    public function render()
    {
        // هنا بنعرض كل السجلات مع ربطها بالمستخدم (عشان نجيب الاسم)
        $records = Attendance::with('user')->latest()->get();
        return view('livewire.admin-dashboard', compact(['records']))
            ->layout('layouts.app');
    }
}
