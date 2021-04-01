<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Jobs\SendSmsNotification;
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


        $details = [
    		'for'   => $request->for,
            'status'   => $request->status,
            'title'   => $request->title,
            'message' => $request->message,
            'notification' => $request->notification,
    	];
    	
    	// send all mail in the queue.
        $job = (new SendSmsNotification($details))
            ->delay(
            	now()
            	->addSeconds(2)
            ); 

        dispatch($job);

        return redirect()->back()->with('message','Send successfully');
        
    }

    //show sms notification send page
    public function pushNotification(){
        return view('quicarbd.admin.sms-notification.push-notification');
    }

    //send sms notification
    public function pushNotificationSend(Request $request){

        $this->validate($request,[
            'for'   => 'required',
            'status'   => 'required',
            'title'   => 'required',
            'message' => 'required'
        ]);

        $details = [
    		'for'   => $request->for,
            'status'   => $request->status,
            'title'   => $request->title,
            'message' => $request->message,
            'notification' => 0,
    	];
    	
    	// send all mail in the queue.
        $job = (new SendSmsNotification($details))
            ->delay(
            	now()
            	->addSeconds(2)
            ); 

        dispatch($job);

        return redirect()->back()->with('message','Send successfully');
        
    }
}
