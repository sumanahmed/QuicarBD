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
        return view('quicarbd.admin.sms-notification.index', compact('car_types','districts'));
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

        if ($request->for == 2) {
            if ($request->category == 1) {
                $this->validate($request,[
                    'car'   => 'required'
                ]);
            }
    
            if ($request->category == 2) {
                $this->validate($request,[
                    'hotel'  => 'required'
                ]);
            }
    
            if ($request->category == 3) {
                $this->validate($request,[
                    'travel'  => 'required'
                ]);
            }
        }

        if($request['for'] == 1){ // 1 mean user
            $users = User::select('id','phone','n_key')
                        ->where('account_status', $request['status'])
                        ->get();
        } else { // 2 mean partner

            if ($request['category'] == 1) { // 1 mean category car

                if ($request['car'] == 1) { // all car account partner

                    if (isset($request['car_type_id'])) { 
                        $owners = Owner::select('owners.id','owners.phone','owners.n_key')
                                ->leftjoin('cars','owners.id','cars.owner_id')
                                ->where('owners.account_status', $request['status'])                                                                  
                                ->where(function ($query) {
                                    $query->where('owners.account_type', '=', 0)
                                          ->orWhere('owners.account_type', '=', 3)
                                          ->orWhere('owners.account_type', '=', 4)
                                          ->orWhere('owners.account_type', '=', 6);
                                })
                                ->where('cars.carType', $request['car_type_id'])
                                ->get(); 
                    } elseif (isset($request['service_location_district'])) {   
                        $owners = Owner::select('id','phone','n_key')
                                ->where('account_status', $request['status']) 
                                ->where('service_location_district', $request['service_location_district'])
                                ->get(); 
                    } else {
                        $owners = Owner::select('id','phone','n_key')
                                ->where('account_status', $request['status'])                                                                  
                                ->where(function ($query) {
                                    $query->where('account_type', '=', 0)
                                          ->orWhere('account_type', '=', 3)
                                          ->orWhere('account_type', '=', 4)
                                          ->orWhere('account_type', '=', 6);
                                })
                                ->get();
                    }

                } else if ($request['car'] == 2) { // no car 
                    $owners = Owner::leftjoin('cars','owners.id','cars.owner_id')
                                    ->select('owners.id','owners.phone','owners.n_key')
                                    ->where('owners.account_status', $request['status'])
                                    ->where('cars.owner_id', null)
                                    ->get();
                } else if ($request['car'] == 3) { // no driver
                    $owners = Owner::leftjoin('drivers','owners.id','drivers.owner_id')
                                    ->select('owners.id','owners.phone','owners.n_key')
                                    ->where('owners.account_status', $request['status'])
                                    ->where('drivers.owner_id', null)
                                    ->get();
                } else if ($request['car'] == 4) { // no package
                    $owners = Owner::leftjoin('car_packages','owners.id','car_packages.owner_id')
                                    ->select('owners.id','owners.phone','owners.n_key')
                                    ->where('owners.account_status', $request['status'])
                                    ->where('car_packages.owner_id', null)
                                    ->get();
                }
            } else if ($request['category'] == 2) { // 2 mean category hotel
                if ($request['hotel'] == 1) {
                    $owners = Owner::select('id','phone','n_key')
                                    ->where('account_status', $request['status'])
                                    ->where(function ($query) {
                                        $query->where('account_type', '=', 1)
                                              ->orWhere('account_type', '=', 3)
                                              ->orWhere('account_type', '=', 4)
                                              ->orWhere('account_type', '=', 5);
                                    })
                                    ->get();
                } else if ($request['hotel'] == 2) {                  
                    $owners = Owner::leftjoin('hotel_packages','owners.id','hotel_packages.owner_id')
                                    ->select('owners.id','owners.phone','owners.n_key')
                                    ->where('owners.account_status', $request['status'])
                                    ->where('hotel_packages.owner_id', null)
                                    ->get();
                }
            } else if ($request['category'] == 3) { // 3 mean category travel
                if ($request['travel'] == 1) {
                    $owners = Owner::select('id','phone','n_key')
                                    ->where('account_status', $request['status'])                                    
                                    ->where(function ($query) {
                                        $query->where('account_type', '=', 2)
                                              ->orWhere('account_type', '=', 4)
                                              ->orWhere('account_type', '=', 5)
                                              ->orWhere('account_type', '=', 6);
                                    })
                                    ->get();
                } else if ($request['travel'] == 2) {                  
                    $owners = Owner::leftjoin('travel_packages','owners.id','travel_packages.owner_id')
                                    ->select('owners.id','owners.phone','owners.n_key')
                                    ->where('owners.account_status', $request['status'])
                                    ->where('travel_packages.owner_id', null)
                                    ->get();
                }
            }
        }

        $details = [
    		'for'           => $request->for,
            'title'         => $request->title,
            'message'       => $request->message,
            'notification'  => $request->notification,
            'users'         => isset($users) ? $users : [],
            'owners'        => isset($owners) ? $owners : []
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
        $car_types = DB::table('car_types')->select('*')->get();
        $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
        return view('quicarbd.admin.sms-notification.push-notification', compact('car_types','districts'));
    }
    
        //show sms notification send page
    public function globalNotification(){ 
        return view('quicarbd.admin.sms-notification.global-notification');
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

        if ($request['for'] == 1) { // 1 mean user
            $client = new Client(); 
            $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar");
            
        } else { // 2 mean partner
            $client = new Client();
            $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$body."&type=1&token=quicar_owner");
        }

        return redirect()->back()->with('message','Send successfully');        
    }
}
