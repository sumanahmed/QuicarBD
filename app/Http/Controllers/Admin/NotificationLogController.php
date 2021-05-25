<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NotificationLogController extends Controller
{
    /**
     * show partner notification log
     */
    public function partnerNotification (Request $request) 
    {
        $query  = DB::table('owner_notification')
                    ->leftjoin('owners','owner_notification.owner_id','owners.id')
                    ->select('owner_notification.*','owners.name','owners.phone','owners.nid')
                    ->orderBy('owner_notification.id','DESC');
        
        if ($request->owner_id) {
            $query = $query->where('owner_notification.owner_id', $request->owner_id);
        }         
        
        if ($request->name) {
            $query = $query->where('owners.name', $request->name);
        }   
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }   
        
        if ($request->nid) {
            $query = $query->where('owners.nid', $request->nid);
        }   
        
        $notifications = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.notification-log.partner', compact('notifications'));
    }

    /**
     * show user notification log
     */
    public function userNotification (Request $request) 
    {
        $query  = DB::table('user_notification')
                    ->leftjoin('users','user_notification.user_id','users.id')
                    ->select('user_notification.*','users.name','users.phone','users.nid')
                    ->orderBy('user_notification.id','DESC');
        
        if ($request->user_id) {
            $query = $query->where('user_notification.user_id', $request->user_id);
        }         
        
        if ($request->name) {
            $query = $query->where('users.name', $request->name);
        }   
        
        if ($request->phone) {
            $query = $query->where('users.phone', $request->phone);
        }   
        
        if ($request->nid) {
            $query = $query->where('users.nid', $request->nid);
        }   
        
        $notifications = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.notification-log.user', compact('notifications'));
    }
}
