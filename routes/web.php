<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\TourSportController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin',[AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/signin',[AuthController::class, 'signin'])->name('admin.signin');
Route::post('/admin/logout',[AuthController::class, 'logout'])->name('admin.logout');

Route::group(['prefix'=>'/admin', 'middleware' => 'admin'], function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['prefix'=>'/admin/setting/district', 'middleware' => 'admin'], function(){
    Route::get('/', [DistrictController::class, 'index'])->name('setting.district.index');
    Route::post('/store', [DistrictController::class, 'store'])->name('setting.district.store');
    Route::post('/update', [DistrictController::class, 'update'])->name('setting.district.update');
    Route::post('/destroy', [DistrictController::class, 'destroy'])->name('setting.district.destroy');
});

Route::group(['prefix'=>'/admin/setting/city', 'middleware' => 'admin'], function(){
    Route::get('/', [CityController::class, 'index'])->name('setting.city.index');
    Route::post('/store', [CityController::class, 'store'])->name('setting.city.store');
    Route::post('/update', [CityController::class, 'update'])->name('setting.city.update');
    Route::post('/destroy', [CityController::class, 'destroy'])->name('setting.city.destroy');
});

Route::group(['prefix'=>'/admin/setting/tour-spot', 'middleware' => 'admin'], function(){
    Route::get('/', [TourSportController::class, 'index'])->name('setting.tour_spot.index');
    Route::post('/store', [TourSportController::class, 'store'])->name('setting.tour_spot.store');
    Route::post('/update', [TourSportController::class, 'update'])->name('setting.tour_spot.update');
    Route::post('/destroy', [TourSportController::class, 'destroy'])->name('setting.tour_spot.destroy');
});
