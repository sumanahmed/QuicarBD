<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\District;
use App\Models\City;

class PartnerController extends Controller
{
     //show all partner
     public function index(){
        $partners = Owner::orderBy('id','DESC')->get();
        return view('quicarbd.admin.partner.index', compact('partners'));
    }

    //show create page
    public function create(){
        $districts  = District::orderBy('value','ASC')->get(); 
        return view('quicarbd.admin.partner.create', compact('districts'));
    }

    //car store
    public function store(Request $request){ 
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'dob'       => 'required',
            'nid'       => 'required',
            'district'  => 'required',
            'city'      => 'required',
            'area'      => 'required',
            'account_type'          => 'required',
            'bidding_percent'       => 'required',
            'car_package_charge'    => 'required',
            'hotel_package_charge'  => 'required',
            'travel_package_charge' => 'required',
            'service_location_district' => 'required',
            'service_location_city'     => 'required',
        ]);

        $owner              = new Owner();
        $owner->name        = $request->name;
        $owner->email       = $request->email;
        $owner->phone       = $request->phone;
        $owner->account_type= $request->account_type;
        $owner->dob         = $request->dob;
        $owner->nid         = $request->nid;
        $owner->c_lat       = 0.0000;
        $owner->c_lon       = 0.0000;
        $owner->n_key       = 0.0000;
        $owner->service_location_district  = District::find($request->service_location_district)->value;
        $owner->service_location_city      = $request->service_location_city;
        $owner->district    = District::find($request->district)->value;
        $owner->city        = $request->city;
        $owner->area        = $request->area;
        $owner->bidding_percent         = $request->bidding_percent;
        $owner->car_package_charge      = $request->car_package_charge;
        $owner->hotel_package_charge    = $request->hotel_package_charge;
        $owner->travel_package_charge   = $request->travel_package_charge;
        if($request->hasFile('img')){
            $image      = $request->file('img');
            $imageName  = time().".".$image->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/owner/';
            $image->move($directory, $imageName);
            $imageUrl   = $directory.$imageName;
            $owner->img = $imageUrl;
        }
        if($request->hasFile('nid_font_pic')){
            $nidFont      = $request->file('nid_font_pic');
            $nidFontName  = "nidFont".time().".".$nidFont->getClientOriginalExtension();
            $directory    = '../mobileapi/asset/owner/';
            $nidFont->move($directory, $nidFontName);
            $nidFontUrl   = $directory.$nidFontName;
            $owner->nid_font_pic = $nidFontUrl;
        }
        if($request->hasFile('nid_back_pic')){
            $nidBack      = $request->file('nid_back_pic');
            $nidBackName  = "nidBack".time().".".$nidBack->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/owner/';
            $nidBack->move($directory, $nidBackName);
            $nidBackUrl   = $directory.$nidBackName;
            $owner->nid_back_pic = $nidBackUrl;
        }

        if($owner->save()) {
            return redirect()->route('partner.index')->with('message', 'Partner created successfully');
        }else{
            return redirect()->back()->with('error_message', 'Sorry something went wrong');
        }
    }

    //show edit page
    public function edit($id){
        $partner    = Owner::find($id);
        $districts  = District::orderBy('value','ASC')->get();
        $citys      = City::where('name', $partner->district)->get();
        $service_citys      = City::where('name', $partner->service_location_district)->get();
        return view('quicarbd.admin.partner.edit', compact('partner','districts','citys', 'service_citys'));
    }

    //car update
    public function update(Request $request, $id){ 
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'dob'       => 'required',
            'nid'       => 'required',
            'district'  => 'required',
            'city'      => 'required',
            'area'      => 'required',
            'account_type'          => 'required',
            'bidding_percent'       => 'required',
            'car_package_charge'    => 'required',
            'hotel_package_charge'  => 'required',
            'travel_package_charge' => 'required',
            'service_location_district' => 'required',
            'service_location_city'     => 'required',
        ]);
        
        $owner              = Owner::find($id);
        $owner->name        = $request->name;
        $owner->email       = $request->email;
        $owner->phone       = $request->phone;
        $owner->account_type= $request->account_type;
        $owner->dob         = $request->dob;
        $owner->nid         = $request->nid;
        $owner->c_lat       = 0.0000;
        $owner->c_lon       = 0.0000;
        $owner->n_key       = 0.0000;
        $owner->service_location_district  = District::find($request->service_location_district)->value;
        $owner->service_location_city      = $request->service_location_city;
        $owner->district    = District::find($request->district)->value;
        $owner->city        = $request->city;
        $owner->area        = $request->area;
        $owner->bidding_percent         = $request->bidding_percent;
        $owner->car_package_charge      = $request->car_package_charge;
        $owner->hotel_package_charge    = $request->hotel_package_charge;
        $owner->travel_package_charge   = $request->travel_package_charge;
        if($request->hasFile('img')){
            if(($owner->img != null) && file_exists($owner->img)){
                unlink($owner->img);
            }
            $image      = $request->file('img');
            $imageName  = time().".".$image->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/owner/';
            $image->move($directory, $imageName);
            $imageUrl   = $directory.$imageName;
            $owner->img = $imageUrl;
        }
        if($request->hasFile('nid_font_pic')){
            if(($owner->nid_font_pic != null) && file_exists($owner->nid_font_pic)){
                unlink($owner->nid_font_pic);
            }
            $nidFont      = $request->file('nid_font_pic');
            $nidFontName  = "nidFont".time().".".$nidFont->getClientOriginalExtension();
            $directory    = '../mobileapi/asset/owner/';
            $nidFont->move($directory, $nidFontName);
            $nidFontUrl   = $directory.$nidFontName;
            $owner->nid_font_pic = $nidFontUrl;
        }
        if($request->hasFile('nid_back_pic')){
            if(($owner->nid_back_pic != null) && file_exists($owner->nid_back_pic)){
                unlink($owner->nid_back_pic);
            }
            $nidBack      = $request->file('nid_back_pic');
            $nidBackName  = "nidBack".time().".".$nidBack->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/owner/';
            $nidBack->move($directory, $nidBackName);
            $nidBackUrl   = $directory.$nidBackName;
            $owner->nid_back_pic = $nidBackUrl;
        }
        if($owner->update()){
            return redirect()->route('partner.index')->with('message','Partner update successfully');
        }else{
            return redirect()->route('partner.index')->with('error_message','Sorry, something went wrong');
        }
    }

    //car details
    public function details($id){
        $car = Car::find($id);
        $owners     = Owner::all();
        return view('quicarbd.admin.car.details', compact('car','owners'));
    }
}
