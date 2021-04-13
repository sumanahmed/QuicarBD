<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\RideList;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client;
use Validator;
use Response;
use DB;

class UserController extends Controller
{
    //show all users
    public function index(Request $request)
    {
        $query = DB::table('users')->select('*');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }
        
        $users = $query->paginate(12);

        return view('quicarbd.admin.user.index', compact('users'));
    }

    //status update
    public function statusUpdate(Request $request){ 
        $user                   = User::find($request->user_id);
        $user->account_status   = $request->status;
        $user->update();
        if($user->update()){
            return redirect()->back()->with('message', 'Status update successfully');
        }else{
            return redirect()->back()->with('error_message', 'Sorry something went wrong');
        }
    }

    //notification send
    public function notificationSend(Request $request)
    {         
        $validators=Validator::make($request->all(),[
            'title'   => 'required',
            'message' => 'required',
            'notification' => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{ 

            $id      = $request->n_key;
            $title   = $request->title;
            $body    = $request->message;

            $helper = new Helper();

            if($request->notification == 1){ 
                $helper->sendSinglePartnerNotification($id, $title, $body); //push notification send
                $helper->smsNotification($type = 1, $request->user_id, $title, $body); // bell notification, 1=user
                return Response::json([
                    'status'    => 200,
                    'message'   => "Notification send successfully",
                ]);
            }else{
                $helper->sendSinglePartnerNotification($id, $title, $body); //push notification send
                $helper->smsNotification($type = 1, $request->user_id, $title, $body); // bell notification, 1=user
                $helper->smsSend($request->phone, $body); // sms send
                return Response::json([
                    'status'    => 200,
                    'message'   => "Notification & SMS send successfully",
                ]);
            }            
        }        
    }

    //user details
    public function details($id){
        $data['user']   = User::find($id);
        $data['rides']  = RideList::where('user_id', $id)->get();
        $data['total_ride'] = RideList::where('user_id', $id)->count('id');
        $data['total_car_pacakage_booking'] = DB::table('car_package_order')->where('user_id', $id)->count('id');
        $data['total_hotel_pacakage_booking'] = DB::table('hotel_package_order')->where('user_id', $id)->count('id');
        $data['total_travel_pacakage_booking'] = DB::table('travel_packages_order')->where('user_id', $id)->count('id');
        return view('quicarbd.admin.user.details', $data);
    }
}
