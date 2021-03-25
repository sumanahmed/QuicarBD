<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\BidCancelList;
use App\Models\Owner;
use App\Models\User;
use App\Models\RideBiting;
use App\Models\RideList;
use Illuminate\Http\Request;
use Validator;
use Response;

use DB;

class RideController extends Controller
{
  /**
    * show bid request
  */
  public function bidRequest(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.created_at',
                        'ride_list.starting_district','ride_list.starting_city','ride_list.startig_area', 
                        'ride_list.destination_district','ride_list.destination_city','ride_list.destination_area',
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'users.name as user_name','users.phone as user_phone'
                )
                ->where('ride_list.status', 1)
                ->where('ride_list.payment_status', 0)
                ->orderBy('ride_list.id','DESC')
                ->get();
    $reasons = BidCancelList::where('type',0)->where('app_type', 0)->get();
    return view('quicarbd.admin.ride.bid_request', compact('rides','reasons'));
  }
  /**
    * show upcoming bid rides
  */
  public function upcoming(){
    $rides = DB::table('ride_list')
            ->join('users','ride_list.user_id','users.id')
            ->join('ride_biting','ride_list.id','ride_biting.ride_id')
            ->leftjoin('owners','ride_biting.owner_id','owners.id')
            ->leftjoin('drivers','ride_biting.driver_id','drivers.id')
            ->select('ride_list.id','ride_list.created_at',                    
                    'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                    'users.name as user_name','users.phone as user_phone',
                    'owners.name as owner_name','owners.phone as owner_phone',
                    'drivers.name as driver_name','drivers.phone as driver_phone',
                    'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id'
            )
            ->where('ride_list.status', 4)
            ->where('ride_list.payment_status', 1)
            ->where('ride_list.accepted_ride_bitting_id', '!=', null)
            ->orderBy('ride_list.id','DESC')
            ->get();               
    $reasons = BidCancelList::where('type',0)->where('app_type', 0)->get();  
    return view('quicarbd.admin.ride.upcoming', compact('rides','reasons'));
  }

  /**
    * show ongoing rides
  */
  public function ongoing(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->join('ride_biting','ride_list.id','ride_biting.ride_id')
                ->leftjoin('owners','ride_biting.owner_id','owners.id')
                ->leftjoin('drivers','ride_biting.driver_id','owners.id')
                ->select('ride_list.id','ride_list.created_at',                    
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone',
                        'drivers.name as driver_name','drivers.phone as driver_phone',
                        'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id'
                )
                ->where('ride_list.status', 3)
                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                ->orderBy('ride_list.id','DESC')
                ->get();                        
    $reasons = BidCancelList::where('type',0)->where('app_type', 0)->get();  
    return view('quicarbd.admin.ride.ongoing', compact('rides','reasons'));
  }

  /**
    * show complete rides
  */
  public function complete(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->join('ride_biting','ride_list.id','ride_biting.ride_id')
                ->leftjoin('owners','ride_biting.owner_id','owners.id')
                ->leftjoin('drivers','ride_biting.driver_id','owners.id')
                ->select('ride_list.id','ride_list.created_at', 'ride_list.review_give'                   ,
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone',
                        'drivers.name as driver_name','drivers.phone as driver_phone',
                        'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id'
                )
                ->where('ride_list.status', 5)
                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                ->orderBy('ride_list.id','DESC')
                ->get();                     
    return view('quicarbd.admin.ride.complete', compact('rides'));
  }

  /**
    * show cancel rides
  */
  public function cancel(){
    $rides = DB::table('ride_list')
                  ->join('users','ride_list.user_id','users.id')
                  ->leftjoin('ride_biting','ride_list.id','ride_biting.ride_id')
                  ->leftjoin('owners','ride_biting.owner_id','owners.id')
                  ->select('ride_list.id','ride_list.created_at', 'ride_list.cancel_by',
                          'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                          'users.name as user_name','users.phone as user_phone',
                          'owners.name as owner_name','owners.phone as owner_phone',
                          'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id'
                  )
                ->where('ride_list.status', 2)
                ->orderBy('ride_list.id','DESC')
                ->get();             
    return view('quicarbd.admin.ride.cancel', compact('rides'));
  }

  /**
    * show upcoming bid rides
  */
  public function bidding($id){
      $biddings = DB::table('ride_biting')
                  ->leftjoin('cars','ride_biting.car_id','cars.id')
                  ->leftjoin('owners','ride_biting.owner_id','owners.id')
                  ->leftjoin('drivers','ride_biting.driver_id','drivers.id')
                  ->select('drivers.name as driver_name','drivers.phone as driver_phone',
                          'owners.name as owner_name','owners.phone as owner_phone',
                          'ride_biting.*','cars.carRegisterNumber')
                  ->where('ride_biting.ride_id', $id)
                  ->orderBy('ride_biting.id','DESC')
                  ->get();
                                
      return view('quicarbd.admin.ride.bidding', compact('biddings'));
  }

  /**
    * show ride details
  */
  public function details($ride_id){
    $ride = RideList::find($ride_id);                      
    return view('quicarbd.admin.ride.details', compact('ride'));
  }

  /**
   * ride cancel reason send
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
        
        $bid = RideBiting::where('ride_id', $request->ride_id)->first();
        
        if ($bid != null) {
            $partner = Owner::find($bid->owner_id);
            $user    = User::find($bid->user_id);
            
            $bid->status = 2;
            $bid->update();
        
        } else {
            $user_id = RideList::find($request->ride_id)->user_id;
            $user    = User::find($user_id);   
        }
    
        $ride = RideList::find($request->ride_id);
        $ride->status = 2;
        $ride->update();
        
        $title  = 'Ride Cancel';
        $msg    = $request->reason.'. Thanks for connecting with Quicar'; 
        $helper = new Helper(); 
        
        if(isset($parnter)) {
            $helper->sendSinglePartnerNotification($partner->n_key, $title, $msg); //push notification send to driver
            $helper->smsNotification($type=2, $bid->owner_id, $title, $msg); // send notification, 2=partner
        }
        
        if (isset($user)) {
            $helper->sendSinglePartnerNotification($user->n_key, $title, $msg); //push notification send to user
            $helper->smsNotification($type=1, $user->id, $title, $msg); // send notification, 1=user
        }
        
    } catch (Exception $ex) {
        
        DB::rollback();
        
        $ex->getMessage();
    }
    
    DB::commit();
    
  }
}
