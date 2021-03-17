<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use DB;

class PackageReviewController extends Controller
{
    /**
     * show package review
     */
    public function index (Request $request) { 
        $review_to = $request->review_to; 

        if ($review_to == 0) { //0 mean car package review
            $reviews = DB::table('feedback')
                            ->leftjoin('users','feedback.user_id','users.id')
                            ->leftjoin('owners','feedback.owner_id','owners.id')
                            ->leftjoin('car_packages','feedback.history_id','car_packages.id')
                            ->select('feedback.id','feedback.review',
                                'owners.name as owner_name','owners.phone as owner_phone',
                                'users.name as user_name', 'users.phone as user_phone',
                                'car_packages.name as name'
                            )
                            ->where('feedback.review_to', $request->review_to)
                            ->where('feedback.history_id', $request->id) //id mean car package_id
                            ->orderBy('feedback.id','DESC')
                            ->get();
        } else if ($review_to == 1) { //1 mean hotel package review
            $reviews = DB::table('feedback')
                            ->leftjoin('users','feedback.user_id','users.id')
                            ->leftjoin('owners','feedback.owner_id','owners.id')
                            ->leftjoin('hotel_packages','feedback.history_id','hotel_packages.id')
                            ->select('feedback.id','feedback.review',
                                'owners.name as owner_name','owners.phone as owner_phone',
                                'users.name as user_name', 'users.phone as user_phone',
                                'hotel_packages.hotel_name as name'
                            )
                            ->where('feedback.review_to', $request->review_to)
                            ->where('feedback.history_id', $request->id) //id mean hotel package_id
                            ->orderBy('feedback.id','DESC')
                            ->get();
        } else if ($review_to == 1) { //1 mean hotel package review
            $reviews = DB::table('feedback')
                            ->leftjoin('users','feedback.user_id','users.id')
                            ->leftjoin('owners','feedback.owner_id','owners.id')
                            ->leftjoin('hotel_packages','feedback.history_id','hotel_packages.id')
                            ->select('feedback.id','feedback.review',
                                'owners.name as owner_name','owners.phone as owner_phone',
                                'users.name as user_name', 'users.phone as user_phone',
                                'hotel_packages.hotel_name as name'
                            )
                            ->where('feedback.review_to', $request->review_to)
                            ->where('feedback.history_id', $request->id) //id mean travel package_id
                            ->orderBy('feedback.id','DESC')
                            ->get();
        } else if ($review_to == 2) { //2 mean travel package review
            $reviews = DB::table('feedback')
                            ->leftjoin('users','feedback.user_id','users.id')
                            ->leftjoin('owners','feedback.owner_id','owners.id')
                            ->leftjoin('travel_packages','feedback.history_id','travel_packages.id')
                            ->select('feedback.id','feedback.review',
                                'owners.name as owner_name','owners.phone as owner_phone',
                                'users.name as user_name', 'users.phone as user_phone',
                                'travel_packages.tour_name as name'
                            )
                            ->where('feedback.review_to', $request->review_to)
                            ->orderBy('feedback.id','DESC')
                            ->get();
        } else if ($review_to == 4) { //4 mean ride
            $reviews = DB::table('feedback')
                            ->leftjoin('users','feedback.user_id','users.id')
                            ->leftjoin('owners','feedback.owner_id','owners.id')
                            ->leftjoin('travel_packages','feedback.history_id','travel_packages.id')
                            ->select('feedback.id','feedback.review',
                                'owners.name as owner_name','owners.phone as owner_phone',
                                'users.name as user_name', 'users.phone as user_phone',
                                'travel_packages.tour_name as name'
                            )
                            ->where('feedback.review_to', $request->review_to)
                            ->orderBy('feedback.id','DESC')
                            ->get();
        }
        
        return view('quicarbd.admin.package.review',compact('reviews','review_to'));
    }
}
