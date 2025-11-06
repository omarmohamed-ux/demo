<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;

class AdminDashboard extends Component
{
    public function getDailyStatusAndColor($record)
    {
        //  تحديد الساعات المطلوبة يومياً (بالدقائق)
        $requiredMinutes = 420; // 60 دقيقة للتجربة
        $requiredHours = $requiredMinutes / 60; // تحويل الدقائق إلى ساعات
        $completedMinutes = (int)$record->duration;
        // حالة اللون الأحمر (لم يتم تسجيل الخروج بعد)
        if (!($record->check_out)) {
            return [
                'color' => 'bg-danger',   // أحمر: لسا ما عملش تسجيل خروج
                'status' => '🔴 انتظار تسجيل الخروج',
                'duration' => $completedMinutes ,
                'requiredMinutes' => $requiredMinutes ,
                'requiredHours'=> $requiredHours 
            ];
        }
        
        //  حالة اللون الأخضر (أنجز الهدف أو تجاوزه)
        if ($record->duration >= $requiredMinutes) {
            return [
                'color' => 'bg-success',  // أخضر: تم تحقيق 60 دقيقة أو أكثر
                'status' => '🟢 تم تحقيق الوقت المطلوب',
                'duration' => $completedMinutes,
                'requiredMinutes' => $requiredMinutes,
                'requiredHours'=> $requiredHours 
            ];
        } 
        
        // حالة اللون الأصفر (أقل من المطلوب)
        else {
            return [
                'color' => 'bg-warning',  // أصفر: أقل من 60 دقيقة
                'status' => '🟡 أقل من الوقت المطلوب',
                'duration' => $completedMinutes,
                'requiredMinutes' => $requiredMinutes,
                'requiredHours'=> $requiredHours 
            ];
        }
    }
    public function render()
{
    // جلب السجلات وترتيبها ثم تجميعها حسب اسم المستخدم
    $records = Attendance::with('user')
        ->latest()
        ->get()
        ->groupBy('user.name'); // 👈 التجميع حسب اسم المستخدم هنا
        
    return view('livewire.admin-dashboard', compact(['records']))
        ->layout('layouts.app');
}
}
