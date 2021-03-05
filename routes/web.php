<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CarBrandController;
use App\Http\Controllers\Admin\CarClassController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\CarTypeController;
use App\Http\Controllers\Admin\CarYearController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\HotelAmenityController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PartnerBannerController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\TourSportController;
use App\Http\Controllers\Admin\UserBannerController;
use App\Http\Controllers\Admin\YearController;
use App\Http\Controllers\Admin\PartnerController;
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
Route::get('/get-brand/{car_type_id}', [CommonController::class, 'getBrand'])->name('admin.get_brand'); 

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

Route::group(['prefix'=>'/admin/car-type', 'middleware' => 'admin'], function(){
    Route::get('/', [CarTypeController::class, 'index'])->name('car_type.index');
    Route::post('/store', [CarTypeController::class, 'store'])->name('car_type.store');
    Route::post('/update', [CarTypeController::class, 'update'])->name('car_type.update');
    Route::post('/destroy', [CarTypeController::class, 'destroy'])->name('car_type.destroy');
});

Route::group(['prefix'=>'/admin/brand', 'middleware' => 'admin'], function(){
    Route::get('/', [CarBrandController::class, 'index'])->name('brand.index');
    Route::post('/store', [CarBrandController::class, 'store'])->name('brand.store');
    Route::post('/update', [CarBrandController::class, 'update'])->name('brand.update');
    Route::post('/destroy', [CarBrandController::class, 'destroy'])->name('brand.destroy');
});

Route::group(['prefix'=>'/admin/model', 'middleware' => 'admin'], function(){
    Route::get('/', [CarModelController::class, 'index'])->name('model.index');
    Route::post('/store', [CarModelController::class, 'store'])->name('model.store');
    Route::post('/update', [CarModelController::class, 'update'])->name('model.update');
    Route::post('/destroy', [CarModelController::class, 'destroy'])->name('model.destroy');
});

Route::group(['prefix'=>'/admin/year', 'middleware' => 'admin'], function(){
    Route::get('/', [YearController::class, 'index'])->name('year.index');
    Route::post('/store', [YearController::class, 'store'])->name('year.store');
    Route::post('/update', [YearController::class, 'update'])->name('year.update');
    Route::post('/destroy', [YearController::class, 'destroy'])->name('year.destroy');
});

Route::group(['prefix'=>'/admin/class', 'middleware' => 'admin'], function(){
    Route::get('/', [CarClassController::class, 'index'])->name('class.index');
    Route::post('/store', [CarClassController::class, 'store'])->name('class.store');
    Route::post('/update', [CarClassController::class, 'update'])->name('class.update');
    Route::post('/destroy', [CarClassController::class, 'destroy'])->name('class.destroy');
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

Route::group(['prefix'=>'/admin/partner', 'middleware' => 'admin'], function(){
    Route::get('/', [PartnerController::class, 'index'])->name('partner.index');
    Route::get('/create', [PartnerController::class, 'create'])->name('partner.create');
    Route::post('/store', [PartnerController::class, 'store'])->name('partner.store');
    Route::get('/edit/{car_id}', [PartnerController::class, 'edit'])->name('partner.edit');
    Route::post('/update/{car_id}', [PartnerController::class, 'update'])->name('partner.update');
    Route::get('/details/{car_id}', [PartnerController::class, 'details'])->name('partner.details');
    Route::post('/destroy', [PartnerController::class, 'destroy'])->name('partner.destroy');
});

Route::group(['prefix'=>'/admin/user-banner', 'middleware' => 'admin'], function(){
    Route::get('/', [UserBannerController::class, 'index'])->name('user_banner.index');
    Route::get('/create', [UserBannerController::class, 'create'])->name('user_banner.create');
    Route::post('/store', [UserBannerController::class, 'store'])->name('user_banner.store');
    Route::get('/edit/{id}', [UserBannerController::class, 'edit'])->name('user_banner.edit');
    Route::post('/update/{id}', [UserBannerController::class, 'update'])->name('user_banner.update');
    Route::post('/destroy', [UserBannerController::class, 'destroy'])->name('user_banner.destroy');
});

Route::group(['prefix'=>'/admin/partner-banner', 'middleware' => 'admin'], function(){
    Route::get('/', [PartnerBannerController::class, 'index'])->name('partner_banner.index');
    Route::post('/store', [PartnerBannerController::class, 'store'])->name('partner_banner.store');
    Route::post('/update', [PartnerBannerController::class, 'update'])->name('partner_banner.update');
    Route::post('/destroy', [PartnerBannerController::class, 'destroy'])->name('partner_banner.destroy');
});

Route::group(['prefix'=>'/admin/banner', 'middleware' => 'admin'], function(){
    Route::get('/packages', [BannerController::class, 'bannerPackages'])->name('banner.packages');
    Route::post('/packages/update', [BannerController::class, 'bannerPackagesUpdate'])->name('banner.packages.update');
});

Route::group(['prefix'=>'/admin/notice', 'middleware' => 'admin'], function(){
    Route::get('/packages', [NoticeController::class, 'noticePackages'])->name('notice.packages');
    Route::post('/packages/update', [NoticeController::class, 'noticePackagesUpdate'])->name('notice.packages.update');
});
