<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\Car;
use App\Models\CarPackage;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\District;
use App\Models\City;
use App\Models\Driver;
use App\Models\HotelPackage;
use App\Models\TravelPackage;
use Exception;
use GuzzleHttp\Client;
use Validator;
use Response;

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

   //partner store
    public function store(Request $request){ 

        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'nid'       => 'required',
            'account_type'          => 'required',
            'bidding_percent'       => 'required',
            'car_package_charge'    => 'required',
            'hotel_package_charge'  => 'required',
            'travel_package_charge' => 'required',
            'service_location_district' => 'required',
        ]);

        $owner              = new Owner();
        $owner->name        = $request->name;
        $owner->email       = $request->email;
        $owner->phone       = $request->phone;
        $owner->account_type= $request->account_type;
        $owner->nid         = $request->nid;        
        $owner->c_lat       = 0.0000;
        $owner->c_lon       = 0.0000;
        $owner->n_key       = 0.0000;
        $owner->service_location_district  = $request->service_location_district;
        $owner->service_location_city      = $request->service_location_city;
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
        return view('quicarbd.admin.partner.edit', compact('partner','districts'));
    }

   //partner update
    public function update(Request $request, $id){ 
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'nid'       => 'required',
            'account_type'          => 'required',
            'bidding_percent'       => 'required',
            'car_package_charge'    => 'required',
            'hotel_package_charge'  => 'required',
            'travel_package_charge' => 'required',
            'service_location_district' => 'required',
        ]);
        
        $owner              = Owner::find($id);
        $owner->name        = $request->name;
        $owner->email       = $request->email;
        $owner->phone       = $request->phone;
        $owner->account_type= $request->account_type;
        $owner->nid         = $request->nid;        
        $owner->c_lat       = 0.0000;
        $owner->c_lon       = 0.0000;
        $owner->n_key       = 0.0000;
        $owner->service_location_district  = $request->service_location_district;
        $owner->service_location_city      = $request->service_location_city;
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

   //partner details
    public function details($id){
        $partner                = Owner::find($id);
        $data['partner']        = $partner;
        $data['district_name']  = District::find($partner->service_location_district)->value;
        $data['total_car']      = Car::where('owner_id', $id)->count('id');
        $data['total_driver']   = Driver::where('owner_id', $id)->count('id');
        $data['total_car_package']      = CarPackage::where('owner_id', $id)->count('id');
        $data['total_hotel_package']    = HotelPackage::where('owner_id', $id)->count('id');
        $data['total_travel_package']   = TravelPackage::where('owner_id', $id)->count('id');
        return view('quicarbd.admin.partner.details', $data);
    }

    //notification send
    public function notificationSend(Request $request)
    {               
        $validators = Validator::make($request->all(),[
            'title'   => 'required',
            'message' => 'required',
            'notification' => 'required',
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{ 
            $helper = new Helper(); 
            $id     = $request->n_key;
            $title  = $request->title;
            $body   = $request->message; 

            if($request->notification == 1){      
                                  
                $helper->sendSinglePartnerNotification($id, $title, $body); //push notificatio nsend

                return Response::json([
                    'status'    => 200,
                    'message'   => "Notification send successfully",
                ]);
            }else{
                          
                $id      = $request->n_key;
                $title   = $request->title;
                $msg    = $request->message;
                $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
                $helper->smsSend($request->phone, $msg); // sms send

                return Response::json([
                    'status'    => 200,
                    'message'   => "Notification & SMS send successfully",
                ]);
            }            
        }        
    }

    /**
     * status update
     */
    public function statusUpdate (Request $request) 
    {        
        try {

            $partner = Owner::find($request->id);

            $helper = new Helper(); 
            $id     = $partner->n_key;
            $title  = $request->staus == 1 ? 'Account Approved' : 'Account Pending';            
            $msg    = 'Dear '.$partner->name.', your '.$title.' successfully. Thanks for connecting with Quicar';                        
            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($request->phone, $msg); // sms send

            $partner->account_status = $request->status;
            $partner->update();

        } catch (Exception $ex) {
            return redirect()->route('partner.index')->with('error_message',$ex->getMessage());
        }
        
        return redirect()->route('partner.index')->with('message','Status update successfully');
    }

   //partner details
   public function verification(){
    $partners = Owner::all();
    return view('quicarbd.admin.partner.verification', compact('partners'));
}
}
