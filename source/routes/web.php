<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\AdminLocationsController;
use App\Http\Controllers\admin\AdminReligionController;
use App\Http\Controllers\admin\AdminPaymentsController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return redirect()->route('adminlogin');
});
Route::get('profile/{share_code}', [\App\Http\Controllers\HomeController::class, 'clientProfile']);

/** Super Admin and admins routes **/
Route::get('admin/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'adminloginform'])
    ->name('adminlogin');

Route::post('admin/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'adminlogin'])->name('adminloginpost');

/** Super Admin routes **/
Route::middleware('superAdminAuth')->prefix('admin')->group(function(){


    Route::get('/dashboard', [DashboardController::class, 'superAdminDashboard'])->name('superAdminDashboardShow');
    ///////////////////////////////////////// Pages/////////////////////////////////////////
    Route::get('/header-info', [DashboardController::class, 'headerInfo'])->name('headerinfo');
    Route::put('/header-info', [DashboardController::class, 'headerInfoEdit'])->name('headerinfoEdit');

//    countries, city provinces and areas
    Route::get('/countries', [AdminLocationsController::class, 'index'])->name('admin.countries.index');
    Route::get('/countries/create', [AdminLocationsController::class, 'create'])->name('admin.countries.create');
    Route::post('/countries', [AdminLocationsController::class, 'store'])->name('admin.countries.store');
    Route::get('/countries/{country}/edit', [AdminLocationsController::class, 'edit'])->name('admin.countries.edit');
    Route::put('/countries/{country}', [AdminLocationsController::class, 'update'])->name('admin.countries.update');
    Route::delete('/countries/{country}', [AdminLocationsController::class, 'destroy'])->name('admin.countries.destroy');


//    prvince
    Route::get('/provinces', [AdminLocationsController::class, 'provincesIndex'])->name('admin.provinces.index');
    Route::get('/provinces/create', [AdminLocationsController::class, 'provincesCreate'])->name('admin.provinces.create');
    Route::post('/provinces', [AdminLocationsController::class, 'provincesStore'])->name('admin.provinces.store');
    Route::get('/provinces/{province}/edit', [AdminLocationsController::class, 'provincesEdit'])->name('admin.provinces.edit');
    Route::put('/provinces/{province}', [AdminLocationsController::class, 'provincesUpdate'])->name('admin.provinces.update');
    Route::delete('/provinces/{province}', [AdminLocationsController::class, 'provincesDestroy'])->name('admin.provinces.destroy');

    // City Routes
    Route::get('/cities', [AdminLocationsController::class, 'cityindex'])->name('admin.cities.index');
    Route::get('/cities/create', [AdminLocationsController::class, 'citycreate'])->name('admin.cities.create');
    Route::post('/cities', [AdminLocationsController::class, 'citystore'])->name('admin.cities.store');
    Route::get('/cities/{city}/edit', [AdminLocationsController::class, 'cityedit'])->name('admin.cities.edit');
    Route::put('/cities/{city}', [AdminLocationsController::class, 'cityupdate'])->name('admin.cities.update');
    Route::delete('/cities/{city}', [AdminLocationsController::class, 'citydestroy'])->name('admin.cities.destroy');

    // Area Routes
    Route::get('/areas', [AdminLocationsController::class, 'areaindex'])->name('admin.areas.index');
    Route::get('/areas/create', [AdminLocationsController::class, 'areacreate'])->name('admin.areas.create');
    Route::post('/areas', [AdminLocationsController::class, 'areastore'])->name('admin.areas.store');
    Route::get('/areas/{area}/edit', [AdminLocationsController::class, 'areaedit'])->name('admin.areas.edit');
    Route::put('/areas/{area}', [AdminLocationsController::class, 'areaupdate'])->name('admin.areas.update');
    Route::delete('/areas/{area}', [AdminLocationsController::class, 'areadestroy'])->name('admin.areas.destroy');


    // Religion Routes
    Route::get('/religions', [AdminReligionController::class, 'index'])->name('admin.religions.index');
    Route::get('/religions/create', [AdminReligionController::class, 'create'])->name('admin.religions.create');
    Route::post('/religions', [AdminReligionController::class, 'store'])->name('admin.religions.store');
    Route::get('/religions/{religion}/edit', [AdminReligionController::class, 'edit'])->name('admin.religions.edit');
    Route::put('/religions/{religion}', [AdminReligionController::class, 'update'])->name('admin.religions.update');
    Route::delete('/religions/{religion}', [AdminReligionController::class, 'destroy'])->name('admin.religions.destroy');
    // AJAX Routes
    Route::post('/cities/check-name', [AdminLocationsController::class, 'checkName'])->name('admin.cities.check-name');

    // Area Routes
    Route::get('/payments/pending', [AdminPaymentsController::class, 'pending'])->name('admin.payment.pending');


});

require __DIR__.'/auth.php';
