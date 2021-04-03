<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Lib\Helper;
use App\Models\City;
use App\Models\District;
use App\Models\HotelPackage;
use Validator;
use Response;
use DB;
use Exception;
use App\Models\HotelPackageOrder;
use App\Models\Owner;
use App\Models\PropertyType;
use App\Models\User;

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
                        'hotel_package_order.package_id','hotel_package_order.check_in', 'hotel_package_order.check_out',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.booking_id',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id','hotel_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone','hotel_packages.id as hotel_package_id'
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
                        'hotel_package_order.package_id','hotel_package_order.check_in', 'hotel_package_order.check_out',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.booking_id',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id','hotel_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone','hotel_packages.id as hotel_package_id'
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
                        'hotel_package_order.package_id','hotel_package_order.check_in', 'hotel_package_order.check_out',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.booking_id',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id','hotel_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone','hotel_packages.id as hotel_package_id'
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
                        'hotel_package_order.package_id','hotel_package_order.check_in', 'hotel_package_order.check_out',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.review_give','hotel_package_order.booking_id',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id','hotel_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone','hotel_packages.id as hotel_package_id'
                    )
                    ->where('hotel_package_order.status', 3)
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
                        'hotel_package_order.package_id','hotel_package_order.check_in', 'hotel_package_order.check_out',
                        'hotel_package_order.status','hotel_package_order.payment_status','hotel_package_order.review_give',
                        'hotel_packages.hotel_name', 'hotel_packages.price', 'hotel_package_order.id','hotel_package_order.cancel_by',
                        'hotel_package_order.cancellation_reason','hotel_package_order.booking_id',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone','hotel_packages.id as hotel_package_id'
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
                ->leftjoin('hotel_packages','hotel_package_order.package_id','hotel_packages.id')
                ->where('hotel_package_order.id', $id)
                ->first(); 
        $district   = District::find($detail->district_id)->value;
        $city       = City::find($detail->city_id)->name;
        $owner      = Owner::find($detail->owner_id)->name;
        $property_type = PropertyType::find($detail->propertyType)->name;
        $charge    = Owner::find($detail->owner_id)->hotel_package_charge;
        return view('quicarbd.admin.package-ride.hotel-package.details', compact('detail','district','city','owner','property_type','charge'));
    }

    /**
    * package ride cancel reason send
    */
    public function reasonSend (Request $request) {
      
        $validators = Validator::make($request->all(),[
            'package_order_id' => 'required',
            'reason'  => 'required'
        ]);
        
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }
        
        DB::beginTransaction();
        
        try {
            
            $hotel_package_order = HotelPackageOrder::find($request->package_order_id);
            
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
