<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Jobs\SendSmsNotification;
use Illuminate\Http\Request;
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
                $client = new Client(); 
                $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar");
            } else { // 2 mean partner
                if (isset($request->account_type) && $request->account_type != null) {
                    $client = new Client();
                    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                } 
                
                if (isset($request->service_location_district) && $request->service_location_district != null) {
                     $client = new Client();
                    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner".$request->service_location_district);
                }
            }
        } elseif ($request->notification == 1) { //bell notification
        
            if($request['for'] == 1){ // 1 mean user
                $client = new Client(); 
                $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar");
            } else { // 2 mean partner
                if (isset($request->account_type) && $request->account_type != null) {
                    $client = new Client();
                    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                } 
                
                if (isset($request->service_location_district) && $request->service_location_district != null) {
                    $client = new Client();
                    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner".$request->service_location_district);
                }
            }
            
        } elseif ($request->notification == 2) { // sms & notification
        
            if($request['for'] == 1){ // 1 mean user
                $client = new Client(); 
                $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar");
                
                $users_phone = DB::table('users')->where('account_status', $request->status)->pluck('phone')->implode(', '); 
                
                $helper = new Helper(); 
                $helper->smsSend($users_phone, $body); // sms send
            } else { // 2 mean partner
                if (isset($request->account_type) && $request->account_type != null) {
                    $client = new Client();
                    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=account_type".$request->account_type);
                } 
                
                if (isset($request->service_location_district) && $request->service_location_district != null) {
                     $client = new Client();
                    $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner".$request->service_location_district);
                }
                
                $users_phone = DB::table('owners')->where('account_status', $request->status)->pluck('phone')->implode(', '); 
                
                $helper = new Helper(); 
                $helper->smsSend($users_phone, $body); // sms send
            }
        }
        
        return redirect()->back()->with('message','Send successfully');        
    }

    //show sms notification send page
    public function pushNotification(){
        $car_types = DB::table('car_types')->select('*')->get();
        $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
        $sms       = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
        return view('quicarbd.admin.sms-notification.push-notification', compact('car_types','districts','sms'));
    }
    
        //show sms notification send page
    public function globalNotification(){ 
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
            $client = new Client(); 
            $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar");
            
        } elseif ($request['for'] == 2) { // 2 mean partner
            $client = new Client();
            $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&image=".$image."&token=quicar_owner");
        } 

        return redirect()->back()->with('message','Send successfully');        
    }
}
