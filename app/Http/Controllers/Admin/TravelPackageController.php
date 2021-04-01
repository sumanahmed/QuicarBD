<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\HotelPackage;
use App\Models\City;
use App\Models\HotelAmenity;
use App\Models\Owner;
use App\Models\PropertyType;
use App\Models\TourSpot;
use App\Models\TravelPackage;

class TravelPackageController extends Controller
{
    /**
     * show hotel packages
     */
    public function index(Request $request){
        $query = TravelPackage::join('district','district.id','travel_packages.district_id')
                                ->select('district.value as district_name','travel_packages.*')
                                ->orderBy('id','DESC');

        if ($request->owner_id) {
            $query = $query->where('owner_id', $request->owner_id);
        }

        $travel_packages = $query->get();

        return view('quicarbd.admin.package.travel-package.index', compact('travel_packages'));
    }

    /**
     * show hotel packages create page
     */
    public function create(){
        $districts = District::all();
        $owners    = Owner::all();
        return view('quicarbd.admin.package.travel-package.create', compact('districts','owners'));
    }

    /**
     * travel packages store
     */
    public function store(Request $request)
    {   
        $this->validate($request,[
            'tour_name' => 'required',
            'organizer_name' => 'required',
            'organizer_phone' => 'required',
            'district_id' => 'required',
            //'spot_ids.*' => 'required',
            'starting_location' => 'required',
            'starting_city_id' => 'required',
            'starting_address' => 'required',
            'day_night' => 'required',
            'total_person' => 'required',
            'cost_per_person' => 'required',
            'owner_get_per_person' => 'required',
            'quicar_charge' => 'required',
            'travel_starting_date' => 'required',
            'travel_starting_date_timestamp' => 'required',
            'details' => 'required',
            //'facilities' => 'required',
            'term_and_condition' => 'required',            
            'owner_id' => 'required',
            'status' => 'required',
        ]); 

        $travel_package                      = new TravelPackage();
        $travel_package->tour_name           = $request->tour_name;
        $travel_package->organizer_name      = $request->organizer_name;
        $travel_package->organizer_phone     = $request->organizer_phone;
        $travel_package->district_id         = $request->district_id;
        $travel_package->spot_ids            = json_encode($request->spot_ids);
        $travel_package->starting_location   = $request->starting_location;
        $travel_package->starting_city_id    = $request->starting_city_id;
        $travel_package->starting_address    = $request->starting_address;
        $travel_package->day_night           = $request->day_night;
        $travel_package->total_person        = $request->total_person;
        $travel_package->cost_per_person     = $request->cost_per_person;
        $travel_package->owner_get_per_person= $request->owner_get_per_person;
        $travel_package->quicar_charge       = $request->quicar_charge;
        $travel_package->cash_back_price    = isset($request->cash_back_price) ? $request->cash_back_price : 0;
        $travel_package->cash_back_status   = isset($request->cash_back_status) ? $request->cash_back_status : 0;
        $travel_package->cash_back_staring_time = isset($request->cash_back_staring_time) ? $request->cash_back_staring_time : Null;
        $travel_package->cash_back_ending_time  = isset($request->cash_back_ending_time) ? $request->cash_back_ending_time : Null;
        $travel_package->referrel_code       = $request->referrel_code;
        $travel_package->travel_starting_date= $request->travel_starting_date;
        $travel_package->travel_starting_date_timestamp        = $request->travel_starting_date_timestamp;
        $travel_package->details             = $request->details;
        $travel_package->details             = $request->details;
        $travel_package->facilities          = $request->facilities; 
        $travel_package->term_and_condition  = $request->term_and_condition;
        $travel_package->owner_id            = $request->owner_id;
        $travel_package->status              = $request->status;
        $travel_package->status_message      = $request->status_message;
        $travel_package->travel_package_rating= isset($request->travel_package_rating) ? $request->travel_package_rating : 0.0;
        if($travel_package->save()){
            return redirect()->route('travel_package.index')->with('message','Travel package added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }
    
    /**
     * show hotel packages edit page
     */
    public function edit($id){
        $travel_package = TravelPackage::find($id);
        $spots          = TourSpot::where('district_id', $travel_package->district_id)->get();
        $districts      = District::all();
        $starting_cities= City::where('district_id', $travel_package->starting_location)->get();
        $owners         = Owner::all();
        $charge         = Owner::find($travel_package->owner_id)->travel_package_charge;
        return view('quicarbd.admin.package.travel-package.edit', compact('travel_package','spots','districts','starting_cities','owners','charge'));
    }
    
    /**
     * travel packages store
     */
    public function update(Request $request, $id)
    {  
        $this->validate($request,[
            'tour_name' => 'required',
            'organizer_name' => 'required',
            'organizer_phone' => 'required',
            'district_id' => 'required',
            //'spot_ids.*' => 'required',
            'starting_location' => 'required',
            'starting_city_id' => 'required',
            'starting_address' => 'required',
            'day_night' => 'required',
            'total_person' => 'required',
            'cost_per_person' => 'required',
            'owner_get_per_person' => 'required',
            'quicar_charge' => 'required',
            'travel_starting_date' => 'required',
            'travel_starting_date_timestamp' => 'required',
            'details' => 'required',
            //'facilities' => 'required',
            'term_and_condition' => 'required',            
            'owner_id' => 'required',
            'status' => 'required',
        ]); 

        $travel_package                     = TravelPackage::find($id);
        $travel_package->tour_name           = $request->tour_name;
        $travel_package->organizer_name      = $request->organizer_name;
        $travel_package->organizer_phone     = $request->organizer_phone;
        $travel_package->district_id         = $request->district_id;
        $travel_package->spot_ids            = json_encode($request->spot_ids);
        $travel_package->starting_location   = $request->starting_location;
        $travel_package->starting_city_id    = $request->starting_city_id;
        $travel_package->starting_address    = $request->starting_address;
        $travel_package->day_night           = $request->day_night;
        $travel_package->total_person        = $request->total_person;
        $travel_package->cost_per_person     = $request->cost_per_person;
        $travel_package->owner_get_per_person= $request->owner_get_per_person;
        $travel_package->quicar_charge       = $request->quicar_charge;
        $travel_package->cash_back_price    = isset($request->cash_back_price) ? $request->cash_back_price : 0;
        $travel_package->cash_back_status   = isset($request->cash_back_status) ? $request->cash_back_status : 0;
        $travel_package->cash_back_staring_time = isset($request->cash_back_staring_time) ? $request->cash_back_staring_time : Null;
        $travel_package->cash_back_ending_time  = isset($request->cash_back_ending_time) ? $request->cash_back_ending_time : Null;
        $travel_package->referrel_code       = $request->referrel_code;
        $travel_package->travel_starting_date= $request->travel_starting_date;
        $travel_package->travel_starting_date_timestamp        = $request->travel_starting_date_timestamp;
        $travel_package->details             = $request->details;
        $travel_package->details             = $request->details;
        $travel_package->facilities          = $request->facilities; 
        $travel_package->term_and_condition  = $request->term_and_condition;
        $travel_package->owner_id            = $request->owner_id;
        $travel_package->status              = $request->status;
        $travel_package->status_message      = $request->status_message;
        $travel_package->travel_package_rating= isset($request->travel_package_rating) ? $request->travel_package_rating : 0.0;
        if($travel_package->update()){
            return redirect()->route('travel_package.index')->with('message','Travel package updated successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    /**
     * delete hotel package
     */
    public function destroy(Request $request){
        TravelPackage::find($request->id)->delete();
        return redirect()->route('travel_package.index')->with('message','Travel package deleted successfully');
    }
}
