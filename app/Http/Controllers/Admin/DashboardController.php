<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarPackage;
use App\Models\Driver;
use App\Models\HotelPackage;
use App\Models\Owner;
use App\Models\RideBiting;
use App\Models\RideList;
use App\Models\TravelPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * show dashboard
     */
    public function dashboard ()
    {
        $three_days_ago     = date_format(date_create('3 days ago'), 'Y-m-d'); 
        $seven_days_ago     = date_format(date_create('7 days ago'), 'Y-m-d');
        $thirty_days_ago    = date_format(date_create('30 days ago'), 'Y-m-d');
		$today              = date('Y-m-d');
		$current_date_time  = Carbon::now()->toDateTimeString();

        // user summary
    	$data['total_user'] = User::count('id');
    	$data['total_user_active'] = User::where('account_status', 1)->count('id');
    	$data['total_user_inactive'] = User::where('account_status', 0)->count('id');

        // partner summary
    	$data['total_partner'] = Owner::count('id');
    	$data['total_partner_active'] = Owner::where('account_status', 1)->count('id');
    	$data['total_partner_inactive'] = Owner::where('account_status', 0)->count('id');
    	$data['total_partner_hold'] = Owner::where('account_status', 2)->count('id');

        // driver summary
    	$data['total_driver'] = Driver::count('id');
    	$data['total_driver_active'] = Driver::where('c_status', 1)->count('id');
    	$data['total_driver_inactive'] = Driver::where('c_status', 0)->count('id');

        // car summary
    	$data['total_car'] = Car::count('id');
    	$data['total_car_active'] = Car::where('status', 1)->count('id');
    	$data['total_car_pending'] = Car::where('status', 0)->count('id');
		$data['total_car_expired'] = Car::where(function($query) use ($today) {
											return $query   ->where('tax_expired_date', '<', $today)
															->orWhere('fitness_expired_date', '<', $today)
															->orWhere('registration_expired_date', '<', $today)
															->orWhere('insurance_expired_date', '<', $today);
										}) 
										->where('fitness_expired_date','!=','null')
										->where('fitness_expired_date','!=','null')
										->where('registration_expired_date','!=','null')
										->count('id');
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

		//ride summary
		$data['total_bid_request'] = RideList::where('status', 1)
		                                    ->where('ride_visiable_time', '>', $current_date_time)
		                                    ->count('id');
        $data['total_upcoming_ride'] = RideList::where('status', 4)
                                                ->where('start_time', '>', $current_date_time)
                                                ->count('id');
		$data['total_complete_ride'] = RideList::where('status', 4)
                                                ->where('start_time', '<', $current_date_time)
                                                ->count('id');	
		$data['total_cancelled_ride'] = RideList::where('status', 2)->count('id');
		
		$data['user_msg_read']   = DB::table('owner_message_list')->where('type', 1)->where('status', 1)->count('id');
		$data['user_msg_unread'] = DB::table('owner_message_list')->where('type', 1)->where('status', 0)->count('id');
		$data['partner_msg_read']   = DB::table('owner_message_list')->where('type', 0)->where('status', 1)->count('id');
		$data['partner_msg_unread'] = DB::table('owner_message_list')->where('type', 0)->where('status', 0)->count('id');
		
		$data['user_complain_read']   = DB::table('report_list')->where('senderType', 1)->where('status', 1)->count('id');
		$data['user_complain_unread'] = DB::table('report_list')->where('senderType', 1)->where('status', 0)->count('id');
		$data['partner_complain_read']   = DB::table('report_list')->where('senderType', 0)->where('status', 1)->count('id');
		$data['partner_complain_unread'] = DB::table('report_list')->where('senderType', 0)->where('status', 0)->count('id');
		
		$today_debit  = DB::table('user_account')->where('type', 0)->whereDate('created_at', $today)->sum('amount');
        $today_credit = DB::table('user_account')->where('type', 1)->whereDate('created_at', $today)->sum('amount');
        dd($today_debit, $today_credit);
		$three_days_debit  = DB::table('user_account')->where('type', 0)->whereDate('created_at', '>=', $three_days_ago)->sum('amount');
        $three_days_credit = DB::table('user_account')->where('type', 1)->whereDate('created_at', '<=', $today)->sum('amount');
        
		$seven_days_debit  = DB::table('user_account')->where('type', 0)->whereDate('created_at', '>=', $seven_days_ago)->sum('amount');
        $seven_days_credit = DB::table('user_account')->where('type', 1)->whereDate('created_at', '<=', $today)->sum('amount');
        
		$thirty_days_debit  = DB::table('user_account')->where('type', 0)->whereDate('created_at', '>=', $thirty_days_ago)->sum('amount');
        $thirty_days_credit = DB::table('user_account')->where('type', 1)->whereDate('created_at', '<=', $today)->sum('amount');
        
        $data['today_income']           = $today_debit - $today_credit;
        $data['last_three_days_income'] = $three_days_debit - $three_days_credit;
        $data['last_seven_days_income'] = $seven_days_debit - $seven_days_credit;
        $data['last_thirty_days_income']= $thirty_days_debit - $thirty_days_credit;

        return view('quicarbd.admin.dashboard.index', $data);
    }
}
