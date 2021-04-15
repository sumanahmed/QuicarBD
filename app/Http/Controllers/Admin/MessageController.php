<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OwnerMessageList;
use App\Http\Lib\Helper;
use Response;
use DB;

class MessageController extends Controller
{
    // show all partner message
    public function partnerMessage (Request $request) 
    {
        $query = DB::table('owner_message_list')
                    ->leftjoin('owners','owner_message_list.sender_id','owners.id')
                    ->select('owners.name','owners.phone','owners.n_key','owner_message_list.*')
                    ->where('owner_message_list.type', 0)
                    ->orderBy('owners.id','DESC');

        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        $partners = $query->paginate(12);
        
        return view('quicarbd.admin.message.partner', compact('partners'));
    }
    
    // show all user message
    public function userMessage (Request $request) 
    {
        $query = DB::table('owner_message_list')
                    ->leftjoin('users','owner_message_list.sender_id','users.id')
                    ->select('users.name','users.phone','users.n_key','owner_message_list.*')
                    ->where('owner_message_list.type', 1)
                    ->orderBy('users.id','DESC');

        if ($request->name) {
            $query = $query->where('users.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('users.phone', $request->phone);
        }
        
        $users = $query->paginate(12);
        
        return view('quicarbd.admin.message.user', compact('users'));
    }
    
    // message reply
    public function reply (Request $request) 
    {  
        $helper = new Helper();
        $title = "Message Reply";
        $msg   = $request->reply;
        
        if ($request->type == 1) { //user
            $helper->smsNotification($type = 1, $request->sender_id, $title, $msg); // send notification, 1=user
        } else {
            $helper->smsNotification($type = 2, $request->sender_id, $title, $msg); // send notification, 2=partner
        }
        
        $message = OwnerMessageList::find($request->id);
        $message->status    = 1;
        $message->reply_message     = $request->reply;
        $message->update();
        
        return Response::json([
            'status'    => 201,
            'data'      => $message
        ]);
    }
}
