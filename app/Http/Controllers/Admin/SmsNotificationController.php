<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use Illuminate\Http\Request;
use Validator;
use App\Models\Owner;
use App\Models\User;

class SmsNotificationController extends Controller
{
    //show sms notification send page
    public function index(){
        return view('quicarbd.admin.sms-notification.index');
    }

    //send sms notification
    public function send(Request $request){

        $this->validate($request,[
            'for'   => 'required',
            'status'   => 'required',
            'title'   => 'required',
            'message' => 'required',
            'notification' => 'required',
        ]);

        $helper = new Helper(); 

        if($request->for == 1){
            $users = User::where('account_status', $request->status)->get();                             
            foreach($users as $user){
                if($request->notification == 1){
                    $helper->sendSinglePartnerNotification($user->n_key, $request->title, $request->message); //push notification send
                }else{
                    $helper->sendSinglePartnerNotification($user->n_key, $request->title, $request->message); //push notification send
                    $helper->smsSend($user->phone, $request->message); // sms send
                }
            }
        }else{
            $owners = Owner::where('account_status', $request->status)->get();
            foreach($owners as $owner){
                if($request->notification == 1){                 
                    $this->sendSinglePartnerNotification($owner->n_key, $request->title, $request->message);
                }else{
                    $helper->sendSinglePartnerNotification($owner->n_key, $request->title, $request->message); //push notification send
                    $helper->smsSend($owner->phone, $request->message); // sms send                   
                }                
            }
        }   
        return redirect()->back()->with('message','Send successfully');
    }
}
