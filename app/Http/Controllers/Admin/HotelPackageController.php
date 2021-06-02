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
use DB;

class HotelPackageController extends Controller
{
    /**
     * show hotel packages
     */
    public function index(Request $request){
        $query = DB::table('hotel_packages')->join('district','district.id','hotel_packages.district_id')
                                        ->join('city','city.id','hotel_packages.city_id')
                                        ->join('owners','owners.id','hotel_packages.owner_id')
                                        ->select('district.value as district_name','city.name as city_name',
                                                'hotel_packages.id','hotel_packages.price', 'hotel_packages.package_status',
                                                'hotel_packages.hotel_name','hotel_packages.status',
                                                'owners.name as owner_name', 'owners.phone as owner_phone'
                                        )
                                ->orderBy('hotel_packages.id','DESC');
        if ($request->hotel_name) {
            $query = $query->where('hotel_packages.hotel_name', 'like', "{$request->hotel_name}%");
        }

        if ($request->owner_id) {
            $query = $query->where('hotel_packages.owner_id', $request->owner_id);
        }
        
        if ($request->district_id) {
            $query = $query->where('hotel_packages.district_id', $request->district_id);
        }
        
        if ($request->price) {
            $query = $query->where('hotel_packages.price', $request->price);
        }

        $hotel_packages = $query->paginate(12)->appends(request()->query());;
        $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
        
        return view('quicarbd.admin.package.hotel-package.index', compact('hotel_packages','districts'));
    }

    /**
     * show hotel packages create page
     */
    public function create(){
        $districts = District::all();
        $owners    = Owner::all();
        $property_types = PropertyType::where('status', 1)->get();
        $amenities = HotelAmenity::where('status', 1)->get();
        return view('quicarbd.admin.package.hotel-package.create', compact('districts','owners','property_types','amenities'));
    }

    /**
     * hotel packages store
     */
    public function store(Request $request){ 
        $this->validate($request,[
            'hotel_name' => 'required',
            'district_id' => 'required',
            'city_id' => 'required',
            'area' => 'required',
            'propertyType' => 'required',
            'facilities' => 'required',
            'price' => 'required',
            'quicar_charge' => 'required',
            'you_will_get' => 'required',
            'owner_id' => 'required',
            'booking_policy' => 'required',
            'cancellation_policy' => 'required',
            'hotel_image' => 'required',
            'room_image' => 'required',
            'hotel_check_in_time' => 'required',
            'hotel_check_out_time' => 'required',
        ]); 
        
        $hotel_package                     = new HotelPackage();
        $hotel_package->hotel_name         = $request->hotel_name;
        $hotel_package->status             = $request->status;
        $hotel_package->package_status     = $request->package_status;
        $hotel_package->district_id        = $request->district_id;
        $hotel_package->city_id            = $request->city_id;
        $hotel_package->area               = $request->area;
        $hotel_package->room_type          = $request->room_type;
        $hotel_package->room_size          = $request->room_size;
        $hotel_package->propertyType       = $request->propertyType;
        $hotel_package->facilities         = json_encode($request->facilities); 
        $hotel_package->owner_id           = $request->owner_id;
        $hotel_package->price              = $request->price;
        $hotel_package->quicar_charge      = $request->quicar_charge;
        $hotel_package->you_will_get       = $request->you_will_get;   
        $hotel_package->cash_back_price    = isset($request->cash_back_price) ? $request->cash_back_price : 0;
        $hotel_package->cash_back_status   = isset($request->cash_back_status) ? $request->cash_back_status : 0;
        $hotel_package->cash_back_staring_time = isset($request->cash_back_staring_time) ? $request->cash_back_staring_time : Null;
        $hotel_package->cash_back_ending_time  = isset($request->cash_back_ending_time) ? $request->cash_back_ending_time : Null;
        $hotel_package->booking_policy     = $request->booking_policy;
        $hotel_package->cancellation_policy= $request->cancellation_policy;
        $hotel_package->booking_contact_number= $request->booking_contact_number;
        $hotel_package->referrel_code      = $request->referrel_code;
        $hotel_package->hotel_website      = $request->hotel_website;
        $hotel_package->facebook_page      = $request->facebook_page;
        $hotel_package->hotel_check_in_time= date('H:i:s', strtotime($request->hotel_check_in_time));
        $hotel_package->hotel_check_out_time= date('H:i:s', strtotime($request->hotel_check_out_time));
        if($request->hasFile('hotel_image')){
            $image      = $request->file('hotel_image');
            $imageName  = time().".".$image->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/hotel_packge/';
            $image->move($directory, $imageName);
            $imageUrl   = $directory.$imageName;
            $hotel_package->hotel_image = $imageUrl;
        }
        if($request->hasFile('room_image')){
            $image2     = $request->file('room_image');
            $image2Name = time().".".$image2->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/hotel_packge/';
            $image2->move($directory, $image2Name);
            $image2Url  = $directory.$image2Name;
            $hotel_package->room_image = $image2Url;
        }

        if ($request->package_status == 1) {

            $helper = new Helper(); 
            $owner  = Owner::select('id','phone','name','n_key')->where('id', $request->owner_id)->first();
            $id     = $owner->n_key;
            $title  = 'Package Approved';            
            $msg    = 'Dear '.$owner->name.', your hotel package ('.$hotel_package->hotel_name.') approved successfully. Thanks for connecting with Quicar';                        

            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($owner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner
        }

        if($hotel_package->save()){
            return redirect()->route('hotel_package.index')->with('message','hotel package added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }
    
    /**
     * show hotel packages edit page
     */
    public function edit($id){
        $hotel_package= HotelPackage::find($id);
        $districts  = District::all();
        $cities     = City::where('district_id', $hotel_package->district_id)->get();
        $owner      = Owner::find($hotel_package->owner_id)->name;
        $property_types = PropertyType::where('status', 1)->get();
        $amenities = HotelAmenity::where('status', 1)->get();
        $charge    = Owner::find($hotel_package->owner_id)->hotel_package_charge;
        return view('quicarbd.admin.package.hotel-package.edit', compact('hotel_package','districts','cities','owner','property_types','amenities','charge'));
    }
    
    /**
     * show hotel packages details page
     */
    public function details($id){
        $hotel_package  = HotelPackage::find($id);
        $district       = District::find($hotel_package->district_id)->value;
        $city       = City::find($hotel_package->city_id)->name;
        $cities     = City::where('district_id', $hotel_package->district_id)->get();
        $owner      = Owner::find($hotel_package->owner_id)->name;
        $property_type = PropertyType::find($hotel_package->propertyType)->name;
        $amenities = HotelAmenity::where('status', 1)->get();
        $charge    = Owner::find($hotel_package->owner_id)->hotel_package_charge;
        return view('quicarbd.admin.package.hotel-package.details', compact('hotel_package','district','city','owner','property_type','amenities','charge'));
    }
    
    /**
     * hotel packages store
     */
    public function update(Request $request, $id){
        $this->validate($request,[
            'hotel_name' => 'required',
            'district_id' => 'required',
            'city_id' => 'required',
            'area' => 'required',
            'propertyType' => 'required',
            'facilities' => 'required',
            'price' => 'required',
            'quicar_charge' => 'required',
            'you_will_get' => 'required',
            'owner_id' => 'required',
            'booking_policy' => 'required',
            'cancellation_policy' => 'required',
            'hotel_check_in_time' => 'required',
            'hotel_check_out_time' => 'required',
        ]);
        $hotel_package                     = HotelPackage::find($id);
        $hotel_package->hotel_name         = $request->hotel_name;
        $hotel_package->status             = $request->status;
        $hotel_package->package_status     = $request->package_status;
        $hotel_package->district_id        = $request->district_id;
        $hotel_package->city_id            = $request->city_id;
        $hotel_package->area               = $request->area;
        $hotel_package->room_type          = $request->room_type;
        $hotel_package->room_size          = $request->room_size;
        $hotel_package->propertyType       = $request->propertyType;
        $hotel_package->facilities         = json_encode($request->facilities); 
        $hotel_package->owner_id           = $request->owner_id;
        $hotel_package->price              = $request->price;
        $hotel_package->quicar_charge      = $request->quicar_charge;
        $hotel_package->you_will_get       = $request->you_will_get; 
        $hotel_package->cash_back_price    = isset($request->cash_back_price) ? $request->cash_back_price : 0;
        $hotel_package->cash_back_status   = isset($request->cash_back_status) ? $request->cash_back_status : 0;
        $hotel_package->cash_back_staring_time = isset($request->cash_back_staring_time) ? $request->cash_back_staring_time : Null;
        $hotel_package->cash_back_ending_time  = isset($request->cash_back_ending_time) ? $request->cash_back_ending_time : Null;
        $hotel_package->booking_policy     = $request->booking_policy;
        $hotel_package->cancellation_policy= $request->cancellation_policy;
        $hotel_package->booking_contact_number= $request->booking_contact_number;
        $hotel_package->referrel_code      = $request->referrel_code;
        $hotel_package->hotel_website      = $request->hotel_website;
        $hotel_package->facebook_page      = $request->facebook_page;
        $hotel_package->hotel_check_in_time= date('H:i:s', strtotime($request->hotel_check_in_time));
        $hotel_package->hotel_check_out_time= date('H:i:s', strtotime($request->hotel_check_out_time));

        if($request->hasFile('hotel_image')){
            if(($hotel_package->hotel_image != null) && file_exists($hotel_package->hotel_image)){
                unlink($hotel_package->hotel_image);
            }
            $image      = $request->file('hotel_image');
            $imageName  = time().".".$image->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/hotel_packge/';
            $image->move($directory, $imageName);
            $imageUrl   = $directory.$imageName; dd($imageUrl);
            $hotel_package->hotel_image = $imageUrl;
        }
        if($request->hasFile('room_image')){
            if(($hotel_package->room_image != null) && file_exists($hotel_package->room_image)){
                unlink($hotel_package->room_image);
            }
            $image2     = $request->file('room_image');
            $image2Name = time().".".$image2->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/hotel_packge/';
            $image2->move($directory, $image2Name);
            $image2Url  = $directory.$image2Name;
            $hotel_package->room_image = $image2Url;
        }

        if ($request->package_status == 1) {

            $helper = new Helper(); 
            $owner  = Owner::select('id','phone','name','n_key')->where('id', $request->owner_id)->first();
            $id     = $owner->n_key;
            $title  = 'Package Approved';            
            $msg    = 'Dear '.$owner->name.', your hotel package ('.$hotel_package->hotel_name.') approved successfully. Thanks for connecting with Quicar';                        

            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($owner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner
        }

        if($hotel_package->update()){
            return redirect()->route('hotel_package.index')->with('message','Hotel package updated successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    /**
     * delete hotel package
     */
    public function destroy(Request $request){
        $hotel_package = HotelPackage::find($request->id);

        if(($hotel_package->hotel_image != null) && file_exists($hotel_package->hotel_image)){
            unlink($hotel_package->hotel_image);
        }

        if(($hotel_package->room_image != null) && file_exists($hotel_package->room_image)){
            unlink($hotel_package->room_image);
        }

        $hotel_package->delete();

        return response()->json();
    }
}
