<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class RideController extends Controller
{
    /**
      * show upcoming bid rides
    */
     public function upcoming(){
        $rides = DB::table('ride_list')
                    ->join('users','ride_list.user_id','users.id')
                    ->select('ride_list.id','ride_list.startig_area', 'ride_list.destination_area','ride_list.payment_status',
                            'users.name as user_name','users.phone as user_phone')
                    ->where('ride_list.status', 4)
                    ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                    ->get();
                            
        return view('quicarbd.admin.ride.upcoming', compact('rides'));
    }

    /**
      * show upcoming bid rides
    */
    public function bidding($id){
        $biddings = DB::table('ride_biting')
                    ->where('ride_id', $id)
                    ->get();
                            
        return view('quicarbd.admin.ride.bidding', compact('biddings'));
    }
}
