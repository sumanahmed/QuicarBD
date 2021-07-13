<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportList;
use App\Models\User;
use App\Models\Owner;
use App\Http\Lib\Helper;
use Response;
use DB;

class ComplainController extends Controller
{
    // show all partner message
    public function partnerComplain (Request $request) 
    {
        $query = DB::table('report_list')
                    ->leftjoin('owners','report_list.sender_id','owners.id')
                    ->select('owners.name','owners.phone','owners.n_key','report_list.*')
                    ->where('report_list.senderType', 0)
                    ->orderBy('report_list.id','DESC');

        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        if (isset($request->status) && $request->status != 100) {
            $query = $query->where('owner_message_list.status', $request->status);
        }
        
        $complains = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.complain.partner', compact('complains'));
    }
    
    // show all user message
    public function userComplain (Request $request) 
    {
        $query = DB::table('report_list')
                    ->leftjoin('users','report_list.sender_id','users.id')
                    ->select('users.name','users.phone','users.n_key','report_list.*')
                    ->where('report_list.senderType', 1)
                    ->orderBy('report_list.id','DESC');

        if ($request->name) {
            $query = $query->where('users.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('users.phone', $request->phone);
        }
        
        if (isset($request->status) && $request->status != 100) {
            $query = $query->where('owner_message_list.status', $request->status);
        }
        
        $complains = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.complain.user', compact('complains'));
    }
    
    // message reply
    public function reply (Request $request) 
    {  
        $helper = new Helper();
        $title  = "You have a complain reply from quicar support";
        $msg    = "Complain : ".$request->complain."\nReply : ".$request->reply;

        if ($request->type == 1) { //user
            $id = User::find($request->sender_id)->n_key; 
            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notification send
            $helper->smsNotification($type = 1, $request->sender_id, $title, $msg); // send notification, 1=user
        } else {
            $id = Owner::find($request->sender_id)->n_key;
            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notification send
            $helper->smsNotification($type = 2, $request->sender_id, $title, $msg); // send notification, 2=partner
        }
        
        $complain                = ReportList::find($request->id);
        $complain->status        = 1;
        $complain->answer_give   = 1;
        $complain->reply_message = $request->reply;
        $complain->answer_time   = date('Y-m-d H:i:s');
        $complain->update();
        
        return Response::json([
            'status'    => 201,
            'data'      => $complain
        ]);
    }
}
