<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Location;
use App\Models\Attendance;
// استدعاء الـ Livewire Components
use App\Livewire\Employee;
use App\Livewire\ProductPage;
use App\Livewire\CartPage;
use App\Livewire\TaskManager;
use App\Livewire\EmployeeTaskView;
use App\Livewire\UserDashboard;
use App\Livewire\AdminDashboard;

/*
|--------------------------------------------------------------------------
| Public Routes (الروابط العامة)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

// تغيير اللغة
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (الروابط التي تتطلب تسجيل دخول)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- نظام توجيه الـ Dashboard الذكي ---
    Route::get('/dashboard', function () {
        $user = auth()->user(); 
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); 
        }
        return redirect()->route('user.dashboard'); 
    })->name('dashboard');

    // --- روابط الحضور والـ GPS ---
    Route::get('/employee', Employee::class)->name('employee');
    
    Route::post('/api/check-location', function (Request $request) {
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if (empty($lat) || empty($lng) || $lat === '0' || $lng === '0') {
            return response()->json(['status' => 'error', 'message' => '🚫 فشل: لم يتم استلام الإحداثيات.'], 400);
        }

        $workLocation = Location::find(2); 
        if (!$workLocation) {
             return response()->json(['status' => 'error', 'message' => '⚠️ لم يتم إعداد إحداثيات مركز العمل.'], 400);
        }

        $distance = calculateDistance((float)$lat, (float)$lng, $workLocation->latitude, $workLocation->longitude);
        $allowedDistanceMeters = $workLocation->allowed_radius; 
        $distance_m = round($distance, 2);

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

        return response()->json(['status' => 'success', 'message' => 'Successful login from within the work site.'], 200);
    })->name('api.check.location');

    // --- روابط المهام والمنتجات ---
    Route::get('/productPage', ProductPage::class)->name('products');
    Route::get('/cartPage', CartPage::class)->name('cart');
    Route::get('/taskmanager', TaskManager::class)->name('manager.dashboard');
    Route::get('/employeetaskview', EmployeeTaskView::class)->name('employee.view');

    // --- روابط الملف الشخصي (المضافة من Laravel Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Role Based Routes (روابط بناءً على الصلاحيات)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function(){ 
    Route::get('/user', UserDashboard::class)->name('user.dashboard'); 
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard'); 
});

/*
|--------------------------------------------------------------------------
| Helper Functions & Auth
|--------------------------------------------------------------------------
*/
if (! function_exists('calculateDistance')) {
    function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000; 
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; 
    }
}

require __DIR__.'/auth.php';