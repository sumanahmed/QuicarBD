<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RideList;
use Illuminate\Http\Request;
use DB;

class RideController extends Controller
{
  /**
    * show bid request
  */
  public function bidRequest(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.startig_area', 'ride_list.destination_area','ride_list.payment_status',
                        'users.name as user_name','users.phone as user_phone')
                ->where('ride_list.status', 1)
                ->orderBy('ride_list.id','DESC')
                ->get();
                        
    return view('quicarbd.admin.ride.bid_request', compact('rides'));
  }
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
                ->orderBy('ride_list.id','DESC')
                ->get();
                        
    return view('quicarbd.admin.ride.upcoming', compact('rides'));
  }

  /**
    * show ongoing rides
  */
  public function ongoing(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.startig_area', 'ride_list.destination_area','ride_list.payment_status',
                        'users.name as user_name','users.phone as user_phone')
                ->where('ride_list.status', 3)
                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                ->orderBy('ride_list.id','DESC')
                ->get();
                        
    return view('quicarbd.admin.ride.ongoing', compact('rides'));
  }

  /**
    * show complete rides
  */
  public function complete(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.startig_area', 'ride_list.destination_area','ride_list.payment_status',
                        'users.name as user_name','users.phone as user_phone')
                ->where('ride_list.status', 5)
                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                ->orderBy('ride_list.id','DESC')
                ->get();
                        
    return view('quicarbd.admin.ride.complete', compact('rides'));
  }

  /**
    * show cancel rides
  */
  public function cancel(){
    $rides = DB::table('ride_list')
                ->join('users','ride_list.user_id','users.id')
                ->select('ride_list.id','ride_list.startig_area', 'ride_list.destination_area','ride_list.payment_status',
                        'users.name as user_name','users.phone as user_phone')
                ->where('ride_list.status', 2)
                ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                ->orderBy('ride_list.id','DESC')
                ->get();
                        
    return view('quicarbd.admin.ride.cancel', compact('rides'));
  }

  /**
    * show upcoming bid rides
  */
  public function bidding($id){
      $biddings = DB::table('ride_biting')
                  ->join('cars','ride_biting.car_id','cars.id')
                  ->join('owners','ride_biting.owner_id','owners.id')
                  ->join('drivers','ride_biting.driver_id','drivers.id')
                  ->select('drivers.name as driver_name','drivers.phone as driver_phone',
                          'ride_biting.*','owners.name as owner_name','owners.phone as owner_phone',
                          'cars.carRegisterNumber')
                  ->where('ride_biting.ride_id', $id)
                  ->orderBy('ride_biting.id','DESC')
                  ->get();
                          
      return view('quicarbd.admin.ride.bidding', compact('biddings'));
  }

  /**
    * show ride details
  */
  public function details($ride_id){
      $ride = RideList::find($ride_id);                          
      return view('quicarbd.admin.ride.details', compact('ride'));
  }
}
