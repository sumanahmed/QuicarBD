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
use App\Models\District;
use App\Models\City;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Jobs\SendSmsNotification;
use Carbon\Carbon;
use Validator;
use Response;
use DateTime;
use DateTimeZone;

use DB;

class RideController extends Controller
{
  /**
    * show expired ride 
  */
  public function bidExpiredRide(Request $request){
    $current_date_time = Carbon::now()->toDateTimeString(); 
    $query = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.created_at',
                        'ride_list.starting_district','ride_list.starting_city','ride_list.startig_area', 
                        'ride_list.destination_district','ride_list.destination_city','ride_list.destination_area',
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'ride_list.ride_visiable_time','users.name as user_name','users.phone as user_phone'
                )
                ->where('ride_list.status', 1)
                ->where('ride_list.payment_status', 0)
                ->where('ride_list.ride_visiable_time', '<', $current_date_time)
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
    return view('quicarbd.admin.ride.expired_ride', compact('rides','reasons'));
  }  
  
  /**
    * show pending ride of user
  */
  public function pending(Request $request){
    $query = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.created_at',
                        'ride_list.starting_district','ride_list.starting_city','ride_list.startig_area', 
                        'ride_list.destination_district','ride_list.destination_city','ride_list.destination_area',
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'ride_list.ride_visiable_time','users.name as user_name','users.phone as user_phone'
                )
                ->where('ride_list.status', 0)
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
    $sms     = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
    return view('quicarbd.admin.ride.pending', compact('rides','reasons','sms'));
  } 
  
  /**
    *approve pending ride of user
  */
  public function approve($id){
    $ride = RideList::find($id);
    
    if (!$ride) {
        return redirect()->back()->with('error_message','Sorry ride not found');
    }
    
    $ride->status = 1;
    $ride->update();
    
    $starting_district_name = District::find($ride->starting_district)->bn_name;
    $starting_city_name     = City::find($ride->starting_city)->bn_name;
    $startig_area           = $ride->startig_area;
    $destination_district_name = District::find($ride->destination_district)->bn_name;
    $destinatin_city_name   = City::find($ride->destination_city)->bn_name;
    $destination_area       = $ride->destination_area;
    
    $start_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->start_time, new DateTimeZone("UTC"));
    $formattedStartTime = $start_time->format('j M, Y h:i A');
    
    $start_timeNotification = $formattedStartTime;
    $title = "New Ride arrive on your Service Location";
    $body = "Pickup From : ".$starting_district_name.", ".$starting_city_name.", ".$startig_area."\nTo : ".$destination_district_name.", ".$destinatin_city_name.", ".$destination_area."\nDate:- ".$start_timeNotification;

    $client = new Client();
    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar_owner".$ride->starting_district);
    
    return redirect()->route('ride.bid_request')->with('message','Ride Approve Successfully');
  } 
  
  /**
    * show bid request
  */
  public function bidRequest(Request $request){
    $current_date_time = Carbon::now()->toDateTimeString(); 
    $query = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.created_at',
                        'ride_list.starting_district','ride_list.starting_city','ride_list.startig_area', 
                        'ride_list.destination_district','ride_list.destination_city','ride_list.destination_area',
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'ride_list.ride_visiable_time','users.name as user_name','users.phone as user_phone'
                )
                ->where('ride_list.status', 1)
                ->where('ride_list.payment_status', 0)
                ->where('ride_list.ride_visiable_time', '>', $current_date_time)
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
    $sms     = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
    return view('quicarbd.admin.ride.bid_request', compact('rides','reasons','sms'));
  }
  
  
  /**
    * show upcoming bid rides
  */
  public function upcoming(Request $request){
    $current_date_time = Carbon::now()->toDateTimeString(); 
    $query = DB::table('ride_list')
            ->join('users','ride_list.user_id','users.id')
            ->join('ride_biting','ride_list.accepted_ride_bitting_id','ride_biting.id')
            ->leftjoin('cars','ride_biting.car_id','cars.id')
            ->leftjoin('car_types','ride_list.car_type','car_types.id')
            ->leftjoin('owners','ride_biting.owner_id','owners.id')
            ->leftjoin('drivers','ride_biting.driver_id','drivers.id')
            ->select('ride_list.id','ride_list.created_at',                    
                    'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                    'users.name as user_name','users.phone as user_phone',
                    'owners.name as owner_name','owners.phone as owner_phone',
                    'drivers.name as driver_name','drivers.phone as driver_phone',
                    'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id',
                    'cars.carRegisterNumber','car_types.name as car_type_name','ride_list.accepted_ride_bitting_id'
            )
            ->where('ride_list.status', 4) //4 mean bit accept
            ->where('ride_biting.status', 1) // 1 mean bit accept
            ->where('ride_list.accepted_ride_bitting_id', '!=', null)
            ->where('ride_list.start_time', '>', $current_date_time)
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
    * show complete rides
  */
  public function complete(Request $request){
    $current_date_time = Carbon::now()->toDateTimeString();
    $query = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->join('ride_biting','ride_list.accepted_ride_bitting_id','ride_biting.id')
                ->leftjoin('owners','ride_biting.owner_id','owners.id')
                ->leftjoin('drivers','ride_biting.driver_id','drivers.id')
                ->select('ride_list.id','ride_list.created_at', 'ride_list.review_give'                   ,
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'users.name as user_name','users.phone as user_phone',
                        'owners.name as owner_name','owners.phone as owner_phone',
                        'drivers.name as driver_name','drivers.phone as driver_phone',
                        'ride_biting.bit_amount','ride_biting.owner_id', 'ride_biting.driver_id','ride_list.accepted_ride_bitting_id'
                )
                ->where('ride_list.status', 4)
                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                ->where('ride_list.start_time', '<', $current_date_time)
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
                  ->leftjoin('bit_cancel_list','ride_list.cancellation_id','bit_cancel_list.id')
                  ->select('ride_list.id','ride_list.created_at', 'ride_list.cancel_by',
                          'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                          'users.name as user_name','users.phone as user_phone','bit_cancel_list.name as reason',
                          'ride_list.cancellation_bit_id','ride_list.cancellation_id'
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
            $userAccount->type            = 1; // 1 credit, user income
            $userAccount->income_from     = 1; // 1 mean ride
            $userAccount->history_id      = $ride->id;
            $userAccount->reason          = 'Ride advance payment return in cancel';
            $userAccount->user_id         = $ride->user_id;
            $userAccount->save();
          }
        }

        $ride->status           = 2;
        $ride->cancel_by        = 2; // 2 mean admin
        $ride->cancel_reason    = $request->reason; 
        $ride->cancellation_time= date('Y-m-d H:i:s'); 
        $ride->update();
        
        $title  = 'Ride Cancel';
        $msg    = $request->reason; 
        $helper = new Helper(); 
        
        if(isset($parnter)) {
            $helper->sendSinglePartnerNotification($partner->n_key, $title, $msg); //push notification send to partner
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
  
  /**
   * update bid request ride visible time
   */
  public function updateVisibleTime (Request $request) {
      
    $validators = Validator::make($request->all(),[
        'ride_id' => 'required',
        'ride_visiable_time'  => 'required'
    ]);
    
    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    try {
        
        $ride = RideList::find($request->ride_id);
        $ride->ride_visiable_time = $request->ride_visiable_time;
        $ride->update();
        
    } catch (Exception $ex) {
        $ex->getMessage();
    }
    
    return response()->json();
    
  }  
  
  /**
   * bid request notification send
   */
  public function notificationSend (Request $request) 
  {
    $validators = Validator::make($request->all(),[
        'ride_id'   => 'required',
        'user_id'   => 'required',
        'title'     => 'required',
        'message'   => 'required',
        'for'       => 'required',
        'notification' => 'required',
    ]);

    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    $helper = new Helper();
    $title  = $request->title;
    $msg    = $request->message; 
    
    if ($request->for == 1) { // 1 mean user
        $user = DB::table('users')->select('id','n_key','name','phone')->where('id', $request->user_id)->first();
        
        if($request->notification == 1){
            
            $helper->smsNotification($type=1, $request->user_id, $title, $msg); // send notification, 1=user
            $helper->sendSinglePartnerNotification($user->n_key, $title, $msg); //push notification send
            
        } elseif ($request->notification == 2){
            
            $helper->smsNotification($type=1, $request->user_id, $title, $msg); // send notification, 1=user
            $helper->sendSinglePartnerNotification($user->n_key, $title, $msg); //push notification send
            $helper->smsSend($user->phone, $msg); // sms send
        }
    } elseif ($request->for == 2) { // 2 mean partner
    
        $owners = DB::table('ride_biting')
                    ->join('owners','ride_biting.owner_id','owners.id')
                    ->select('owners.id','owners.phone','owners.n_key')
                    ->where('ride_biting.ride_id', $request->ride_id)
                    ->get();
                    
        $details = [
    		'for'           => $request->for,
            'title'         => $title,
            'message'       => $msg,
            'notification'  => $request->notification,
            'users'         => [],
            'owners'        => $owner
    	];
    	
    	// send all mail in the queue.
        $job = (new SendSmsNotification($details))
            ->delay(
            	now()
            	->addSeconds(2)
            ); 

        dispatch($job);
    	
    }
    
    return Response::json([
        'status'    => 200,
        'message'   => "Notification & SMS send successfully",
    ]);
    
  }
    
  /**
   * update bid amount
   */
  public function updateBidAmount (Request $request) 
  {
    $validators = Validator::make($request->all(),[
        'id'            => 'required',
        'new_bit_amount'=> 'required'
    ]);
    
    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    try {
        
        $bidding = RideBiting::find($request->id);
        
        $owner_bid_percent = Owner::find($bidding->owner_id)->bidding_percent;
        $quicar_charge  = ($request->new_bit_amount * ($owner_bid_percent / 100));
        $you_get        = $request->new_bit_amount - $quicar_charge;
      
        $bidding->bit_amount    = $request->new_bit_amount;
        $bidding->quicar_charge = $quicar_charge;
        $bidding->you_get       = $you_get;
        $bidding->update();
        
    } catch (Exception $ex) {
        $ex->getMessage();
    }
    
    return response()->json();
    
  }
}
