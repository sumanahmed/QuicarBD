<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\RideList;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\CarPackage;
use App\Models\HotelPackage;
use App\Models\TravelPackage;
use App\Models\SMS;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $sms   = SMS::select('id','title','message')->orderBy('id','DESC')->get();

        return view('quicarbd.admin.user.index', compact('users','sms'));
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
    
    //balance add
    public function balanceAdd(Request $request)
    {       
        $validators=Validator::make($request->all(),[
            'id'   => 'required',
            'balance' => 'required',
            'add_balance' => 'required',
            'n_key' => 'required',
        ]);
        
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }
        
        $user = User::find($request->id); 
        $user->balance = ($user->balance + $request->add_balance); 
        $user->update();

        $id      = $request->n_key;
        $title   = "New balance add";
        $body    = "New balance ". $request->add_balance ." with your current balance. Thanks Team Quicar";

        $helper = new Helper();
        $helper->sendSinglePartnerNotification($id, $title, $body); //push notification send
        
        return Response::json([
            'status'    => 200,
            'message'   => "Balance added successfully",
        ]);  
    }

    //user details
    public function details($id){
        $data['user']   = User::find($id);
        $data['rides']  = RideList::where('user_id', $id)->get();
        $data['total_ride'] = RideList::where('user_id', $id)->count('id');
        $data['total_car_pacakage_booking'] = DB::table('car_package_order')->where('user_id', $id)->count('id');
        $data['total_hotel_pacakage_booking'] = DB::table('hotel_package_order')->where('user_id', $id)->count('id');
        $data['total_travel_pacakage_booking'] = DB::table('travel_packages_order')->where('user_id', $id)->count('id');
        $data['accounts'] = DB::table('user_account')->where('user_id', $id)->orderBy('id','DESC')->get();
        return view('quicarbd.admin.user.details', $data);
    }
    
    //show all users
    public function userLogList(Request $request)
    {
        $query = DB::table('user_log')
                    ->join('users','user_log.user_id','users.id')
                    ->select('user_log.visit_time','users.id','users.n_key','users.name','users.phone')
                    ->distinct();

        if ($request->name) {
            $query = $query->where('users.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('users.phone', $request->phone);
        }
        
        if ($request->visit_date) { 
            $query = $query->whereDate('user_log.visit_time', date('Y-m-d', strtotime($request->visit_date)));
        }
        
        $users = $query->paginate(12);
        $sms   = SMS::select('id','title','message')->orderBy('id','DESC')->get();
        
        return view('quicarbd.admin.user.log-list', compact('users','sms'));
    }

    //user log
    public function log($id){
        $user_logs = DB::table('user_log')
                    ->leftjoin('users','user_log.user_id','users.id')
                    ->leftjoin('car_packages','user_log.product_id','car_packages.id')
                    ->leftjoin('hotel_packages','user_log.product_id','hotel_packages.id')
                    ->leftjoin('travel_packages','user_log.product_id','travel_packages.id')
                    ->select('user_log.*','users.name','users.phone',
                        DB::raw('(CASE 
                            WHEN user_log.product_type = "1" THEN car_packages.name 
                            WHEN user_log.product_type = "2" THEN hotel_packages.hotel_name
                            WHEN user_log.product_type = "3" THEN travel_packages.tour_name
                            ELSE "Others" 
                            END) as product_name'
                        )
                    )
                    ->where('user_log.user_id', $id)
                    ->orderBy('user_log.id','DESC');
        
        $logs = $user_logs->paginate(12);
        
        $user_name = User::find($id)->name;

        return view('quicarbd.admin.user.log', compact('logs','user_name'));
    }
}
