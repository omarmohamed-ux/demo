<?php
use App\Models\Location;
use App\Models\Attendance;
//Requestكلاس لجلب إعدادات الموقع 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Test;
use App\Livewire\UpdateCalulation;
use App\Livewire\ViewBookDetails;
use App\Livewire\AddBookType;
use App\Livewire\UpdateDeleteBook;
use App\Livewire\AddBook;
use App\Livewire\AuthorsTable;
use App\Livewire\InfoBookTable;
use App\Livewire\EditAll;
use App\Livewire\ProductPage;
use App\Livewire\CartPage;
use App\Livewire\TaskManager;
use App\Livewire\EmployeeTaskView;
use App\Livewire\UserDashboard;
use App\Livewire\AdminDashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//رابط صفحة تست 
Route::get('/test', Test::class)->name('t');

Route::get('/ubdateCalc', UpdateCalulation::class)->name('update.calc');
Route::get('/update-calulation/{id}', UpdateCalulation::class)->name('test.update');
Route::get('/viewbook', ViewBookDetails::class)->name('books.view');
Route::get('/viewauthor', AuthorsTable::class)->name('author.view');
Route::get('/addbooktype', AddBookType::class)->name('books.add');
Route::get('/deletebook', UpdateDeleteBook::class)->name('books.delete');
Route::get('/addbook', AddBook::class)->name('books.table');
Route::get('/infoTable', InfoBookTable::class)->name('info.table');
Route::get('/editall/{bookId}', EditAll::class)->name('edit.all');
Route::get('/productPage', ProductPage::class)->name('products');
Route::get('/cartPage', CartPage::class)->name('cart');

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
    $workLocation = Location::find(1); 
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
            'message' => "يرجو تسجيل الحضور من داخل موقع العمل. أنت تبعد مسافة {$distance_m} متر عن الموقع",
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
        'message' => 'تم تسجيل الدخول بنجاح من داخل موقع العمل.',
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
