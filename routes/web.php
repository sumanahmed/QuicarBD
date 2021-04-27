<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CarBrandController;
use App\Http\Controllers\Admin\CarClassController;
use App\Http\Controllers\Admin\CarColorController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\CarPackageController;
use App\Http\Controllers\Admin\HotelPackageController;
use App\Http\Controllers\Admin\TravelPackageController;
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
use App\Http\Controllers\Admin\CancellationReasonController;
use App\Http\Controllers\Admin\CarPackageRideController;
use App\Http\Controllers\Admin\HotelPackageRideController;
use App\Http\Controllers\Admin\PackageReviewController;
use App\Http\Controllers\Admin\PrivacyController;
use App\Http\Controllers\Admin\RideController;
use App\Http\Controllers\Admin\SmsNotificationController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\WithdrawController;
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
Route::get('/get-spot/{district_id}', [CommonController::class, 'getSpot'])->name('admin.get_spot'); 
Route::get('/get-car/{owner_id}', [CommonController::class, 'getCar'])->name('admin.get_car'); 
Route::get('/get-sit/{car_type}', [CommonController::class, 'getSit'])->name('admin.get_sit'); 
Route::get('/get-car-brand/{car_type}', [CommonController::class, 'getCarBrand'])->name('admin.get_car_brand'); 
Route::get('/get-car-model/{car_type}/{car_brand}', [CommonController::class, 'getCarModel'])->name('admin.get_car_model'); 
Route::get('/get-car-year/{car_type}/{car_model}', [CommonController::class, 'getCarYear'])->name('admin.get_car_year'); 
Route::get('/get-car-sit/{car_id}', [CommonController::class, 'getCarSit'])->name('admin.get_car_sit'); 
Route::get('/get-hotel-package-charge/{owner_id}', [CommonController::class, 'getHotelPackageCharge'])->name('admin.get_hotel_package_charge'); 
Route::get('/get-travel-package-charge/{owner_id}', [CommonController::class, 'getTravelPackageCharge'])->name('admin.get_travel_package_charge'); 
Route::get('/sms/list', [CommonController::class, 'smsList'])->name('admin.sms_list'); 
Route::post('/sms/store', [CommonController::class, 'smsStore'])->name('admin.sms_store'); 
Route::post('/sms/destroy', [CommonController::class, 'smsDestroy'])->name('admin.sms_destroy'); 

Route::get('/admin',[AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/signin',[AuthController::class, 'signin'])->name('admin.signin');
Route::post('/admin/logout',[AuthController::class, 'logout'])->name('admin.logout');

Route::group(['prefix'=>'/admin', 'middleware' => 'admin'], function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['prefix'=>'/admin/setting/user-app-info', 'middleware' => 'admin'], function(){
    Route::get('/edit', [UserController::class, 'userAppInfoEdit'])->name('setting.user-app-info.edit');
    Route::post('/update', [UserController::class, 'userAppInfoUpdate'])->name('setting.user-app-info.update');
});

Route::group(['prefix'=>'/admin/setting/user-app', 'middleware' => 'admin'], function(){
    Route::get('/edit', [UserController::class, 'userAppSettingEdit'])->name('setting.user-app.edit');
    Route::post('/update', [UserController::class, 'userAppSettingUpdate'])->name('setting.user-app.update');
});

Route::group(['prefix'=>'/admin/setting/partner-app', 'middleware' => 'admin'], function(){
    Route::get('/edit', [PartnerController::class, 'partnerAppSettingEdit'])->name('setting.partner-app.edit');
    Route::post('/update', [PartnerController::class, 'partnerAppSettingUpdate'])->name('setting.partner-app.update');
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
    Route::get('/create', [DriverController::class, 'create'])->name('driver.create');
    Route::post('/store', [DriverController::class, 'store'])->name('driver.store');
    Route::get('/edit/{id}', [DriverController::class, 'edit'])->name('driver.edit');
    Route::post('/update/{id}', [DriverController::class, 'update'])->name('driver.update');
    Route::post('/destroy', [DriverController::class, 'destroy'])->name('driver.destroy');
    Route::get('/status-update', [DriverController::class, 'statusUpdate'])->name('driver.status-update');
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

Route::group(['prefix'=>'/admin/color', 'middleware' => 'admin'], function(){
    Route::get('/', [CarColorController::class, 'index'])->name('color.index');
    Route::post('/store', [CarColorController::class, 'store'])->name('color.store');
    Route::post('/update', [CarColorController::class, 'update'])->name('color.update');
    Route::post('/destroy', [CarColorController::class, 'destroy'])->name('color.destroy');
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
    Route::get('/show/{car_id}', [CarController::class, 'show'])->name('car.show');
    Route::post('/update/{car_id}', [CarController::class, 'update'])->name('car.update');
    Route::get('/details/{car_id}', [CarController::class, 'details'])->name('car.details');
    Route::get('/expired', [CarController::class, 'expired'])->name('car.expired');
    Route::post('/destroy', [CarController::class, 'destroy'])->name('car.destroy');
    Route::post('/owner-notification-send', [CarController::class, 'ownerSendNotification'])->name('car.destroy');
});

Route::group(['prefix'=>'/admin/coupon', 'middleware' => 'admin'], function(){
    Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::post('/update/{coupon_id}', [CouponController::class, 'update'])->name('coupon.update');
    Route::post('/destroy', [CouponController::class, 'destroy'])->name('coupon.destroy');
    Route::get('/used-list', [CouponController::class, 'usedList'])->name('coupon.usedList');
});

Route::group(['prefix'=>'/admin/partner', 'middleware' => 'admin'], function(){
    Route::get('/', [PartnerController::class, 'index'])->name('partner.index');
    Route::get('/create', [PartnerController::class, 'create'])->name('partner.create');
    Route::post('/store', [PartnerController::class, 'store'])->name('partner.store');
    Route::get('/edit/{car_id}', [PartnerController::class, 'edit'])->name('partner.edit');
    Route::post('/update/{car_id}', [PartnerController::class, 'update'])->name('partner.update');
    Route::get('/details/{car_id}', [PartnerController::class, 'details'])->name('partner.details');
    Route::post('/notification/send', [PartnerController::class, 'notificationSend'])->name('partner.notification.send');
    Route::post('/destroy', [PartnerController::class, 'destroy'])->name('partner.destroy');
    Route::get('/status-update', [PartnerController::class, 'statusUpdate'])->name('partner.status-update');
    Route::get('/verification', [PartnerController::class, 'verification'])->name('partner.verification');
    Route::get('/account-type-change-request', [PartnerController::class, 'accountTypeChangeRequest'])->name('partner.account_type_change_request');
    Route::get('/account-type-change-approve', [PartnerController::class, 'accountTypeChangeApprove'])->name('partner.account_type_change_approve');
    Route::post('/account-type-change-cancel', [PartnerController::class, 'accountTypeChangeCancel'])->name('partner.account_type_change_cancel');
    Route::post('/balance/add', [PartnerController::class, 'balanceAdd'])->name('partner.balance.add');
});

Route::group(['prefix'=>'/admin/user', 'middleware' => 'admin'], function(){
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/status/update', [UserController::class, 'create'])->name('user.status.update');
    Route::get('/details/{user_id}', [UserController::class, 'details'])->name('user.details');
    Route::post('/notification/send', [UserController::class, 'notificationSend'])->name('user.notification.send');
    Route::post('/balance/add', [UserController::class, 'balanceAdd'])->name('user.balance.add');
    Route::get('/user-log', [UserController::class, 'userLogList'])->name('user.user_log_list');
    Route::get('/log/{id}', [UserController::class, 'log'])->name('user.log');
});

Route::group(['prefix'=>'/admin/user-banner', 'middleware' => 'admin'], function(){
    Route::get('/', [UserBannerController::class, 'index'])->name('user_banner.index');
    Route::get('/create', [UserBannerController::class, 'create'])->name('user_banner.create');
    Route::post('/store', [UserBannerController::class, 'store'])->name('user_banner.store');
    Route::get('/edit/{id}', [UserBannerController::class, 'edit'])->name('user_banner.edit');
    Route::post('/update/{id}', [UserBannerController::class, 'update'])->name('user_banner.update');
    Route::post('/destroy', [UserBannerController::class, 'destroy'])->name('user_banner.destroy');
    Route::get('/up/{id}', [UserBannerController::class, 'up'])->name('user_banner.up');
    Route::get('/down/{id}', [UserBannerController::class, 'down'])->name('user_banner.down');
});

Route::group(['prefix'=>'/admin/partner-banner', 'middleware' => 'admin'], function(){
    Route::get('/', [PartnerBannerController::class, 'index'])->name('partner_banner.index');
    Route::get('/create', [PartnerBannerController::class, 'create'])->name('partner_banner.create');
    Route::post('/store', [PartnerBannerController::class, 'store'])->name('partner_banner.store');
    Route::get('/edit/{id}', [PartnerBannerController::class, 'edit'])->name('partner_banner.edit');
    Route::post('/update/{id}', [PartnerBannerController::class, 'update'])->name('partner_banner.update');
    Route::post('/destroy', [PartnerBannerController::class, 'destroy'])->name('partner_banner.destroy');
    Route::get('/up/{id}', [PartnerBannerController::class, 'up'])->name('partner_banner.up');
    Route::get('/down/{id}', [PartnerBannerController::class, 'down'])->name('partner_banner.down');
});

Route::group(['prefix'=>'/admin/car-package', 'middleware' => 'admin'], function(){
    Route::get('/', [CarPackageController::class, 'index'])->name('car_package.index');
    Route::get('/create', [CarPackageController::class, 'create'])->name('car_package.create');
    Route::post('/store', [CarPackageController::class, 'store'])->name('car_package.store');
    Route::get('/edit/{id}', [CarPackageController::class, 'edit'])->name('car_package.edit');
    Route::get('/details/{id}', [CarPackageController::class, 'details'])->name('car_package.details');
    Route::post('/update/{id}', [CarPackageController::class, 'update'])->name('car_package.update');
    Route::post('/destroy', [CarPackageController::class, 'destroy'])->name('car_package.destroy');
});

Route::group(['prefix'=>'/admin/hotel-package', 'middleware' => 'admin'], function(){
    Route::get('/', [HotelPackageController::class, 'index'])->name('hotel_package.index');
    Route::get('/create', [HotelPackageController::class, 'create'])->name('hotel_package.create');
    Route::post('/store', [HotelPackageController::class, 'store'])->name('hotel_package.store');
    Route::get('/edit/{id}', [HotelPackageController::class, 'edit'])->name('hotel_package.edit');
    Route::get('/details/{id}', [HotelPackageController::class, 'details'])->name('hotel_package.details');
    Route::post('/update/{id}', [HotelPackageController::class, 'update'])->name('hotel_package.update');
    Route::post('/destroy', [HotelPackageController::class, 'destroy'])->name('hotel_package.destroy');
});

Route::group(['prefix'=>'/admin/travel-package', 'middleware' => 'admin'], function(){
    Route::get('/', [TravelPackageController::class, 'index'])->name('travel_package.index');
    Route::get('/create', [TravelPackageController::class, 'create'])->name('travel_package.create');
    Route::post('/store', [TravelPackageController::class, 'store'])->name('travel_package.store');
    Route::get('/edit/{id}', [TravelPackageController::class, 'edit'])->name('travel_package.edit');
    Route::get('/details/{id}', [TravelPackageController::class, 'details'])->name('travel_package.details');
    Route::post('/update/{id}', [TravelPackageController::class, 'update'])->name('travel_package.update');
    Route::post('/destroy', [TravelPackageController::class, 'destroy'])->name('travel_package.destroy');
});

Route::group(['prefix'=>'/admin/package-review', 'middleware' => 'admin'], function(){
    Route::get('/', [PackageReviewController::class, 'index'])->name('package_review.index');
});

Route::group(['prefix'=>'/admin/reason/cancellation', 'middleware' => 'admin'], function(){
    Route::get('/', [CancellationReasonController::class, 'index'])->name('reason.index');
    Route::get('/create', [CancellationReasonController::class, 'create'])->name('reason.create');
    Route::post('/store', [CancellationReasonController::class, 'store'])->name('reason.store');
    Route::get('/edit/{id}', [CancellationReasonController::class, 'edit'])->name('reason.edit');
    Route::post('/update/{id}', [CancellationReasonController::class, 'update'])->name('reason.update');
    Route::post('/destroy', [CancellationReasonController::class, 'destroy'])->name('reason.destroy');
});

Route::group(['prefix'=>'/admin/privacy/user', 'middleware' => 'admin'], function(){
    Route::get('/edit', [PrivacyController::class, 'userEedit'])->name('privacy.user.edit');
    Route::post('/update', [PrivacyController::class, 'userUpdate'])->name('privacy.user.update');
});

Route::group(['prefix'=>'/admin/privacy/partner', 'middleware' => 'admin'], function(){
    Route::get('/edit', [PrivacyController::class, 'partnerEdit'])->name('privacy.partner.edit');
    Route::post('/update', [PrivacyController::class, 'partnerUpdate'])->name('privacy.partner.update');
});

Route::group(['prefix'=>'/admin/banner', 'middleware' => 'admin'], function(){
    Route::get('/packages', [BannerController::class, 'bannerPackages'])->name('banner.packages');
    Route::post('/packages/update', [BannerController::class, 'bannerPackagesUpdate'])->name('banner.packages.update');
});

Route::group(['prefix'=>'/admin/notice', 'middleware' => 'admin'], function(){
    Route::get('/packages', [NoticeController::class, 'noticePackages'])->name('notice.packages');
    Route::post('/packages/update', [NoticeController::class, 'noticePackagesUpdate'])->name('notice.packages.update');
    Route::get('/partner-app', [NoticeController::class, 'noticePartnerApp'])->name('notice.partner_app');
    Route::post('/partner-app/update', [NoticeController::class, 'noticePartnerAppUpdate'])->name('notice.partner_app.update');
});

Route::group(['prefix'=>'/admin/ride', 'middleware' => 'admin'], function(){
    Route::get('/bid-expired-ride', [RideController::class, 'bidExpiredRide'])->name('ride.bid_expired_ride');
    Route::get('/pending', [RideController::class, 'pending'])->name('ride.pending');
    Route::get('/approve/{id}', [RideController::class, 'approve'])->name('ride.approve');
    Route::get('/bid-request', [RideController::class, 'bidRequest'])->name('ride.bid_request');
    Route::get('/upcoming', [RideController::class, 'upcoming'])->name('ride.upcoming');
    Route::get('/complete', [RideController::class, 'complete'])->name('ride.complete');
    Route::get('/cancel', [RideController::class, 'cancel'])->name('ride.cancel');
    Route::get('/bidding/{id}', [RideController::class, 'bidding'])->name('ride.bidding');
    Route::get('/details/{ride_id}', [RideController::class, 'details'])->name('ride.details');
    Route::post('/cancel/reason/send', [RideController::class, 'reasonSend'])->name('ride.reason.send');    
    Route::post('/update-visible-time', [RideController::class, 'updateVisibleTime'])->name('ride.update_visible_time');    
    Route::post('/notification/send', [RideController::class, 'notificationSend'])->name('ride.notification_send');    
    Route::post('/update-bid-amount', [RideController::class, 'updateBidAmount'])->name('ride.update_bid_amount');    
    Route::post('/bid-cancel', [RideController::class, 'bidCancel'])->name('ride.bid_cancel');    
});

Route::group(['prefix'=>'/admin/car-package-order', 'middleware' => 'admin'], function(){
    Route::get('/booking', [CarPackageRideController::class, 'booking'])->name('car_package_order.booking');
    Route::get('/upcoming', [CarPackageRideController::class, 'upcoming'])->name('car_package_order.upcoming');
    Route::get('/ongoing', [CarPackageRideController::class, 'ongoing'])->name('car_package_order.ongoing');
    Route::get('/complete', [CarPackageRideController::class, 'complete'])->name('car_package_order.complete');
    Route::get('/cancel', [CarPackageRideController::class, 'cancel'])->name('car_package_order.cancel');
    Route::get('/details/{id}', [CarPackageRideController::class, 'details'])->name('car_package_order.details');
    Route::post('/cancel/reason/send', [CarPackageRideController::class, 'reasonSend'])->name('car_package_order.reason.send');
});

Route::group(['prefix'=>'/admin/hotel-package-order', 'middleware' => 'admin'], function(){
    Route::get('/booking', [HotelPackageRideController::class, 'booking'])->name('hotel_package_order.booking');
    Route::get('/upcoming', [HotelPackageRideController::class, 'upcoming'])->name('hotel_package_order.upcoming');
    Route::get('/complete', [HotelPackageRideController::class, 'complete'])->name('hotel_package_order.complete');
    Route::get('/cancel', [HotelPackageRideController::class, 'cancel'])->name('hotel_package_order.cancel');
    Route::get('/details/{id}', [HotelPackageRideController::class, 'details'])->name('hotel_package_order.details');
    Route::post('/cancel/reason/send', [HotelPackageRideController::class, 'reasonSend'])->name('hotel_package_order.reason.send');
});

Route::group(['prefix'=>'/admin/sms-notification', 'middleware' => 'admin'], function(){
    Route::get('/', [SmsNotificationController::class, 'index'])->name('sms_notification.index');
    Route::post('/send', [SmsNotificationController::class, 'send'])->name('sms_notification.send');
    Route::get('/push-notification', [SmsNotificationController::class, 'pushNotification'])->name('sms_notification.push_notification');
    Route::post('/push-notification-send', [SmsNotificationController::class, 'pushNotificationSend'])->name('sms_notification.push_notification.send');
    Route::get('/global-notification', [SmsNotificationController::class, 'globalNotification'])->name('sms_notification.global_notification');
    Route::post('/global-notification-send', [SmsNotificationController::class, 'globalNotificationSend'])->name('sms_notification.global_notification.send');
});

Route::group(['prefix'=>'/admin/message', 'middleware' => 'admin'], function(){
    Route::get('/partner', [MessageController::class, 'partnerMessage'])->name('message.partner');
    Route::get('/user', [MessageController::class, 'userMessage'])->name('message.user');
    Route::post('/reply', [MessageController::class, 'reply'])->name('message.reply');
});

Route::group(['prefix'=>'/admin/complain', 'middleware' => 'admin'], function(){
    Route::get('/partner', [ComplainController::class, 'partnerComplain'])->name('complain.partner');
    Route::get('/user', [ComplainController::class, 'userComplain'])->name('complain.user');
    Route::post('/reply', [ComplainController::class, 'reply'])->name('complain.reply');
});

Route::group(['prefix'=>'/admin/withdraw', 'middleware' => 'admin'], function(){
    Route::get('/pending', [WithdrawController::class, 'pending'])->name('withdraw.pending');
    Route::get('/complete', [WithdrawController::class, 'complete'])->name('withdraw.complete');
    Route::get('/cancel', [WithdrawController::class, 'cancel'])->name('withdraw.cancel');
    Route::post('/approve', [WithdrawController::class, 'approve'])->name('withdraw.approve');
});

Route::group(['prefix'=>'/admin/accounts', 'middleware' => 'admin'], function(){
    Route::get('/summary', [AccountsController::class, 'summary'])->name('accounts.summary');
    Route::get('/transaction', [AccountsController::class, 'transaction'])->name('accounts.transaction');
    Route::get('/refund', [AccountsController::class, 'refund'])->name('accounts.refund');
    Route::get('/user-balance', [AccountsController::class, 'userBalance'])->name('accounts.user-balance');
    Route::get('/partner-balance', [AccountsController::class, 'partnerBalance'])->name('accounts.partner-balance');
    Route::get('/withdraw', [AccountsController::class, 'withdraw'])->name('accounts.withdraw');
    Route::post('/withdraw-cancel', [AccountsController::class, 'withdrawCancel'])->name('accounts.withdraw.cancel');
    Route::post('/withdraw-accept', [AccountsController::class, 'withdrawAccept'])->name('accounts.withdraw.accept');
});
