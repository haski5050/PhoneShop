<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\PhoneController::class, 'returnPhones'])->name("homePage");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->middleware('auth:admin')->group(function(){
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('adminIndex');
    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('adminLogout');
});


require __DIR__.'/auth.php';
