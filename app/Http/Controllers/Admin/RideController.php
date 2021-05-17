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
use App\Models\Car;
use App\Models\CarType;
use App\Models\OwnerAccount;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Jobs\SendSmsNotification;
use App\Models\CouponList;
use App\Models\CouponUsedList;
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
    * send ride to pending from expired
  */
  public function sendPending($id){
    $ride = RideList::find($id);
    $ride->status = 0; // 0 mean pending
    $ride->update();
    return redirect()->back()->with('message','Ride moved to pending');
  }  
  
  
  /**
    * show pending ride of user
  */
  public function pending(Request $request)
  {
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
    $car_type               = CarType::find($ride->car_type)->name;
   
    $start_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->start_time, new DateTimeZone("UTC"));
    $formattedStartTime = $start_time->format('j M, Y h:i A');
    
    $start_timeNotification = $formattedStartTime;
    $title = $starting_district_name." লোকেশনে ট্রিপ রিকুয়েস্ট"."(".$car_type.")";
    $body = "Pickup From : ".$starting_district_name.", ".$starting_city_name.", ".$startig_area."\nTo : ".$destination_district_name.", ".$destinatin_city_name.", ".$destination_area."\nDate:- ".$start_timeNotification;

    $userTitle = "আপনার ট্রিপ রিকোয়েস্ট টি একটিভ করা হয়েছে";
    $userMsg   = "পার্টনার এর ভাড়ার অফারগুলো দেখতে অ্যাপ এ প্রবেশ করুন। মাত্র ১০% অ্যাডভান্স করে বুকিং করতে পারবেন যেকোনো গাড়ি।";
    
    $id     = User::find($ride->user_id)->n_key;
    $helper = new Helper();
    $helper->sendSinglePartnerNotification($id, $userTitle, $userMsg); //push notification send to user

    $client = new Client();
    //$client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar_owner".$ride->starting_district); //service location wise notificaiton send
    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar_owner"); // global notification send
    
    return redirect()->back()->with('message','Ride Approve Successfully');
  } 
  
  
  /**
    *pending ride edit
  */
  public function edit($id)
  {
    $ride = RideList::find($id);
    $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
    $starting_cities = DB::table('city')->select('id','name')->where('district_id', $ride->starting_district)->orderBy('name','ASC')->get();
    $destination_cities = DB::table('city')->select('id','name')->where('district_id', $ride->destination_district)->orderBy('name','ASC')->get();
    $car_types = DB::table('car_types')->select('id','name')->get();
    
    return view("quicarbd.admin.ride.edit", compact('ride','districts','starting_cities','destination_cities','car_types'));
  } 
  
  
  /**
    * user ride update
  */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
        'starting_district' => 'required',
        'starting_city'     => 'required',
        'startig_area'      => 'required',
        'destination_district'  => 'required',
        'destination_city'      => 'required',
        'destination_area'      => 'required',
        'car_type'      => 'required',
        'rown_way'      => 'required',
        'start_time'    => 'required',
    ]);
    
    try {
        $ride = RideList::find($id);    
        $ride->starting_district    = $request->starting_district;
        $ride->starting_city        = $request->starting_city;
        $ride->startig_area         = $request->startig_area;
        $ride->destination_district = $request->destination_district;
        $ride->destination_city     = $request->destination_city;
        $ride->destination_area     = $request->destination_area;
        $ride->car_type             = $request->car_type;
        $ride->rown_way             = $request->rown_way;
        $ride->extra_note           = $request->extra_note;
        $ride->start_time           = $request->start_time;
        $ride->update();
        
        
    } catch (Exception $ex) {
        return redirect()->back()->with('error_message', $ex->getMessage());
    }
    
    return redirect()->route('ride.pending')->with('message','Ride Update Successfully');
  } 
  
  /**
    * user ride approve from admin panel
  */
  public function userApprove(Request $request)
  {
    $validators = Validator::make($request->all(),[
        'ride_id' => 'required',
        'bid_id'  => 'required',
        'online_balance'    => 'required',
        'user_balance'      => 'required',
        'cashback_balance'  => 'required',
        'coupon_used'  => 'required',
        'coupon_code'  => 'required',
        'tnx_id'  => 'required',
        'method'  => 'required',
    ]);
    
    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    $ride = RideList::find($request->ride_id);
    $bid  = RideBiting::find($request->bid_id);
    
    $booking_id     = "QR".time();
    $current_time   = date("Y-m-d H:i:s");
    $final_amount   = ($bid->quicar_charge + ($bid->quicar_charge * (3/100)));
    $amount         = ($request->online_balance + $request->user_balance + $request->cashback_balance);
    
    if ($amount > $final_amount) {
        return Response::json([
            'status'    => 403,
            'data'      => "Amount not match"
        ]);
    }
    
    if ($request->coupon_used == 1) {
        $coupon = CouponList::select('id','amount','type')->where('coupon', $request->coupon_code)->first();
    } 
    
    DB::beginTransaction();
    
    try {
    
        $bid->status = 1;
        $bid->accepted_timeing = $current_time;
        $bid->update();
        
        $ride->status                   = 4;
        $ride->accepted_ride_bitting_id = $bid->id;
        $ride->accepted_bitting_time    = $current_time;
        $ride->payment_status           = 1;
        $ride->payment_complete_time    = $current_time;
        $ride->booking_id               = $booking_id;
        $ride->tnx_id                   = $request->tnx_id;
        $ride->update();
        
        
        if ($request->online_balance > 0) {
            
            $user_acc                        = new UserAccount();
            $user_acc->amount                = $request->online_balance;
            $user_acc->adjust_cashback       = 0;
            $user_acc->adjust_quicar_balance = 0;
            $user_acc->discount              = 0;
            $user_acc->online_payment        = $request->online_balance;
            $user_acc->tnx_id                = "CB".time();
            $user_acc->booking_id            = $booking_id;
            $user_acc->type                  = 1; //credit
            $user_acc->income_from           = 1; //ride
            $user_acc->history_id            = $ride->id; //ride
            $user_acc->reason                = "Online Credit add for Ride";
            $user_acc->user_id               = $ride->user_id;
            $user_acc->save();
        }
        
        $userAcc                        = new UserAccount();
        $userAcc->amount                = $amount;
        $userAcc->adjust_cashback       = $request->cashback_balance;
        $userAcc->adjust_quicar_balance = $request->user_balance;
        $userAcc->discount              = $request->coupon_used == 1 ? $coupon->amount : 0;
        $userAcc->online_payment        = $request->online_balance;
        $userAcc->tnx_id                = $request->tnx_id;
        $userAcc->booking_id            = $booking_id;
        $userAcc->type                  = 0; //debit
        $userAcc->income_from           = 1; //ride
        $userAcc->history_id            = $ride->id; //ride
        $userAcc->reason                = "Car Rent advance payment";
        $userAcc->advance_payment       = 1;
        $userAcc->user_id               = $ride->user_id;
        $userAcc->method                = $ride->method;
        $userAcc->save();
        
        if ($request->user_balance > 0) {
            
            $user_balance = User::find($ride->user_id);
            $user_balance->balance = ($user_balance->balance - $request->user_balance);
            $user_balance->update();
        }     
        
        if ($request->cashback_balance > 0) {
            
            $user_cashhback = User::find($ride->user_id);
            $user_cashhback->cash_back_balance = ($user_cashhback->cash_back_balance - $request->cashback_balance);
            $user_cashhback->update();
        }
        
        if ($request->coupon_used == 1) {
            $coupon_used                = new CouponUsedList();
            $coupon_used->coupon_id     = $coupon->id;
            $coupon_used->used_user_id  = 1;
            $coupon_used->save();
        }
        
        $bittings = RideBiting::select('id')->where('accepted_timeing', null)->where('ride_id', $ride->id)->get();
        foreach ($bittings as $bitting) {
            $tmpBid = RideBiting::find($bitting->id);
            $tmpBid->status = 4;
            $tmpBid->update();
        }
        
        /* Partner SMS,Notification Section */
        
            $carRegNo = Car::find()->carRegisterNumber;
            $carType = Car::find()->carType;
            $tripType = $ride->rown_way == 0 ? "একমুখী" : "উভয়মুখী";
            $start_date = date('j M, Y H:i:s', strtotime($ride->start_time));
            $start_time = date('H:i:s', strtotime($ride->start_time));
            $bid_amount = $bid->bit_amount;
            
            $partner_sms_title = "আপনার একটি গাড়ির বুকিং কন্ফার্ম হয়েছে।\n";
            $partner_sms_msg   = "গাড়ির নাম্বার : ".$carRegNo." '\n যাত্রার তারিখ: ".$carType."\nকুইকার পার্টনার সাপোর্ট" ;
            $partnerNotification = "আপনার একটি গাড়ির বুকিং কন্ফার্ম হয়েছে\n আপনার বুকিং আইডি : ".$ride->booking_id." \n গাড়ির নাম্বার :".$carType."\n যাত্রার ধরণ : ".$tripType;
            $partnerMessage = "যাত্রার তারিখ : ".$start_date."\n যাত্রার সময় : ".$start_time."\n আপনার ভাড়া :".$bid_amount."\n কুইকার চার্জ : ".$bid->quicar_charge."\n আপনি পাবেন : ".$bid->you_get."আপনার ".$bid->you_get." টাকা ট্রিপ শেষ হওয়ার পর ইউজারের থেকে বুঝে নিন। \n এখনি ইউজারের সাথে কথা বলে বিস্তারিত জেনে নিন \n আপনার যাত্রা শুভ হোক \n কুইকার পার্টনার সাপোর্ট \n ";
            if (!empty($ride->extra_note)) {
                $parnterFinalMsg = $partnerNotification." (নোট : ".$ride->extra_note.$partnerMessage.")";
            } else {
                $parnterFinalMsg = $partnerNotification." ".$partnerMessage;
            }
            
            $helper = new Helper(); 
            $owner_key = Owner::find($bid->owner_id)->n_key;
            $owner_phone = Owner::find($bid->owner_id)->phone;
            
            $helper->sendSinglePartnerNotification($owner_key, $partner_sms_title, $partner_sms_msg); //push notification send
            $helper->smsSend($owner_phone, $partner_sms_msg); // sms send
            $helper->smsNotification($type = 2, $bid->owner_id, $partner_sms_title, $parnterFinalMsg); // bell notification, 2=partner
            
        /* Partner SMS,Notification Section End*/
        
        
        /* User SMS,Notification Section*/
            $trip_type = $ride->rown_way == 0 ? "One Way" : "Round Way";
            
            $user_sms_title = "Your payment has been done.";
            $user_sms_msg = "Trip Type : ". $trip_type. " \n Booking ID : ". $ride->booking_id . " \n Transaction ID : ". $ride->tnx_id . " \n Travel Date : ". $start_date. " \n Travel Time : ".$start_time. "\n Total Price : ". $bid->bit_amount. "\n Advance Payment : ".$bid->quicar_charge. "\n Pay to Driver : ". $bid->you_get." \n Have a safe journey \n Team Quicar";
            $user_notification = "Your payment has been done. Trip Type : ". $trip_type. " \n Booking ID : ". $ride->booking_id . " \n Transaction ID : ". $ride->tnx_id . " \n Travel Date : ". $start_date. " \n Travel Time : ".$start_time. "\n Total Price : ". $bid->bit_amount. "\n Advance Payment : ".$bid->quicar_charge. "\n Pay to Driver : ". $bid->you_get." \n Have a safe journey \n Team Quicar";
            
            $user_key = User::find($ride->user_id)->n_key;
            $user_phone = Owner::find($ride->user_id)->phone;
            
            $helper->sendSinglePartnerNotification($user_key, $user_sms_title, $user_sms_msg); //push notification send
            $helper->smsSend($user_phone, $user_sms_msg); // sms send
            $helper->smsNotification($type = 1, $ride->user_id, $user_sms_title, $user_notification); // bell notification, 2=partner
        /* User SMS,Notification Section End*/
        
        DB::commit();
        
    } catch (Exception $ex) {
        
        DB::rollback();
        
        $ex->getMessage();
    }
    
    $ride->status = 4;
    $ride->update();
    
    $starting_district_name = District::find($ride->starting_district)->bn_name;
    $starting_city_name     = City::find($ride->starting_city)->bn_name;
    $startig_area           = $ride->startig_area;
    $destination_district_name = District::find($ride->destination_district)->bn_name;
    $destinatin_city_name   = City::find($ride->destination_city)->bn_name;
    $destination_area       = $ride->destination_area;
    $car_type               = CarType::find($ride->car_type)->name;
   
    $start_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->start_time, new DateTimeZone("UTC"));
    $formattedStartTime = $start_time->format('j M, Y h:i A');
    
    $start_timeNotification = $formattedStartTime;
    $title = $starting_district_name." লোকেশনে ট্রিপ রিকুয়েস্ট"."(".$car_type.")";
    $body = "Pickup From : ".$starting_district_name.", ".$starting_city_name.", ".$startig_area."\nTo : ".$destination_district_name.", ".$destinatin_city_name.", ".$destination_area."\nDate:- ".$start_timeNotification;

    $userTitle = "আপনার ট্রিপ রিকোয়েস্ট টি একটিভ করা হয়েছে";
    $userMsg   = "পার্টনার এর ভাড়ার অফারগুলো দেখতে অ্যাপ এ প্রবেশ করুন। মাত্র ১০% অ্যাডভান্স করে বুকিং করতে পারবেন যেকোনো গাড়ি।";
    
    $id     = User::find($ride->user_id)->n_key;
    $helper = new Helper();
    $helper->sendSinglePartnerNotification($id, $userTitle, $userMsg); //push notification send to user

    $client = new Client();
    //$client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar_owner".$ride->starting_district); //service location wise notificaiton send
    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar_owner"); // global notification send
    
    return redirect()->back()->with('message','Ride Approve Successfully');
  } 
  
  /**
    * show bid request
  */
  public function bidRequest(Request $request)
  {
    $current_date_time = Carbon::now()->toDateTimeString(); 
    $query = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.created_at',
                        'ride_list.starting_district','ride_list.starting_city','ride_list.startig_area', 
                        'ride_list.destination_district','ride_list.destination_city','ride_list.destination_area',
                        'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                        'ride_list.ride_visiable_time','users.name as user_name','users.phone as user_phone','ride_list.max_request'
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
    * show upcoming bid ridesr
  */
  public function upcoming(Request $request)
  {
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
    $sms   = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
    
    return view('quicarbd.admin.ride.upcoming', compact('rides','reasons','sms'));
  }

  /**
    * show complete rides
  */
  public function complete(Request $request)
  {
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
    $sms   = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
    
    return view('quicarbd.admin.ride.complete', compact('rides','sms'));
  }

  /**
    * show cancel rides
  */
  public function cancel(Request $request)
  { 
    $query = DB::table('ride_list')
                  ->join('users','ride_list.user_id','users.id')
                  ->leftjoin('bit_cancel_list','ride_list.cancellation_id','bit_cancel_list.id')
                  ->select('ride_list.id','ride_list.created_at', 'ride_list.cancel_by',
                          'ride_list.start_time', 'ride_list.user_id', 'ride_list.car_type', 'ride_list.rown_way',
                          'users.name as user_name','users.phone as user_phone','bit_cancel_list.name as reason',
                          'ride_list.cancellation_bit_id','ride_list.cancellation_id','ride_list.payment_status'
                  )
                ->where('ride_list.status', 2)
                ->orderBy('ride_list.updated_at','DESC');
                
    if ($request->phone) { 
      $query = $query->where('users.phone', $request->phone);
    }   
    
    if ($request->car_type) { 
      $query = $query->where('ride_list.car_type', $request->car_type);
    }    
    
    if (isset($request->payment_status) && $request->payment_status != 10000) { 
      $query = $query->where('ride_list.payment_status', $request->payment_status);
    }  
    
    if ($request->booking_date) {
      $query = $query->whereDate('ride_list.created_at', date('Y-m-d', strtotime($request->booking_date)));
    }
    
    if ($request->travel_date) {
      $query = $query->whereDate('ride_list.start_time', date('Y-m-d', strtotime($request->travel_date)));
    }
                
    $rides = $query->paginate(12);  
    $car_types = DB::table("car_types")->orderBy('name','ASC')->get();

    return view('quicarbd.admin.ride.cancel', compact('rides','car_types'));
  }

  /**
    * show upcoming bid rides
  */
  public function bidding($id)
  {
    $biddings = DB::table('ride_biting')
                  ->leftjoin('owners','ride_biting.owner_id','owners.id')
                  ->leftjoin('drivers','ride_biting.driver_id','drivers.id')
                  ->leftjoin('cars','ride_biting.car_id','cars.id')
                  ->select('drivers.name as driver_name','drivers.phone as driver_phone',
                          'owners.name as owner_name','owners.phone as owner_phone','ride_biting.owner_id',
                          'ride_biting.*','cars.carRegisterNumber','cars.carModel','cars.carYear'
                    )
                  ->where('ride_biting.ride_id', $id)
                  ->orderBy('ride_biting.id','DESC')
                  ->get();
    
    return view('quicarbd.admin.ride.bidding', compact('biddings'));
  }

  /**
    * show ride details
  */
  public function details($ride_id)
  {
    $ride = RideList::find($ride_id);  
    $transactions = DB::table('user_account')
                    ->leftjoin('users','user_account.user_id','users.id')
                    ->select('user_account.*','users.phone')
                    ->where('user_account.history_id', $ride->accepted_ride_bitting_id)
                    ->orderBy('user_account.id','DESC')
                    ->get();
    
    if ($ride->start_time != null) {
        
        $start_date = date('Y-m-d', strtotime($ride->start_time));
        $today_date = date('Y-m-d');
        
        $earlier = new DateTime($start_date);
        $later   = new DateTime($today_date);
        
        $diff = $later->diff($earlier)->format("%a");
    } else {
        $diff = 0;
    }
  
    return view('quicarbd.admin.ride.details', compact('ride','transactions','diff'));
  }

  /**
   * ride cancel reason send
  */
  public function reasonSend (Request $request) 
  {
    $validators = Validator::make($request->all(),[
        'ride_id' => 'required',
        'reason'  => 'required'
    ]);
    
    $ride = RideList::find($request->ride_id);
    if ($ride->accepted_ride_bitting_id != null) {
        $bid  = RideBiting::find($ride->accepted_ride_bitting_id);
    }
    
    if ($ride->status == 4) {
        $validators = Validator::make($request->all(),[
            'cancel_from' => 'required',
            'charge_apply'=> 'required'
        ]);
    }
    
    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    DB::beginTransaction();
    
    try {
     
        if ($ride->accepted_ride_bitting_id != null) {
            $partner = Owner::find($bid->owner_id);
            
            $bid->status = 2;
            $bid->update(); 
        }
        
        $user    = User::find($ride->user_id);
    
        if ($ride->status == 4) {

        //   $user_account = UserAccount::where('tnx_id', $ride->tnx_id)->first();
        //   if ($user_account != null) {
        //     $user = User::find($user_account->user_id);
        //     $user->balance = ($user->balance + $user_account->adjust_quicar_balance + $user_account->discount + $user_account->online_payment);
        //     $user->cash_back_balance = ($user->cash_back_balance + $user_account->adjust_cashback);
        //     $user->update();

        //     $userAccount = new UserAccount();
        //     $userAccount->amount          = ($user_account->adjust_quicar_balance + $user_account->discount + $user_account->online_payment + $user_account->adjust_cashback);
        //     $userAccount->adjust_cashback = $user_account->adjust_cashback;
        //     $userAccount->adjust_quicar_balance = $user_account->adjust_quicar_balance;
        //     $userAccount->discount        = $user_account->discount;
        //     $userAccount->online_payment  = $user_account->online_payment;
        //     $userAccount->tnx_id          = time();
        //     $userAccount->type            = 1; // 1 credit, user income
        //     $userAccount->income_from     = 1; // 1 mean ride
        //     $userAccount->history_id      = $ride->id;
        //     $userAccount->reason          = 'Ride advance payment return in cancel';
        //     $userAccount->user_id         = $ride->user_id;
        //     $userAccount->save();
        //   }
          
          
          if ($request->cancel_from == 0 && $request->charge_apply == 1) { // 0 mean user
            
            $start = $ride->accepted_bitting_time;
            $end   = date('Y-m-d H:i:s');
     
            $diff = strtotime($start) - strtotime($end);
            $fullDays   = floor($diff/(60*60*24));   
            $interval   = floor(($diff-($fullDays*60*60*24))/(60*60)); 
      
            if ($interval > 24) {
                $amount = $bid->bit_amount - ($bid->bit_amount * (50/100));
            } else {
                $amount = $bid->bit_amount;
            }
          
            $user->balance = ($user->balance + $amount);
            $user->update();
            
            $user_account = UserAccount::where('tnx_id', $ride->tnx_id)->first();
            
            $userAccount = new UserAccount();
            $userAccount->amount          = $amount;
            $userAccount->adjust_cashback = 0;
            $userAccount->adjust_quicar_balance = 0;
            $userAccount->discount        = 0;
            $userAccount->online_payment  = $amount;
            $userAccount->tnx_id          = time();
            $userAccount->type            = 1; // 1 credit, user income
            $userAccount->income_from     = 1; // 1 mean ride
            $userAccount->history_id      = $ride->id;
            $userAccount->reason          = 'Ride advance payment return in cancel';
            $userAccount->user_id         = $ride->user_id;
            $userAccount->save();
            
          } elseif ($request->cancel_from == 1 && $request->charge_apply == 1) {
            
            $commission = ($bid->bit_amount * (5/100)); 
            
            $partner = Owner::find($bid->owner_id);
            $partner->current_balance = ($partner->current_balance - $commission);
            $partner->update();
            
            $parnterAccount = new OwnerAccount();
            $parnterAccount->amount         = $partner->current_balance;
            $parnterAccount->quicar_charge  = $commission;
            $parnterAccount->net_amount     = ($partner->current_balance + $commission);
            $parnterAccount->type           = 0; // debit 0 mean partner expense
            $parnterAccount->income_from    = 1;
            $parnterAccount->reason_text    = 'Ride Cancel Commission Deduct';
            $parnterAccount->history_id     = $ride->id;
            $parnterAccount->owner_id       = $bid->owner_id;
            $parnterAccount->status         = 1;
            $parnterAccount->save();
            
            $getAccount  = DB::table('user_account')
                            ->join('ride_biting','user_account.history_id','ride_biting.id')
                            ->select('user_account.amount')
                            ->where('user_account.type', 0)
                            ->where('user_account.income_from', 1)
                            ->where('user_account.tnx_id', $ride->tnx_id)
                            ->first();
                            
            $user->balance = ($user->balance + $getAccount->amount);
            $user->update();

            $userAccount = new UserAccount();
            $userAccount->amount          = $getAccount->amount;
            $userAccount->adjust_cashback = 0;
            $userAccount->adjust_quicar_balance = 0;
            $userAccount->discount        = 0;
            $userAccount->online_payment  = $getAccount->amount;
            $userAccount->tnx_id          = time();
            $userAccount->type            = 1; // 1 credit, user income
            $userAccount->income_from     = 1; // 1 mean ride
            $userAccount->history_id      = $ride->id;
            $userAccount->reason          = 'Ride cancel amount back in user account';
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
        
        if($request->cancel_from == 1) { 
            $helper->sendSinglePartnerNotification($partner->n_key, $title, $msg); //push notification send to partner
            $helper->smsNotification($type=2, $bid->owner_id, $title, $msg); // send notification, 2=partner
        }
        
        if ($request->cancel_from == 0) {
            $helper->sendSinglePartnerNotification($user->n_key, $title, $msg); //push notification send to user
            $helper->smsNotification($type=1, $user->id, $title, $msg); // send notification, 1=user
        }
        
        DB::commit();
        
    } catch (Exception $ex) {
        
        DB::rollback();
        $ex->getMessage();
    }
    
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
            'owners'        => $owners
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
   * bid upcoming notification send
   */
  public function upcomingNotificationSend (Request $request) 
  { 
    $validators = Validator::make($request->all(),[
        'ride_id'   => 'required',
        'user_id'   => 'required',
        'owner_id'  => 'required',
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
    
        $owner = DB::table('owners')->select('owners.phone','owners.n_key')->first();
              
        if($request->notification == 1){
            
            $helper->smsNotification($type=2, $request->owner_id, $title, $msg); // send notification, 2=partner
            $helper->sendSinglePartnerNotification($owner->n_key, $title, $msg); //push notification send
            
        } elseif ($request->notification == 2){
            
            $helper->smsNotification($type=2, $request->owner_id, $title, $msg); // send notification, 2=partner
            $helper->sendSinglePartnerNotification($owner->n_key, $title, $msg); //push notification send
            $helper->smsSend($owner->phone, $msg); // sms send
        }
    	
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
  
  /**
   * Bid Cancel
   */
  public function bidCancel(Request $request) 
  {
    $validators = Validator::make($request->all(),[
        'id'            => 'required',
        'cancel_reason' => 'required'
    ]);
   
    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    try {
        
        $bidding = RideBiting::find($request->id);
        if ($bidding->status != 1) {
            $bidding->status        = 2;
            $bidding->cancel_reason = $request->cancel_reason;
            $bidding->update();
            
            $title  = 'Bid Cancel';
            $msg    = $request->cancel_reason; 
            $helper = new Helper(); 
            
            $helper->sendSinglePartnerNotification($partner->n_key, $title, $msg); //push notification send to partner
            $helper->smsNotification($type=2, $bidding->owner_id, $title, $msg); // send notification, 2=partner
        }
    } catch (Exception $ex) {
        $ex->getMessage();
    }
    
    return response()->json();
    
  } 
  
  /**
   * Bid Request Quantity Update
   */
  public function bidRequestQtyUpdate(Request $request) 
  {
    $validators = Validator::make($request->all(),[
        'ride_id'        => 'required',
        'new_max_request'=> 'required'
    ]);
    
    if($validators->fails()){
        return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
    }
    
    try {
        
        $ride               = RideList::find($request->ride_id);
        $ride->max_request  = $request->new_max_request;
        $ride->update();
        
    } catch (Exception $ex) {
        $ex->getMessage();
    }
    return response()->json();
  }
}
