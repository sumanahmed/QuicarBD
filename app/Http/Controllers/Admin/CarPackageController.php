<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarPackage;
use App\Models\District;
use App\Models\Owner;
use App\Models\TourSpot;
use Illuminate\Http\Request;

class CarPackageController extends Controller
{
     /**
     * show car packages
     */
    public function index(){
        $car_packages = CarPackage::join('district','district.id','car_packages.district_id')
                                ->select('car_packages.*','district.value as district_name')
                                ->get();
        return view('quicarbd.admin.package.car-package.index', compact('car_packages'));
    }

    /**
     * show car packages create page
     */
    public function create(){
        $districts  = District::orderBy('id','ASC')->get();
        $partners   = Owner::all();
        return view('quicarbd.admin.package.car-package.create', compact('districts','partners'));
    }

    /**
     * car packages store
     */
    public function store(Request $request){
        $car_packge                     = new CarPackage();
        $car_packge->name               = $request->name;
        $car_packge->details            = $request->details;
        $car_packge->district_id        = $request->district_id;
        $car_packge->spot_id            = json_encode($request->spot_id);
        $car_packge->starting_location          = $request->starting_location;
        $car_packge->starting_location_address  = $request->starting_location_address;
        $car_packge->owner_id           = $request->owner_id;
        $car_packge->duration           = $request->duration;
        $car_packge->total_person       = $request->total_person;
        $car_packge->facilities         = $request->facilities;
        $car_packge->price              = $request->price;
        $car_packge->cash_back_price    = $request->cash_back_price;
        $car_packge->cash_back_status   = $request->cash_back_status;
        $car_packge->cash_back_staring_time = $request->cash_back_staring_time;
        $car_packge->cash_back_ending_time  = $request->cash_back_ending_time;
        $car_packge->cash_back_ending_time  = $request->cash_back_ending_time;
        $car_packge->status             = $request->status;
        $car_packge->package_status     = $request->package_status;
        $car_packge->status_message     = $request->status_message;
        $car_packge->owner_get          = $request->owner_get;
        $car_packge->car_id             = $request->car_id;
        $car_packge->quicar_charge      = $request->quicar_charge;
        $car_packge->terms_condition    = $request->terms_condition;
        if($car_packge->save()){
            return redirect()->route('car_package.index')->with('message','Car package added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }
    
    /**
     * show car packages edit page
     */
    public function edit($id){
        $car_package= CarPackage::find($id);
        $districts  = District::all();
        $partners   = Owner::all();
        $spots      = TourSpot::select('id','name')->where('district_id',$car_package->district_id)->get();
        $cars       = Car::select('id','carRegisterNumber')->where('owner_id',$car_package->owner_id)->where('status', 1)->get();
        return view('quicarbd.admin.package.car-package.edit', compact('car_package','districts','partners','spots','cars'));
    }

    
    /**
     * car packages store
     */
    public function update(Request $request, $id){
        $car_packge                     = CarPackage::find($id);
        $car_packge->name               = $request->name;
        $car_packge->details            = $request->details;
        $car_packge->district_id        = $request->district_id;
        $car_packge->spot_id            = json_encode($request->spot_id);
        $car_packge->starting_location          = $request->starting_location;
        $car_packge->starting_location_address  = $request->starting_location_address;
        $car_packge->owner_id           = $request->owner_id;
        $car_packge->duration           = $request->duration;
        $car_packge->total_person       = $request->total_person;
        $car_packge->facilities         = $request->facilities;
        $car_packge->price              = $request->price;
        $car_packge->cash_back_price    = $request->cash_back_price;
        $car_packge->cash_back_status   = $request->cash_back_status;
        $car_packge->cash_back_staring_time = $request->cash_back_staring_time;
        $car_packge->cash_back_ending_time  = $request->cash_back_ending_time;
        $car_packge->cash_back_ending_time  = $request->cash_back_ending_time;
        $car_packge->status             = $request->status;
        $car_packge->package_status     = $request->package_status;
        $car_packge->status_message     = $request->status_message;
        $car_packge->owner_get          = $request->owner_get;
        $car_packge->car_id             = $request->car_id;
        $car_packge->quicar_charge      = $request->quicar_charge;
        $car_packge->terms_condition    = $request->terms_condition;
        if($car_packge->save()){
            return redirect()->route('car_package.index')->with('message','Car package updated successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    /**
     * delete car package
     */
    public function destroy(Request $request){
        CarPackage::find($request->id)->delete();
        return redirect()->route('car_package.index')->with('message','Car package deleted successfully');
    }
}
