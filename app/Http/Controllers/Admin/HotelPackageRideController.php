<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use DB;
use Exception;

class HotelPackageRideController extends Controller
{
    /**
     * car package booking show
    */
    public function booking() {
        $bookings = DB::table('hotel_package_order')
                    ->join('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                    ->join('users','hotel_package_order.user_id','users.id')
                    ->select('hotel_package_order.created_at','hotel_package_order.user_id','hotel_package_order.owner_id',
                        'hotel_package_order.package_id','hotel_packages.hotel_check_in_time', 'hotel_packages.hotel_check_out_time',
                        'hotel_package_order.status','hotel_package_order.payment_status',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id',
                        'users.name as user_name','users.phone as user_phone'
                    )
                    ->where('hotel_package_order.status', '<=', 1)
                    ->where('hotel_package_order.payment_status', 0)
                    ->get();

        return view('quicarbd.admin.package-ride.hotel-package.booking', compact('bookings'));
    }

    /**
     * car package booking show
    */
    public function upcoming() {
        $orders = DB::table('hotel_package_order')
                    ->join('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                    ->join('users','hotel_package_order.user_id','users.id')
                    ->select('hotel_package_order.created_at','hotel_package_order.user_id','hotel_package_order.owner_id',
                        'hotel_package_order.package_id','hotel_packages.hotel_check_in_time', 'hotel_packages.hotel_check_out_time',
                        'hotel_package_order.status','hotel_package_order.payment_status',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id',
                        'users.name as user_name','users.phone as user_phone'
                    )
                    ->where('hotel_package_order.status', 1)
                    ->where('hotel_package_order.payment_status', 1)
                    ->get();

        return view('quicarbd.admin.package-ride.hotel-package.upcoming', compact('orders'));
    }

    /**
     * car package ongoing show
    */
    public function ongoing() {
        $orders = DB::table('hotel_package_order')
                    ->join('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                    ->join('users','hotel_package_order.user_id','users.id')
                    ->select('hotel_package_order.created_at','hotel_package_order.user_id','hotel_package_order.owner_id',
                        'hotel_package_order.package_id','hotel_packages.hotel_check_in_time', 'hotel_packages.hotel_check_out_time',
                        'hotel_package_order.status','hotel_package_order.payment_status',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id',
                        'users.name as user_name','users.phone as user_phone'
                    )
                    ->where('hotel_package_order.status', 3)
                    ->get();

        return view('quicarbd.admin.package-ride.hotel-package.ongoing', compact('orders'));
    }

    /**
     * car package complete show
    */
    public function complete() { 
        $orders = DB::table('hotel_package_order')
                    ->join('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                    ->join('users','hotel_package_order.user_id','users.id')
                    ->select('hotel_package_order.created_at','hotel_package_order.user_id','hotel_package_order.owner_id',
                        'hotel_package_order.package_id','hotel_packages.hotel_check_in_time', 'hotel_packages.hotel_check_out_time',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.review',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id',
                        'users.name as user_name','users.phone as user_phone'
                    )
                    ->where('hotel_package_order.status', 4)
                    ->get();

        return view('quicarbd.admin.package-ride.hotel-package.complete', compact('orders'));
    }

    /**
     * car package cancel show
    */
    public function cancel() { 
        $orders = DB::table('hotel_package_order')
                    ->join('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                    ->join('users','hotel_package_order.user_id','users.id')
                    ->join('owners','hotel_package_order.owner_id','owners.id')
                    ->select('hotel_package_order.created_at','hotel_package_order.user_id','hotel_package_order.owner_id',
                        'hotel_package_order.package_id','hotel_packages.hotel_check_in_time', 'hotel_packages.hotel_check_out_time',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.review',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id','hotel_package_order.cancel_by',
                        'hotel_package_order.cancellation_reason',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('hotel_package_order.status', 2)
                    ->get();

        return view('quicarbd.admin.package-ride.hotel-package.cancel', compact('orders'));
    }

    /**
     * car package order details
    */
    public function details($id) {
        $detail = DB::table('hotel_package_order')
                    ->join('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                    ->join('cars','hotel_package_order.car_id','cars.id')
                    ->select('hotel_package_order.*','hotel_packages.name','hotel_packages.price', 'cars.carRegisterNumber')
                    ->where('hotel_package_order.id', $id)
                    ->first();

        return view('quicarbd.admin.package-ride.hotel-package.details', compact('detail'));
    }

    /**
    * package ride cancel reason send
    */
    public function reasonSend (Request $request) {
      
        $validators = Validator::make($request->all(),[
            'ride_id' => 'required',
            'reason'  => 'required'
        ]);
        
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }
        
        DB::beginTransaction();
        
        try {
            
            $hotel_package_order = CarPackageOrder::where('id', $request->package_order_id)->first();
            
            $partner = Owner::find($hotel_package_order->owner_id);
            $user    = User::find($hotel_package_order->user_id);
            
            $hotel_package_order->status = 2;
            $hotel_package_order->update();
            
            $title  = 'Package Cancel';
            $msg    = $request->reason.'. Thanks for connecting with Quicar'; 
            $helper = new Helper(); 
            
            if(isset($parnter)) {
                $helper->sendSinglePartnerNotification($partner->n_key, $title, $msg); //push notification send to driver
                $helper->smsNotification($type=2, $hotel_package_order->owner_id, $title, $msg); // send notification, 2=partner
            }
            
            if (isset($user)) {
                $helper->sendSinglePartnerNotification($user->n_key, $title, $msg); //push notification send to user
                $helper->smsNotification($type=1, $user->id, $title, $msg); // send notification, 1=user
            }
        
            DB::commit();
            
        } catch (Exception $ex) {
            
            DB::rollback();
            
            $ex->getMessage();
        }
    
    }
}
