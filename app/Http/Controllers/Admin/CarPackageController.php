<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\Car;
use App\Models\CarPackage;
use App\Models\City;
use App\Models\District;
use App\Models\Owner;
use App\Models\TourSpot;
use Illuminate\Http\Request;
use DB;

class CarPackageController extends Controller
{
     /**
     * show car packages
     */
    public function index(Request $request){
        $query = CarPackage::join('district','district.id','car_packages.district_id')
                            ->select('car_packages.*','district.value as district_name');

        if ($request->owner_id) {
            $query = $query->where('owner_id', $request->owner_id);
        }

        $car_packages = $query->get();
        return view('quicarbd.admin.package.car-package.index', compact('car_packages'));
    }

    /**
     * show car packages create page
     */
    public function create(){
        $districts  = District::orderBy('id','ASC')->get();
        $partners   = Owner::where('account_status', 1)->get();
        return view('quicarbd.admin.package.car-package.create', compact('districts','partners'));
    }

    /**
     * car packages store
     */
    public function store(Request $request){
        $this->validate($request,[
            'name'          => 'required',
            'details'       => 'required',
            'district_id'   => 'required',
            'spot_id'       => 'required',
            'starting_location' => 'required',
            'starting_city_id'  => 'required',
            'starting_location_address' => 'required',
            'owner_id'      => 'required',
            'duration'      => 'required',
            'total_person'  => 'required',
            'facilities'    => 'required',
            'price'         => 'required',
            'status'        => 'required',
            'package_status'=> 'required',
            'status_message'=> 'required',
            'owner_get'     => 'required',
            'car_id'        => 'required',
            'quicar_charge' => 'required',
            'terms_condition'=> 'required',
        ]);

        $car_packge                     = new CarPackage();
        $car_packge->name               = $request->name;
        $car_packge->details            = $request->details;
        $car_packge->district_id        = $request->district_id;
        $car_packge->spot_id            = json_encode($request->spot_id);
        $car_packge->starting_location  = $request->starting_location;
        $car_packge->starting_city_id   = $request->starting_city_id;
        $car_packge->starting_location_address  = $request->starting_location_address;
        $car_packge->owner_id           = $request->owner_id;
        $car_packge->duration           = $request->duration;
        $car_packge->total_person       = $request->total_person;
        $car_packge->facilities         = $request->facilities;
        $car_packge->price              = $request->price;
        $car_packge->cash_back_price    = isset($request->cash_back_price) ? $request->cash_back_price : 0;
        $car_packge->cash_back_status   = isset($request->cash_back_status) ? $request->cash_back_status : 0;
        $car_packge->cash_back_staring_time = isset($request->cash_back_staring_time) ? $request->cash_back_staring_time : Null;
        $car_packge->cash_back_ending_time  = isset($request->cash_back_ending_time) ? $request->cash_back_ending_time : Null;
        $car_packge->status             = $request->status;
        $car_packge->package_status     = $request->package_status;
        $car_packge->status_message     = $request->status_message;
        $car_packge->owner_get          = $request->owner_get;
        $car_packge->car_id             = $request->car_id;
        $car_packge->quicar_charge      = $request->quicar_charge;
        $car_packge->terms_condition    = $request->terms_condition;
        
        if ($request->package_status == 1) {

            $helper = new Helper(); 
            $owner  = Owner::select('id','phone','name','n_key')->where('id', $request->owner_id)->first();
            $id     = $owner->n_key;
            $title  = 'Package Approved';            
            $msg    = 'Dear '.$owner->name.', your car package ('.$car_packge->name.') approved successfully. Thanks for connecting with Quicar';                        

            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($owner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner
        }

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
        $partners   = Owner::where('account_status', 1)->get();
        $spots      = TourSpot::select('id','name')->where('district_id',$car_package->district_id)->get();
        $cars       = Car::select('id','carRegisterNumber')->where('owner_id',$car_package->owner_id)->where('status', 1)->get();
        $starting_cities= City::where('district_id', $car_package->starting_location)->get();
        $charge    = Owner::find($car_package->owner_id)->car_package_charge;
        return view('quicarbd.admin.package.car-package.edit', compact('car_package','districts','partners','spots','cars','starting_cities','charge'));
    }
    
    /**
     * show car packages edit page
     */
    public function details($id){
        $car_package= CarPackage::find($id);
        $partner    = Owner::find($car_package->owner_id)->name;
        $district   = District::find($car_package->district_id)->value;
        $spots      = TourSpot::select('id','name')->where('district_id',$car_package->district_id)->get();
        $cars       = Car::select('id','carRegisterNumber')->where('owner_id',$car_package->owner_id)->where('status', 1)->get();
        $starting_location  = District::find($car_package->starting_location)->value;
        $starting_city    = City::find($car_package->starting_city_id)->name;
        $charge    = Owner::find($car_package->owner_id)->car_package_charge;
        return view('quicarbd.admin.package.car-package.details', compact('car_package','district','partner','spots','cars','starting_location','starting_city','charge'));
    }
        
    /**
     * car packages store
     */
    public function update(Request $request, $id){
        $this->validate($request,[
            'name'          => 'required',
            'details'       => 'required',
            'district_id'   => 'required',
            'spot_id'       => 'required',
            'starting_location' => 'required',
            'starting_city_id'  => 'required',
            'starting_location_address' => 'required',
            'owner_id'      => 'required',
            'duration'      => 'required',
            'total_person'  => 'required',
            'facilities'    => 'required',
            'price'         => 'required',
            'status'        => 'required',
            'package_status'=> 'required',
            'status_message'=> 'required',
            'owner_get'     => 'required',
            'car_id'        => 'required',
            'quicar_charge' => 'required',
            'terms_condition'=> 'required',
        ]);

        $car_packge                     = CarPackage::find($id);
        $car_packge->name               = $request->name;
        $car_packge->details            = $request->details;
        $car_packge->district_id        = $request->district_id;
        $car_packge->spot_id            = json_encode($request->spot_id);
        $car_packge->starting_location  = $request->starting_location;
        $car_packge->starting_city_id   = $request->starting_city_id;
        $car_packge->starting_location_address  = $request->starting_location_address;
        $car_packge->owner_id           = $request->owner_id;
        $car_packge->duration           = $request->duration;
        $car_packge->total_person       = $request->total_person;
        $car_packge->facilities         = $request->facilities;
        $car_packge->price              = $request->price;
        $car_packge->cash_back_price    = isset($request->cash_back_price) ? $request->cash_back_price : 0;
        $car_packge->cash_back_status   = isset($request->cash_back_status) ? $request->cash_back_status : 0;
        $car_packge->cash_back_staring_time = isset($request->cash_back_staring_time) ? $request->cash_back_staring_time : Null;
        $car_packge->cash_back_ending_time  = isset($request->cash_back_ending_time) ? $request->cash_back_ending_time : Null;
        $car_packge->status             = $request->status;
        $car_packge->package_status     = $request->package_status;
        $car_packge->status_message     = $request->status_message;
        $car_packge->owner_get          = $request->owner_get;
        $car_packge->car_id             = $request->car_id;
        $car_packge->quicar_charge      = $request->quicar_charge;
        $car_packge->terms_condition    = $request->terms_condition;

        if ($request->package_status == 1) {

            $helper = new Helper(); 
            $owner  = Owner::select('id','phone','name','n_key')->where('id', $request->owner_id)->first();
            $id     = $owner->n_key;
            $title  = 'Package Approved';            
            $msg    = 'Dear '.$owner->name.', your car package ('.$car_packge->name.') approved successfully. Thanks for connecting with Quicar';                        

            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($owner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner
        }

        if($car_packge->update()){
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
