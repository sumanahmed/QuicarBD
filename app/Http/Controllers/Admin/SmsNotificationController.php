<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Jobs\SendSmsNotification;
use App\Models\OwnerNotification;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Validator;
use App\Models\Owner;
use App\Models\User;
use DB;

class SmsNotificationController extends Controller
{
    //show sms notification send page
    public function index(){
        $car_types = DB::table('car_types')->select('*')->get(); 
        $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
        $sms    = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
        return view('quicarbd.admin.sms-notification.sms-notification', compact('car_types','districts','sms'));
    }

    //send sms notification
    public function send(Request $request)
    {   
        $this->validate($request,[
            'for'       => 'required',
            'status'    => 'required',
            'title'     => 'required',
            'message'   => 'required',
            'notification' => 'required',
        ]);
        
        $title = $request->title;
        $body  = $request->message;
        
        if($request->hasFile('image')){ 
            $image             = $request->file('image');
            $imageName         = time().".".$image->getClientOriginalExtension();
            $directory         = '../mobileapi/asset/notification/';
            $image->move($directory, $imageName);
            $notificationImg = "http://quicarbd.com/mobileapi/asset/notification/".$imageName;
            $image = $notificationImg;
        } else {
            $image = "";
        }
        
        if ($request->notification == 0) { //push notification
        
            if($request['for'] == 1){ // 1 mean user
                
                $helper = new Helper(); 
                $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar");
                
            } else { // 2 mean partner
            
                if (isset($request->account_type) && $request->account_type != null) {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="account_type".$request->account_type);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                } elseif (isset($request->complete_ride) && $request->complete_ride != 100) {
                    
                  $query = DB::table('users')->select('users.id','users.n_key')->orderBy('id','DESC')
                            ->join('ride_list','users.id','ride_list.user_id')
                            ->addSelect('ride_list.status')
                            ->where('ride_list.status', 4)
                            ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                            ->distinct('ride_list.user_id');
                    
                } elseif (isset($request->service_location_district) && $request->service_location_district != null) {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner".$request->service_location_district);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner".$request->service_location_district);
                } else {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner");
                }
            }
        } elseif ($request->notification == 1) { //bell notification

            if($request['for'] == 1){ // 1 mean user
                if (isset($request->complete_ride) && $request->complete_ride == 1) {
                      
                    $users = DB::table('users')
                                ->join('ride_list','users.id','ride_list.user_id')
                                ->select('users.id','users.n_key')
                                ->where('ride_list.status', 4)
                                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                                ->distinct('ride_list.user_id')
                                ->get()
                                ->toArray();
                 
                    foreach($users as $key => $user) {
                        $tokenList[$key]            = $user->n_key;
                        $bulk[$key]['user_id']      = $user->id;
                        $bulk[$key]['title']        = $title;
                        $bulk[$key]['description']  = $body;
                    }
                   
                    UserNotification::insert($bulk);
              
                    $helper = new Helper(); 
                    $helper->sendBellAndPushNotification($tokenList);
                            
                } else {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar");
                    
                    $helper = new Helper(); 
                    $helper->smsNotification($type = 1, 0, $title, $body); // bell notification, 1=user
                }
            } else { // 2 mean partner
            
                if (isset($request->account_type) && $request->account_type != null) {
                    
                    $owners = DB::table('owners')
                                ->select('id','n_key')
                                ->where('account_type', $request->account_type)
                                ->get()
                                ->toArray();
           
                    foreach($owners as $key => $owner) {
                        $tokenList[$key]            = $owner->n_key;
                        $bulk[$key]['owner_id']     = $owner->id;
                        $bulk[$key]['title']        = $title;
                        $bulk[$key]['description']  = $body;
                    }
                   
                    OwnerNotification::insert($bulk);
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="account_type".$request->account_type);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                    
                } elseif (isset($request->complete_ride) && $request->complete_ride == 1) {
                    $current_date_time      = Carbon::now()->toDateTimeString();
                    $owners = DB::table('owners')
                                ->join('ride_biting','owners.id','ride_biting.owner_id')
                                ->join('ride_list','ride_biting.ride_id','ride_list.id')
                                ->select('owners.id','owners.n_key')
                                ->where('ride_biting.status', 1)
                                ->where('ride_list.status', 4)
                                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                                ->where('ride_list.start_time', '<', $current_date_time)
                                ->get()
                                ->toArray();
           
                    foreach($owners as $key => $owner) {
                        $tokenList[$key]            = $owner->n_key;
                        $bulk[$key]['owner_id']     = $owner->id;
                        $bulk[$key]['title']        = $title;
                        $bulk[$key]['description']  = $body;
                    }
                   
                    OwnerNotification::insert($bulk);
              
                    $helper = new Helper(); 
                    $helper->sendBellAndPushNotification($tokenList);
                    
                } elseif (isset($request->service_location_district) && $request->service_location_district != null) {
                    
                    $owners = DB::table('owners')
                                ->select('id','n_key')
                                ->where('service_location_district', $request->service_location_district)
                                ->get()
                                ->toArray();
           
                    foreach($owners as $key => $owner) {
                        $tokenList[$key]            = $owner->n_key;
                        $bulk[$key]['owner_id']     = $owner->id;
                        $bulk[$key]['title']        = $title;
                        $bulk[$key]['description']  = $body;
                    }
                   
                    OwnerNotification::insert($bulk);
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner".$request->service_location_district);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner".$request->service_location_district);
                    
                } else {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner");
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner");
                    
                    $helper = new Helper(); 
                    $helper->smsNotification($type = 2, 0, $title, $body); // bell notification, 2=partner
                }
            }
            
        } elseif ($request->notification == 2) { // sms & notification
        
            if($request['for'] == 1){ // 1 mean user
            
                $helper = new Helper(); 
                $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar");
                
                // $client = new Client(); 
                // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar");
                
                $users_phone = DB::table('users')->where('account_status', $request->status)->pluck('phone')->implode(', '); 
                $helper = new Helper(); 
                $helper->smsSend($users_phone, $body); // sms send
                
            } else { // 2 mean partner
                if (isset($request->account_type) && $request->account_type != null) {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="account_type".$request->account_type);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                    
                } elseif (isset($request->complete_ride) && $request->complete_ride != 100) {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="account_type".$request->account_type);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                    
                } elseif (isset($request->service_location_district) && $request->service_location_district != null) {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner".$request->service_location_district);
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner".$request->service_location_district);
                } else {
                    
                    $helper = new Helper(); 
                    $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner");
                    
                    // $client = new Client();
                    // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner");
                }
                
                $users_phone = DB::table('owners')->where('account_status', $request->status)->pluck('phone')->implode(', '); 
                
                $helper = new Helper(); 
                $helper->smsSend($users_phone, $body); // sms send
            }
        }
        
        return redirect()->back()->with('message','Send successfully');        
    }

    //show sms notification send page
    public function pushNotification()
    {
        $car_types = DB::table('car_types')->select('*')->get();
        $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
        $sms       = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
        return view('quicarbd.admin.sms-notification.push-notification', compact('car_types','districts','sms'));
    }
    
        //show sms notification send page
    public function globalNotification()
    { 
        $sms = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
        return view('quicarbd.admin.sms-notification.global-notification',compact('sms'));
    }

    //send sms notification
    public function globalNotificationSend(Request $request)
    {  
        $this->validate($request,[
            'for'       => 'required',
            'title'     => 'required',
            'message'   => 'required'
        ]);
       
        $title  = $request->title;
        $body   = strip_tags($request->message);
        if($request->hasFile('image')){ 
            $image             = $request->file('image');
            $imageName         = time().".".$image->getClientOriginalExtension();
            $directory         = '../mobileapi/asset/notification/';
            $image->move($directory, $imageName);
            $notificationImg = "http://quicarbd.com/mobileapi/asset/notification/".$imageName;
            $image = $notificationImg;
        } else {
            $image = "";
        }

        if ($request['for'] == 1) { // 1 mean user
        
            $helper = new Helper(); 
            $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar");
            
            // $client = new Client();
            // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar");
            
        } elseif ($request['for'] == 2) { // 2 mean partner
        
            $helper = new Helper(); 
            $helper->firebaseGlobalNotificationSend($title, $body, $id=1, $image, $type=1, $token="quicar_owner");
            
            // $client = new Client();
            // $client->request("GET", "https://quicarbd.com/mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner");
        }

        return redirect()->back()->with('message','Send successfully');        
    }
    
}
