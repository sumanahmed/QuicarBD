<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\BidCancelList;
use App\Models\Owner;
use App\Models\User;
use App\Models\RideBiting;
use App\Models\RideList;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Validator;
use Response;

use DB;

class RideController extends Controller
{
  /**
    * show bid request
  */
  public function bidRequest(Request $request){
    $query = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.created_at',
                        'ride_list.starting_district','ride_list.starting_city','ride_list.startig_area', 
                        'ride_list.destination_district','ride_list.destination_city','ride_list.destination_area',
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'users.name as user_name','users.phone as user_phone'
                )
                ->where('ride_list.status', 1)
                ->where('ride_list.payment_status', 0)
                ->orderBy('ride_list.id','DESC');
                
    if ($request->phone) { 
      $query = $query->where('users.phone', $request->phone);
    }  
    
    if ($request->booking_date) {
      $query = $query->whereDate('ride_list.created_at', date('Y-m-d', strtotime($request->booking_date)));
    }
    
    if ($request->travel_date) {
      $query = $query->whereDate('ride_list.start_time', date('Y-m-d', strtotime($request->travel_date)));
    }
                
    $rides = $query->paginate(12);
    
    $reasons = BidCancelList::where('type',0)->where('app_type', 0)->get();
    return view('quicarbd.admin.ride.bid_request', compact('rides','reasons'));
  }
  /**
    * show upcoming bid rides
  */
  public function upcoming(Request $request){
    $query = DB::table('ride_list')
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
            ->where('ride_list.status', 4) //4 mean bit accept
            ->where('ride_biting.status', 1) // 1 mean bit accept
            ->where('ride_list.payment_status', 1)
            ->where('ride_list.accepted_ride_bitting_id', '!=', null)
            ->orderBy('ride_list.id','DESC');
                
    if ($request->phone) { 
      $query = $query->where('users.phone', $request->phone);
    }  
    
    if ($request->booking_date) {
      $query = $query->whereDate('ride_list.created_at', date('Y-m-d', strtotime($request->booking_date)));
    }
    
    if ($request->travel_date) {
      $query = $query->whereDate('ride_list.start_time', date('Y-m-d', strtotime($request->travel_date)));
    }
                
    $rides = $query->paginate(12);  

    $reasons = BidCancelList::where('type',0)->where('app_type', 0)->get();  
    return view('quicarbd.admin.ride.upcoming', compact('rides','reasons'));
  }

  /**
    * show ongoing rides
  */
  public function ongoing(Request $request){
    $query = DB::table('ride_list')
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
                ->orderBy('ride_list.id','DESC');
                
    if ($request->phone) { 
      $query = $query->where('users.phone', $request->phone);
    }  
    
    if ($request->booking_date) {
      $query = $query->whereDate('ride_list.created_at', date('Y-m-d', strtotime($request->booking_date)));
    }
    
    if ($request->travel_date) {
      $query = $query->whereDate('ride_list.start_time', date('Y-m-d', strtotime($request->travel_date)));
    }
                
    $rides = $query->paginate(12);

    $reasons = BidCancelList::where('type',0)->where('app_type', 0)->get();  
    return view('quicarbd.admin.ride.ongoing', compact('rides','reasons'));
  }

  /**
    * show complete rides
  */
  public function complete(Request $request){
    $query = DB::table('ride_list')
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
                ->orderBy('ride_list.id','DESC');
                
    if ($request->phone) { 
      $query = $query->where('users.phone', $request->phone);
    }  
    
    if ($request->booking_date) {
      $query = $query->whereDate('ride_list.created_at', date('Y-m-d', strtotime($request->booking_date)));
    }
    
    if ($request->travel_date) {
      $query = $query->whereDate('ride_list.start_time', date('Y-m-d', strtotime($request->travel_date)));
    }
                
    $rides = $query->paginate(12);  

    return view('quicarbd.admin.ride.complete', compact('rides'));
  }

  /**
    * show cancel rides
  */
  public function cancel(Request $request){
    $query = DB::table('ride_list')
                  ->join('users','ride_list.user_id','users.id')
                  ->leftjoin('ride_biting','ride_list.id','ride_biting.ride_id')
                  ->leftjoin('owners','ride_biting.owner_id','owners.id')
                  ->leftjoin('bit_cancel_list','ride_list.cancellation_id','bit_cancel_list.id')
                  ->select('ride_list.id','ride_list.created_at', 'ride_list.cancel_by',
                          'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                          'users.name as user_name','users.phone as user_phone',
                          'owners.name as owner_name','owners.phone as owner_phone',
                          'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id',
                          'bit_cancel_list.name as reason'
                  )
                ->where('ride_list.status', 2)
                ->orderBy('ride_list.id','DESC');
                
    if ($request->phone) { 
      $query = $query->where('users.phone', $request->phone);
    }  
    
    if ($request->booking_date) {
      $query = $query->whereDate('ride_list.created_at', date('Y-m-d', strtotime($request->booking_date)));
    }
    
    if ($request->travel_date) {
      $query = $query->whereDate('ride_list.start_time', date('Y-m-d', strtotime($request->travel_date)));
    }
                
    $rides = $query->paginate(12);  

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
        $ride = RideList::find($request->ride_id);
     
        if ($bid != null) {
            $partner = Owner::find($bid->owner_id);
            $user    = User::find($bid->user_id);
            
            $bid->status = 2;
            $bid->update();
        
        } else {
            $user_id = RideList::find($request->ride_id)->user_id;
            $user    = User::find($user_id);   
        }
    
        if ($ride->status == 4 && $ride->payment_status == 1) {

          $bittings = RideBiting::where('ride_id', $request->ride_id)
                                ->where('id', '!=', $ride->accepted_ride_bitting_id)
                                ->get();

          foreach ($bittings as $bitting) {

            $tmpBitting = RideBiting::find($bitting->id);
            $tmpBitting->status = 0;
            $tmpBitting->update();

          }

          $user_account = UserAccount::where('tnx_id', $ride->tnx_id)->first();
          
          if ($user_account != null) {
            
            $user = User::find($user_account->user_id);
            $user->balance = ($user->balance + $user_account->adjust_quicar_balance + $user_account->discount + $user_account->online_payment);
            $user->cash_back_balance = ($user->cash_back_balance + $user_account->adjust_cashback);
            $user->update();

            $userAccount = new UserAccount();
            $userAccount->amount          = ($user_account->adjust_quicar_balance + $user_account->discount + $user_account->online_payment + $user_account->adjust_cashback);
            $userAccount->adjust_cashback = $user_account->adjust_cashback;
            $userAccount->adjust_quicar_balance = $user_account->adjust_quicar_balance;
            $userAccount->discount        = $user_account->discount;
            $userAccount->online_payment  = $user_account->online_payment;
            $userAccount->tnx_id          = time();
            $userAccount->type            = 1;
            $userAccount->income_from     = 1;
            $userAccount->history_id      = $ride->id;
            $userAccount->reason          = 'Ride advance payment return in cancel';
            $userAccount->user_id         = $ride->user_id;
            $userAccount->save();
          }
        }

        $ride->status = $ride->status != 4 ? 2 : 1;
        if ($ride->status == 4) {
          $ride->payment_status = 0;
        }
        $ride->update();
        
        $title  = 'Ride Cancel';
        $msg    = $request->reason; 
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
    return response()->json();
    
  }
}
