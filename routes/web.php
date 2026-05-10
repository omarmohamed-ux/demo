<?php
use App\Livewire\Employee;
use App\Models\Location;
use App\Models\Attendance;
//Requestكلاس لجلب إعدادات الموقع 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\ProductPage;
use App\Livewire\CartPage;
use App\Livewire\TaskManager;
use App\Livewire\EmployeeTaskView;
use App\Livewire\UserDashboard;
use App\Livewire\AdminDashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/productPage', ProductPage::class)->name('products');
Route::get('/cartPage', CartPage::class)->name('cart');
Route::get('/employee', Employee::class)->name('employee');
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');
Route::middleware(['auth'])->group(function () {
    // ✅ نقل المسارات هنا لضمان أن auth()->id() يعمل
    Route::get('/taskmanager', TaskManager::class)->name('manager.dashboard');
    Route::get('/employeetaskview', EmployeeTaskView::class)->name('employee.view');
});

Route::middleware(['auth','role:user'])->group(function(){ 
    Route::get('/user', App\Livewire\UserDashboard::class)->name('user.dashboard'); 
});

Route::middleware(['auth','role:admin'])->group(function(): void{
    Route::get('/admin', App\Livewire\AdminDashboard::class)->name('admin.dashboard'); 
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        
        $user = auth()->user(); 
        
        // التحقق الشرطي والتوجيه (هذا هو المنطق الوحيد الآن)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); 
        }
        
        // إذا لم يكن المدير، وجهه إلى صفحة المستخدم العادي
        return redirect()->route('user.dashboard'); 
        
    })->name('dashboard'); 
});
    // دالة لحساب المسافة باستخدام Haversine Formula
if (! function_exists('calculateDistance')) {
    function calculateDistance($lat1, $lon1, $lat2, $lon2)
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
}

Route::post('/api/check-location', function (Request $request) {
    
    $lat = $request->input('lat');
    $lng = $request->input('lng');
    
    //التحقق من الأمان
    if (empty($lat) || empty($lng) || $lat === '0' || $lng === '0') {
        return response()->json(['status' => 'error', 'message' => '🚫 فشل: لم يتم استلام الإحداثيات.'], 400);
        //بديل session()->flash('error', '🚫 فشل: لم يتم استلام الإحداثيات.');
    }

    //جلب إعدادات الموقع
    $workLocation = Location::find(2); 
    if (!$workLocation) {
         return response()->json(['status' => 'error', 'message' => '⚠️ لم يتم إعداد إحداثيات مركز العمل.'], 400);
    }

    // حساب المسافه بالمتر
    $distance = calculateDistance(
        (float)$lat, (float)$lng, 
        $workLocation->latitude, $workLocation->longitude
    );

    $allowedDistanceMeters = $workLocation->allowed_radius; 
    $distance_m = round($distance, 2);

    //المقارنة والرد
    if ($distance > $allowedDistanceMeters) {
        return response()->json([
            'status' => 'error',
            'message' => "Please check in from within the work site. You are {$distance_m} meters from the site.",
        ], 200);
    }
    Attendance::create([
        'user_id' => auth()->id(),
        'check_in' => now(),
        'check_in_latitude' => $lat, 
        'check_in_longitude' => $lng, 
    ]);
    //النجاح
    return response()->json([
        'status' => 'success',
        'message' => 'Successful login from within the work site.',
    ], 200);

})->middleware('auth')->name('api.check.location'); 
// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::redirect('user', 'user')
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


require __DIR__.'/auth.php';
