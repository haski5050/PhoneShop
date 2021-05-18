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

Route::get('/',[\App\Http\Controllers\PhoneController::class, 'returnPhones'])->name('homePage');
Route::get('/accessories',[\App\Http\Controllers\MainController::class,'accessoriesPage'])->name('accessoriesPage');
Route::get('/cases',[\App\Http\Controllers\CaseController::class,'returnCases'])->name('casesPage');
Route::get('/chargers',[\App\Http\Controllers\ChargersController::class,'returnChargers'])->name('chargersPage');
Route::get('/power_banks',[\App\Http\Controllers\PowerController::class,'returnPower'])->name('powerPage');
Route::get('/memory_cards',[\App\Http\Controllers\MemoryController::class,'returnMemory'])->name('memoryPage');
Route::get('/phone/{id}',[\App\Http\Controllers\PhoneController::class, 'aboutPhone'])->name('aboutPhonePage');
Route::get('/case/{id}',[\App\Http\Controllers\CaseController::class, 'aboutCase'])->name('aboutCasePage');
Route::get('/charger/{id}',[\App\Http\Controllers\ChargersController::class, 'aboutCharger'])->name('aboutChargerPage');
Route::get('/power/{id}',[\App\Http\Controllers\PowerController::class, 'aboutPower'])->name('aboutPowerPage');
Route::get('/memory/{id}',[\App\Http\Controllers\MemoryController::class, 'aboutMemory'])->name('aboutMemoryPage');
Route::post('/add/basket/{id}',[\App\Http\Controllers\UserController::class, 'addToBasket'])->name('addToBasketSubmit');
Route::get('/basket',[\App\Http\Controllers\UserController::class, 'basket'])->name('basketPage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->middleware('auth:admin')->group(function(){
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('adminIndex');
    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('adminLogout');
    Route::get('/add/phone',[\App\Http\Controllers\PhoneController::class, 'addPhonePage'])->name('addPhonePage');
    Route::get('/add/case',[\App\Http\Controllers\CaseController::class, 'addCasePage'])->name('addCasePage');
    Route::get('/add/charger',[\App\Http\Controllers\ChargersController::class, 'addChargerPage'])->name('addChargerPage');
    Route::get('/add/power',[\App\Http\Controllers\PowerController::class, 'addPowerPage'])->name('addPowerPage');
    Route::get('/add/memory',[\App\Http\Controllers\MemoryController::class, 'addMemoryPage'])->name('addMemoryPage');
    Route::get('/add/category',[\App\Http\Controllers\PhoneController::class, 'addCategoryPage'])->name('addCategoryPage');
    Route::post('/add/phone',[\App\Http\Controllers\PhoneController::class, 'addPhoneSubmit'])->name('addPhoneSubmit');
    Route::post('/add/case',[\App\Http\Controllers\CaseController::class, 'addCaseSubmit'])->name('addCaseSubmit');
    Route::post('/add/charger',[\App\Http\Controllers\ChargersController::class, 'addChargerSubmit'])->name('addChargerSubmit');
    Route::post('/add/power',[\App\Http\Controllers\PowerController::class, 'addPowerSubmit'])->name('addPowerSubmit');
    Route::post('/add/memory',[\App\Http\Controllers\MemoryController::class, 'addMemorySubmit'])->name('addMemorySubmit');
    Route::post('/add/category',[\App\Http\Controllers\PhoneController::class, 'addCategorySubmit'])->name('addCategorySubmit');
    Route::get('/update/case/{id}',[\App\Http\Controllers\CaseController::class, 'updateCasePage'])->name('updateCasePage');
    Route::get('/update/phone/{id}',[\App\Http\Controllers\PhoneController::class, 'updatePhonePage'])->name('updatePhonePage');
    Route::get('/update/charger/{id}',[\App\Http\Controllers\ChargersController::class, 'updateChargersPage'])->name('updateChargerPage');
    Route::get('/update/power/{id}',[\App\Http\Controllers\PowerController::class, 'updatePowerPage'])->name('updatePowerPage');
    Route::get('/update/memory/{id}',[\App\Http\Controllers\MemoryController::class, 'updateMemoryPage'])->name('updateMemoryPage');
    Route::post('/update/category',[\App\Http\Controllers\PhoneController::class, 'updateCategory'])->name('updateCategorySubmit');
    Route::post('/update/phone',[\App\Http\Controllers\PhoneController::class, 'updatePhone'])->name('updatePhoneSubmit');
    Route::post('/update/case',[\App\Http\Controllers\CaseController::class, 'updateCase'])->name('updateCaseSubmit');
    Route::post('/update/charger',[\App\Http\Controllers\ChargersController::class, 'updateCharge'])->name('updateChargerSubmit');
    Route::post('/update/power',[\App\Http\Controllers\PowerController::class, 'updatePower'])->name('updatePowerSubmit');
    Route::post('/update/memory',[\App\Http\Controllers\MemoryController::class, 'updateMemory'])->name('updateMemorySubmit');
    Route::get('/delete/phone/{id}',[\App\Http\Controllers\PhoneController::class, 'deletePhone'])->name('deletePhoneSubmit');
    Route::get('/delete/case/{id}',[\App\Http\Controllers\CaseController::class, 'deleteCase'])->name('deleteCaseSubmit');
    Route::get('/delete/charger/{id}',[\App\Http\Controllers\ChargersController::class, 'deleteCharger'])->name('deleteChargerSubmit');
    Route::get('/delete/power/{id}',[\App\Http\Controllers\PowerController::class, 'deletePower'])->name('deletePowerSubmit');
    Route::get('/delete/memory/{id}',[\App\Http\Controllers\MemoryController::class, 'deleteMemory'])->name('deleteMemorySubmit');
    Route::post('/delete/category',[\App\Http\Controllers\PhoneController::class, 'deleteCategory'])->name('deleteCategorySubmit');
});
Route::middleware('auth:web')->group(function (){
    Route::get('/about/user',[\App\Http\Controllers\UserController::class, 'aboutUser'])->name('aboutUserPage');
    Route::post('/about/user/update',[\App\Http\Controllers\UserController::class, 'aboutUserUpdate'])->name('aboutUserSubmit');
    Route::get('/add/favorite/{id}',[\App\Http\Controllers\UserController::class, 'addFavorite'])->name('addFavorite');
    Route::get('/get/favorite',[\App\Http\Controllers\UserController::class, 'getFavorite'])->name('favoritePage');
    Route::get('/delete/favorite/{id}',[\App\Http\Controllers\UserController::class, 'deleteFavorite'])->name('deleteFavoriteSubmit');
});


require __DIR__.'/auth.php';
