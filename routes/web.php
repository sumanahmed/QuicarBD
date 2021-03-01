<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\HotelAmenityController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PropertyTypeController;
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

Route::get('/get-city/{district_id}', [CommonController::class, 'getCity'])->name('admin.get_city'); 

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

Route::group(['prefix'=>'/admin/driver', 'middleware' => 'admin'], function(){
    Route::get('/', [DriverController::class, 'index'])->name('driver.index');
    Route::post('/store', [DriverController::class, 'store'])->name('driver.store');
    Route::post('/update', [DriverController::class, 'update'])->name('driver.update');
    Route::post('/destroy', [DriverController::class, 'destroy'])->name('driver.destroy');
});

Route::group(['prefix'=>'/admin/property-type', 'middleware' => 'admin'], function(){
    Route::get('/', [PropertyTypeController::class, 'index'])->name('property_type.index');
    Route::post('/store', [PropertyTypeController::class, 'store'])->name('property_type.store');
    Route::post('/update', [PropertyTypeController::class, 'update'])->name('property_type.update');
    Route::post('/destroy', [PropertyTypeController::class, 'destroy'])->name('property_type.destroy');
});

Route::group(['prefix'=>'/admin/hotel-amenity', 'middleware' => 'admin'], function(){
    Route::get('/', [HotelAmenityController::class, 'index'])->name('hotel_amenity.index');
    Route::post('/store', [HotelAmenityController::class, 'store'])->name('hotel_amenity.store');
    Route::post('/update', [HotelAmenityController::class, 'update'])->name('hotel_amenity.update');
    Route::post('/destroy', [HotelAmenityController::class, 'destroy'])->name('hotel_amenity.destroy');
});

Route::group(['prefix'=>'/admin/car', 'middleware' => 'admin'], function(){
    Route::get('/', [CarController::class, 'index'])->name('car.index');
    Route::get('/create', [CarController::class, 'create'])->name('car.create');
    Route::post('/store', [CarController::class, 'store'])->name('car.store');
    Route::get('/edit/{car_id}', [CarController::class, 'edit'])->name('car.edit');
    Route::post('/update/{car_id}', [CarController::class, 'update'])->name('car.update');
    Route::get('/details/{car_id}', [CarController::class, 'details'])->name('car.details');
    Route::get('/expired', [CarController::class, 'expired'])->name('car.expired');
    Route::post('/destroy', [CarController::class, 'destroy'])->name('car.destroy');
});

Route::group(['prefix'=>'/admin/banner', 'middleware' => 'admin'], function(){
    Route::get('/packages', [BannerController::class, 'bannerPackages'])->name('banner.packages');
    Route::post('/packages/update', [BannerController::class, 'bannerPackagesUpdate'])->name('banner.packages.update');
});

Route::group(['prefix'=>'/admin/notice', 'middleware' => 'admin'], function(){
    Route::get('/packages', [NoticeController::class, 'noticePackages'])->name('notice.packages');
    Route::post('/packages/update', [NoticeController::class, 'noticePackagesUpdate'])->name('notice.packages.update');
});
