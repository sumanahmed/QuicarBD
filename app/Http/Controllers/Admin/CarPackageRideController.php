<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\CarPackageOrder;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Response;
use DB;
use Exception;

class CarPackageRideController extends Controller
{
    /**
     * car package booking show
    */
    public function booking(Request $request) 
    {
        $query  = DB::table('car_package_order')
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
                    ->where('car_package_order.status', 0)
                    ->where('car_package_order.payment_status', 0);
                    
        if ($request->phone) { 
          $query = $query->where('users.phone', $request->phone);
        }  
        
        if ($request->booking_date) {
          $query = $query->whereDate('car_package_order.created_at', date('Y-m-d', strtotime($request->booking_date)));
        }
        
        if ($request->travel_date) {
          $query = $query->whereDate('car_package_order.travel_date', date('Y-m-d', strtotime($request->travel_date)));
        }
        
        $bookings = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.package-ride.car-package.booking', compact('bookings'));
    }    
    
    /**
     * car package accepted
    */
    public function accepted(Request $request) 
    {
        $query  = DB::table('car_package_order')
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
                    ->where('car_package_order.status', 1)
                    ->where('car_package_order.payment_status', 0);
                    
        if ($request->phone) { 
          $query = $query->where('users.phone', $request->phone);
        }  
        
        if ($request->booking_date) {
          $query = $query->whereDate('car_package_order.created_at', date('Y-m-d', strtotime($request->booking_date)));
        }
        
        if ($request->travel_date) {
          $query = $query->whereDate('car_package_order.travel_date', date('Y-m-d', strtotime($request->travel_date)));
        }
        
        $orders = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.package-ride.car-package.accepted', compact('orders'));
    }

    /**
     * car package booking show
    */
    public function upcoming(Request $request) 
    {
        $current_date_time = Carbon::now()->toDateTimeString(); 
        $query = DB::table('car_package_order')
                    ->join('car_packages','car_package_order.package_id','car_packages.id')
                    ->join('users','car_package_order.user_id','users.id')
                    ->join('owners','car_package_order.owner_id','owners.id')
                    ->join('cars','car_package_order.car_id','cars.id')
                    ->select('car_package_order.created_at','car_package_order.user_id','car_package_order.owner_id',
                        'car_package_order.package_id','car_package_order.travel_date', 'car_package_order.status','car_package_order.payment_status',
                        'car_package_order.id', 'car_package_order.booking_id','car_package_order.ride_start_time',
                        'car_packages.name', 'car_packages.price', 'cars.carRegisterNumber','car_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('car_package_order.status', 1)
                    ->where('car_package_order.payment_status', 1)
                    ->where('car_package_order.ride_start_time', '>', $current_date_time);
                    
        if ($request->phone) { 
          $query = $query->where('users.phone', $request->phone);
        }  
        
        if ($request->booking_date) {
          $query = $query->whereDate('car_package_order.created_at', date('Y-m-d', strtotime($request->booking_date)));
        }
        
        if ($request->travel_date) {
          $query = $query->whereDate('car_package_order.travel_date', date('Y-m-d', strtotime($request->travel_date)));
        }
                    
        $orders = $query->paginate(12)->appends(request()->query());

        return view('quicarbd.admin.package-ride.car-package.upcoming', compact('orders'));
    }

    /**
     * car package ongoing show
    */
    public function ongoing() {
        $orders = DB::table('car_package_order')
                    ->join('car_packages','car_package_order.package_id','car_packages.id')
                    ->join('users','car_package_order.user_id','users.id')
                    ->join('owners','car_package_order.owner_id','owners.id')
                    ->join('cars','car_package_order.car_id','cars.id')
                    ->select('car_package_order.created_at','car_package_order.user_id','car_package_order.owner_id',
                        'car_package_order.package_id','car_package_order.travel_date', 'car_package_order.status','car_package_order.payment_status',
                        'car_package_order.id', 'car_package_order.booking_id',
                        'car_packages.name', 'car_packages.price', 'cars.carRegisterNumber','car_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('car_package_order.status', 3)
                    ->get();

        return view('quicarbd.admin.package-ride.car-package.ongoing', compact('orders'));
    }

    /**
     * car package complete show
    */
    public function complete(Request $request) 
    {
        $current_date_time = Carbon::now()->toDateTimeString(); 
        
        $query = DB::table('car_package_order')
                    ->join('car_packages','car_package_order.package_id','car_packages.id')
                    ->join('users','car_package_order.user_id','users.id')
                    ->join('owners','car_package_order.owner_id','owners.id')
                    ->join('cars','car_package_order.car_id','cars.id')
                    ->select('car_package_order.created_at','car_package_order.user_id','car_package_order.owner_id',
                        'car_package_order.package_id','car_package_order.travel_date', 'car_package_order.status','car_package_order.payment_status',
                        'car_package_order.id', 'car_package_order.booking_id','car_package_order.review_give', 'car_package_order.ride_start_time',
                        'car_packages.name', 'car_packages.price', 'cars.carRegisterNumber','car_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('car_package_order.ride_start_time', '>', $current_date_time);
                    
        if ($request->phone) { 
          $query = $query->where('users.phone', $request->phone);
        }  
        
        if ($request->booking_date) {
          $query = $query->whereDate('car_package_order.created_at', date('Y-m-d', strtotime($request->booking_date)));
        }
        
        if ($request->travel_date) {
          $query = $query->whereDate('car_package_order.travel_date', date('Y-m-d', strtotime($request->travel_date)));
        }
                    
        $orders = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.package-ride.car-package.complete', compact('orders'));
    }

    /**
     * car package cancel show
    */
    public function cancel(Request $request) 
    {
        $query = DB::table('car_package_order')
                    ->join('car_packages','car_package_order.package_id','car_packages.id')
                    ->join('users','car_package_order.user_id','users.id')
                    ->join('owners','car_package_order.owner_id','owners.id')
                    ->join('cars','car_package_order.car_id','cars.id')
                    ->select('car_package_order.created_at','car_package_order.user_id','car_package_order.owner_id',
                        'car_package_order.package_id','car_package_order.travel_date', 'car_package_order.status','car_package_order.payment_status',
                        'car_package_order.id', 'car_package_order.booking_id','car_package_order.cancel_by','car_package_order.cancellation_reason',
                        'car_packages.name', 'car_packages.price', 'cars.carRegisterNumber','car_packages.quicar_charge',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('car_package_order.status', 2);
                    
        if ($request->phone) { 
          $query = $query->where('users.phone', $request->phone);
        }  
        
        if ($request->booking_date) {
          $query = $query->whereDate('car_package_order.created_at', date('Y-m-d', strtotime($request->booking_date)));
        }
        
        if ($request->travel_date) {
          $query = $query->whereDate('car_package_order.travel_date', date('Y-m-d', strtotime($request->travel_date)));
        }
                    
        $orders = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.package-ride.car-package.cancel', compact('orders'));
    }

    /**
     * car package order details
    */
    public function details($id) 
    {
        $detail = DB::table('car_package_order')
                    ->join('car_packages','car_package_order.package_id','car_packages.id')
                    ->join('users','car_package_order.user_id','users.id')
                    ->join('owners','car_package_order.owner_id','owners.id')
                    ->join('cars','car_package_order.car_id','cars.id')
                    ->select('car_package_order.*','car_packages.name','car_packages.price', 'cars.carRegisterNumber',
                        'users.name as user_name', 'users.phone as user_phone',
                        'owners.name as owner_name', 'owners.phone as owner_phone'
                    )
                    ->where('car_package_order.id', $id)
                    ->first();
                    
        $transactions = DB::table('user_account')
                            ->leftjoin('users','user_account.user_id','users.id')
                            ->select('user_account.*','users.phone')
                            ->where('user_account.income_from', 2)
                            ->where('user_account.history_id', $id)
                            ->get();
        
        return view('quicarbd.admin.package-ride.car-package.details', compact('detail','transactions'));
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
            
            $car_package_order = CarPackageOrder::where('id', $request->package_order_id)->first();
            
            $partner = Owner::find($car_package_order->owner_id);
            $user    = User::find($car_package_order->user_id);
            
            $car_package_order->status = 2;
            $car_package_order->update();
            
            $title  = 'Package Cancel';
            $msg    = $request->reason.'. Thanks for connecting with Quicar'; 
            $helper = new Helper(); 
            
            if(isset($parnter)) {
                $helper->sendSinglePartnerNotification($partner->n_key, $title, $msg); //push notification send to driver
                $helper->smsNotification($type=2, $car_package_order->owner_id, $title, $msg); // send notification, 2=partner
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
