<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CarPackageRideController extends Controller
{
    /**
     * car package booking show
    */
    public function booking() {
        $bookings = DB::table('car_package_order')
                    ->join('car_packages','car_package_order.package_id','car_packages.id')
                    ->join('users','car_package_order.user_id','users.id')
                    ->join('owners','car_package_order.owner_id','owners.id')
                    ->join('cars','car_package_order.car_id','cars.id')
                    ->select('car_package_order.created_at','car_package_order.user_id','car_package_order.owner_id',
                        'car_package_order.package_id','car_package_order.travel_date', 'car_package_order.status','car_package_order.payment_status',
                        'car_packages.name', 'car_packages.price', 'cars.carRegisterNumber', 'car_package_order.id',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('car_package_order.status', '<=', 1)
                    ->get();

        return view('quicarbd.admin.package-ride.car-package.booking', compact('bookings'));
    }
}
