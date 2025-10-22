<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Location;
use Livewire\Attributes\On;//عشان الجافا اسكربت
use Livewire\Carbon;//عشان التاريخ
class UserDashboard extends Component
{
    // المتغير ده بيخزن السجل الحالي لو المستخدم عامل Check in ولسه ما عملش Check out
    public $currentAttendance;
    
    public function mount()
    {
        // نبحث لو في تسجيل دخول مفتوح
        $this->currentAttendance = Attendance::where('user_id', auth()->id())
            ->whereNull('check_out')
            ->first();
    }

    // دالة لتسجيل الدخول
    //التاكد من احداثيات المستخدم
    #[On('performCheckIn')]//listiner->dispatch	
    public function checkIn($lat = null, $lng = null)
    {   
        //  التحقق من وجود الإحداثيات
        if (!$lat || !$lng) {
             session()->flash('error', ' فشل استلام الإحداثيات. يرجى السماح بالوصول للموقع.');
         return;
    }
    //  جلب إعدادات موقع العمل (مركز العمل ونصف القطر)
    $workLocation = Location::find(1); 
    
        //  التحقق من وجود احداثيات موقع العمل
    if (!$workLocation) {
         session()->flash('error','⚠️ لم يتم إعداد إحداثيات مركز العمل.');
         return;
    }

    //  حساب المسافة
    $distance = $this->calculateDistance(
        (float)$lat, (float)$lng, 
        $workLocation->latitude, $workLocation->longitude
    );
      //dd( $distance,$lat,$lng,$workLocation->latitude,$workLocation->longitude);
    
    //لان داله calculateDistance بتتعامل  بالمتر
    $allowedDistanceMeters = $workLocation->allowed_radius;  ; // نصف القطر المسموح به بالمتر
     //dd($distance,$allowedDistanceMeters,$distance - $allowedDistanceMeters,$distance > $allowedDistanceMeters);
      
    if ($distance > $allowedDistanceMeters) {
        session()->flash('error','🛑 أنت خارج نطاق موقع العمل المحدد. المسافة الحالية: ' . round($distance, 2) . ' متر.');
        return;
    }
      
  
    $this->currentAttendance = Attendance::create([
        'user_id' => auth()->id(),
        'check_in' => now(),
        'check_in_latitude' => $lat, // حفظ خط العرض الفعلي للموظف
        'check_in_longitude' => $lng, // حفظ خط الطول الفعلي للموظف
    ]);
        session()->flash('success','تم تسجيل الدخول بنجاح');
    }
    
    // دالة لحساب المسافة باستخدام Haversine Formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // نصف قطر الأرض متر

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c; // المسافة بالمتر
    }
      
    // دالة لتسجيل الخروج
    public function checkOut()
    {
        $this->currentAttendance->update([
            'check_out' => now(),
            // نحسب المدة بين check in و check out بالدقايق
            'duration' => abs(now()->diffInMinutes($this->currentAttendance->check_in)),
            
        ]);
        // (دخول ,خروج)إعادة تعيين حالة المكون
        $this->currentAttendance = null;

        session()->flash('success','تم تسجيل الخروج بنجاح');
    }
    #[On('locationError')]
    public function handleLocationError()
    {
        // عرض رسالة خطأ الجلسة
        session()->flash('error', 'يجب السماح بالوصول للموقع لتسجيل الحضور!');
    }
    // داخل Livewire/UserDashboard.php (أو حيث يتم معالجة البيانات)

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
        $records = Attendance::where('user_id', auth()->user()->id)
            ->latest()
            ->get();
        return view('livewire.user-dashboard', compact('records')) 
            ->layout('layouts.app');
    }
}