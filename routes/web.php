<?php

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

Route::middleware(['auth','role:user'])->group(function(){ // 👈 تطبيق دور 'user'
    // تم استبدال المسار المؤقت بـ Livewire Component
    Route::get('/user', UserDashboard::class)->name('user.dashboard'); 
    Route::get('/dashboard', UserDashboard::class)->name('dashboard'); 
});

Route::middleware(['auth','role:admin'])->group(function(): void{ // 👈 تطبيق دور 'admin'
    // تم استبدال المسار المؤقت بـ Livewire Component
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard'); 
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard'); 
});


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
