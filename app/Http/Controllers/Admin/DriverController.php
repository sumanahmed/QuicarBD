<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Driver;
use App\Models\Owner;
use Illuminate\Http\Request;
use Validator;
use Response;

class DriverController extends Controller
{
    //show all drivers
    public function index(){
        $drivers    = Driver::all();
        return view('quicarbd.admin.driver.index', compact('drivers'));
    }

    //show create page
    public function create(){
        $owners     = Owner::select('id','name')->where('account_status', 1)->get();
        $districts  = District::orderBy('value','ASC')->get();       
        return view('quicarbd.admin.driver.create', compact('owners','districts'));
    }

    //show edit page
    public function edit($id){
        $driver     = Driver::find($id); 
        $owners     = Owner::select('id','name')->where('account_status', 1)->get();
        $districts  = District::orderBy('value','ASC')->get(); 
        $cities     = City::where('district_id', $driver->district_id)->get();
        return view('quicarbd.admin.driver.edit', compact('driver','owners','districts','cities'));
    }

    //driver store
    public function store(Request $request){ 
        $validators=Validator::make($request->all(),[
            'name'      => 'required',
            'phone'     => 'required',
            'dob'       => 'required',
            'owner_id'  => 'required',
            'nid'       => 'required',
            'district_id'=> 'required',
            'city_id'   => 'required',
            'address'   => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $driver             = new Driver();
            $driver->name       = $request->name;
            $driver->phone      = $request->phone;
            $driver->dob        = $request->dob;
            $driver->owner_id   = $request->owner_id;
            $driver->nid        = $request->nid;
            $driver->district_id= $request->district_id;
            $driver->city_id    = $request->city_id;
            $driver->license    = $request->license;  
            $driver->address    = $request->address;  
            if($request->driver_photo){
                $image          = $request->file('driver_photo');
                $image_name     = time().".".$image->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/driver_photo/';
                $image->move($directory, $image_name);
                $image_url      = $directory.$image_name;
                $driver->driver_photo    = $image_url;
            }
            if($request->nid_font_pic){
                $license        = $request->file('nid_font_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/nid/';
                $license->move($directory, $license_name);
                $nid_front_url    = $directory.$license_name;
                $driver->nid_font_pic= $nid_front_url;
            }
            if($request->nid_back_pic){
                $license        = $request->file('nid_back_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/nid/';
                $license->move($directory, $license_name);
                $nid_back_url    = $directory.$license_name;
                $driver->nid_back_pic= $nid_back_url;
            }
            if($request->license_font_pic){
                $license        = $request->file('license_font_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/license/';
                $license->move($directory, $license_name);
                $license_front_url    = $directory.$license_name;
                $driver->license_font_pic= $license_front_url;
            }
            if($request->license_back_pic){
                $license        = $request->file('license_back_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/license/';
                $license->move($directory, $license_name);
                $license_back_url    = $directory.$license_name;
                $driver->license_back_pic= $license_back_url;
            }
            if($driver->save()){
                return redirect()->route('driver.index')->with('message','Driver created successfully');
            }else{
                return redirect()->route('driver.index')->with('error_message','Sorry, something went wrong');
            }
        }
    }
    
    //update driver
    public function update(Request $request){ 
        $validators=Validator::make($request->all(),[
            'name'      => 'required',
            'phone'     => 'required',
            'dob'       => 'required',
            'owner_id'  => 'required',
            'nid'       => 'required',
            'district_id'=> 'required',
            'city_id'   => 'required',
            'address'   => 'required',
            'license'   => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $driver             = Driver::find($request->id);
            $driver->name       = $request->name;
            $driver->email      = $request->email ? $request->email : Null;
            $driver->phone      = $request->phone;
            $driver->dob        = $request->dob;
            $driver->owner_id   = $request->owner_id;
            $driver->nid        = $request->nid;
            $driver->district_id= $request->district_id;
            $driver->city_id    = $request->city_id;
            $driver->address    = $request->address;   
            $driver->license    = $request->license; 
            if($request->driver_photo){
                if($driver->driver_photo != null && file_exists($driver->driver_photo)){
                    unlink($driver->driver_photo);
                }
                $image          = $request->file('driver_photo');
                $image_name     = time().".".$image->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/driver_photo/';
                $image->move($directory, $image_name);
                $image_url      = $directory.$image_name;
                $driver->driver_photo = $image_url;
            }
            if($request->nid_font_pic){
                if($driver->nid_font_pic != null && file_exists($driver->nid_font_pic)){
                    unlink($driver->nid_font_pic);
                }
                $license        = $request->file('nid_font_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/nid/';
                $license->move($directory, $license_name);
                $nid_front_url    = $directory.$license_name;
                $driver->nid_font_pic= $nid_front_url;
            }
            if($request->nid_back_pic){
                if($driver->nid_back_pic != null && file_exists($driver->nid_back_pic)){
                    unlink($driver->nid_back_pic);
                }
                $license        = $request->file('nid_back_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/nid/';
                $license->move($directory, $license_name);
                $nid_back_url    = $directory.$license_name;
                $driver->nid_back_pic= $nid_back_url;
            }
            if($request->license_font_pic){
                if($driver->license_font_pic != null && file_exists($driver->license_font_pic)){
                    unlink($driver->license_font_pic);
                }
                $license        = $request->file('license_font_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/license/';
                $license->move($directory, $license_name);
                $license_front_url    = $directory.$license_name;
                $driver->license_font_pic= $license_front_url;
            }
            if($request->license_back_pic){
                if($driver->license_back_pic != null && file_exists($driver->license_back_pic)){
                    unlink($driver->license_back_pic);
                }
                $license        = $request->file('license_back_pic');
                $license_name   = time().".".$license->getClientOriginalExtension();
                $directory      = '../mobileapi/asset/driver/license/';
                $license->move($directory, $license_name);
                $license_back_url    = $directory.$license_name;
                $driver->license_back_pic= $license_back_url;
            }
            if($driver->update()){
                return redirect()->route('driver.index')->with('message','Driver update successfully');
            }else{
                return redirect()->route('driver.index')->with('error_message','Sorry, something went wrong');
            }
        }
    }
    
    //destroy driver
    public function destroy(Request $request){
        $driver = Driver::find($request->id);
        if(($driver->driver_photo != null) && file_exists($driver->driver_photo)){
            unlink($driver->driver_photo);
        }   
        if(($driver->nid_font_pic != null) && file_exists($driver->nid_font_pic)){
            unlink($driver->nid_font_pic);
        }
        if(($driver->nid_back_pic != null) && file_exists($driver->nid_back_pic)){
            unlink($driver->nid_back_pic);
        }
        if(($driver->license_font_pic != null) && file_exists($driver->license_font_pic)){
            unlink($driver->license_font_pic);
        }
        if(($driver->license_back_pic != null) && file_exists($driver->license_back_pic)){
            unlink($driver->license_back_pic);
        }
        $driver->delete();
        return Response::json([
            'status'  => 200,
            'message' => 'Driver deleted'
        ]);
    }
}
