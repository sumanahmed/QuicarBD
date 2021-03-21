<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarPackage;
use App\Models\Driver;
use App\Models\HotelPackage;
use App\Models\Owner;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * show dashboard
     */
    public function dashboard ()
    {
        // user summary
    	$data['total_user'] = User::count('id');
    	$data['total_user_active'] = User::where('account_status', 1)->count('id');
    	$data['total_user_inactive'] = User::where('account_status', 0)->count('id');

        // partner summary
    	$data['total_partner'] = Owner::count('id');
    	$data['total_partner_active'] = Owner::where('account_status', 1)->count('id');
    	$data['total_partner_inactive'] = Owner::where('account_status', 0)->count('id');

        // driver summary
    	$data['total_driver'] = Driver::count('id');
    	$data['total_driver_active'] = Driver::where('c_status', 1)->count('id');
    	$data['total_driver_inactive'] = Driver::where('c_status', 0)->count('id');

        // car summary
    	$data['total_car'] = Car::count('id');
    	$data['total_car_active'] = Car::where('status', 1)->count('id');
    	$data['total_car_pending'] = Car::where('status', 0)->count('id');
    	$data['total_car_unverify'] = Car::where('verify', 0)->count('id');

        // car package summary
    	$data['car_package'] = CarPackage::count('id');
    	$data['car_package_active'] = CarPackage::where('status', 1)->count('id');
    	$data['car_package_pending'] = CarPackage::where('status', 0)->count('id');
    	$data['car_package_unverify'] = CarPackage::where('package_status', 0)->count('id');

        // hotel package summary
    	$data['hotel_package'] = HotelPackage::count('id');
    	$data['hotel_package_active'] = HotelPackage::where('status', 1)->count('id');
    	$data['hotel_package_pending'] = HotelPackage::where('status', 0)->count('id');
    	$data['hotel_package_unverify'] = HotelPackage::where('package_status', 0)->count('id');

        // travel package summary
    	$data['travel_package'] = TravelPackage::count('id');
    	$data['travel_package_active'] = TravelPackage::where('status', 1)->count('id');
    	$data['travel_package_pending'] = TravelPackage::where('status', 0)->count('id');

        return view('quicarbd.admin.dashboard.index', $data);
    }
}
