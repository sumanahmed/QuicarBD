<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountTypeChargeRequest;
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
use DB;

class PartnerController extends Controller
{
    //show all partner
    public function index(Request $request)
    {
        $query = Owner::orderBy('id','DESC')->where('account_status', 1);
        
        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }
        
        $partners = $query->paginate(12);
        
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
            'email'     => 'required|unique:owners,email',
            'phone'     => 'required|unique:owners,phone',
            'nid'       => 'required|unique:owners,nid',
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
        $owner->account_status          = $request->account_status;
        if($request->hasFile('img')){
            $image      = $request->file('img');
            $imageName  = time().".".$image->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/owner/';
            $image->move($directory, $imageName);
            $imageUrl   = $imageName;
            $owner->img = $imageUrl;
        }
        if($request->hasFile('nid_font_pic')){
            $nidFont      = $request->file('nid_font_pic');
            $nidFontName  = "nidFont".time().".".$nidFont->getClientOriginalExtension();
            $directory    = '../mobileapi/asset/owner/';
            $nidFont->move($directory, $nidFontName);
            $nidFontUrl   = $nidFontName;
            $owner->nid_font_pic = $nidFontUrl;
        }
        if($request->hasFile('nid_back_pic')){
            $nidBack      = $request->file('nid_back_pic');
            $nidBackName  = "nidBack".time().".".$nidBack->getClientOriginalExtension();
            $directory  = '../mobileapi/asset/owner/';
            $nidBack->move($directory, $nidBackName);
            $nidBackUrl   = $nidBackName;
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
            'email'     => 'required|unique:owners,email,'.$id,
            'phone'     => 'required|unique:owners,phone,'.$id,
            'nid'       => 'required|unique:owners,nid,'.$id,
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
        //$owner->n_key       = strlen($owner->n_key) > 6 ? $owner-n_key : 0;
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
            $imageUrl   = $imageName;
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
            $nidFontUrl   = $nidFontName;
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
            $nidBackUrl   = $nidBackName;
            $owner->nid_back_pic = $nidBackUrl;
        }
        if($owner->update()){
            if(isset($request->account_status) && $request->account_status != 1) {
                return redirect()->route('partner.verification')->with('message','Partner update successfully');
            }
            return redirect()->route('partner.index')->with('message','Partner update successfully');
        }else{
            return redirect()->route('partner.index')->with('error_message','Sorry, something went wrong');
        }
    }

    //partner details
    public function details($id){
        $partner                = Owner::find($id);
        $data['partner']        = $partner;
        $data['district_name']  = $partner->service_location_district;
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
            
            $helper->smsNotification($type = 2, $request->owner_id, $title, $body); // send notification, 2=partner

            if($request->notification == 1){      
                                  
                $helper->sendSinglePartnerNotification($id, $title, $body); //push notification send

                return Response::json([
                    'status'    => 200,
                    'message'   => "Notification send successfully",
                ]);
            }else{
                          
                $id      = $request->n_key;
                $title   = $request->title;
                $msg     = $request->message;
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
            if ($request->account_status == 1) {
                $title  = 'Account Approved';
                $msg    = 'Dear '.$partner->name.', Now you are a Quicar partner. Now you can add your services in Quicar platform. Call for help 01611822829. Thanks Team Quicar'; 
            } else if ($request->account_status == 2 && !empty($partner->nid_font_pic) && !empty($partner->nid_back_pic)) {
                $title = 'Account Pending';
                $msg    = 'Dear '.$partner->name.', We received your documents. Please wait for approval. It may take 24 hours to approve. Call for help 01611822829. Thanks Team Quicar'; 
            } else if ($request->account_status == 2) {
                $title = 'Account Pending';
                $msg    = 'Dear '.$partner->name.', Your account is now active. Please complete verification with NID and your photo. Call for help 01611822829. Thanks Team Quicar'; 
            } else {
                $title = 'Account Hold';
                $msg    = 'Dear '.$partner->name.', Unfortunately your Quicar Partner account has been hold. Please call for further help 01611822829. Thanks Team Quicar'; 
            }
            
            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($partner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $partner->id, $title, $msg); // send notification, 2=partner

            $partner->account_status = $request->account_status;
            $partner->update();

        } catch (Exception $ex) {
            return redirect()->route('partner.index')->with('error_message',$ex->getMessage());
        }
        
        return redirect()->route('partner.index')->with('message','Status update successfully');
    }

    //partner details
    public function verification(Request $request){
        $query = Owner::orderBy('id','DESC')
                        ->where(function($query) {
                            return $query->where('account_status', 0)
                                        ->orWhere('account_status', 2);
                        });
        
        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }
        
        if ($request->account_status == 0) {
            $query = $query->where('account_status', 0)
                            ->where('nid_font_pic', '')
                            ->where('nid_back_pic', '');
        }
        
        if ($request->account_status == 5) { 
            $query = $query->where('account_status', 0)
                            ->where('nid_font_pic', '<>', '')
                            ->where('nid_back_pic', '<>', '');
        }
        
        $partners = $query->paginate(12);
        
        return view('quicarbd.admin.partner.verification', compact('partners'));
    }
    
    //partner details
    public function verify($id, $account_type)
    {
        $account = AccountTypeChargeRequest::find($id);
        $account->account_type = $account_type;
        $account->update();
        
        return redirect()->route('partner.verification')->with('message','Approve successfully');
    }

    //partner account type change request list
    public function accountTypeChangeRequest(Request $request){ 
        $query = AccountTypeChargeRequest::join('owners','owners.id','account_type_chage_request.owner_id')
                    ->select('account_type_chage_request.id','owners.name','owners.phone','owners.account_type',
                            'account_type_chage_request.owner_id','account_type_chage_request.which_acount as request_for',
                            'account_type_chage_request.created_at')
                    ->where('account_type_chage_request.status', 0)
                    ->orderBy('account_type_chage_request.id','DESC');
                    
                    
        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        if ($request->request_for != 100) { 
            $query = $query->where('account_type_chage_request.which_acount', $request->request_for);
        }
        
        $partners = $query->paginate(12);
                    
        return view('quicarbd.admin.partner.account_type_change_request', compact('partners'));
    }
    
    //partner account type change request approve
    public function accountTypeChangeApprove(Request $request)
    {  
        DB::beginTransaction();

        try {
            $owner = Owner::find($request->owner_id);
            $owner->account_type = $request->which_acount;
            $owner->update();

            $account = AccountTypeChargeRequest::find($request->id);
            $account->status = 1;
            $account->update();

            $helper = new Helper(); 
            $id     = $owner->n_key;
            $title  = 'Account Type Change';            
            $msg    = 'Dear '.$owner->name.', your account type change request approve successfully. Thanks for connecting with Quicar';
            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($owner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner

            DB::commit();
            
        } catch (Exception $ex) {

            DB::rollback();

            return redirect()->route('partner.account_type_change_request')
                            ->with('error_message','Sorry, '.$ex->getMessage());
        }

        return redirect()->route('partner.account_type_change_request')->with('message','Approve successfully');
    }
    
    //partner account type change request cancel
    public function accountTypeChangeCancel(Request $request)
    { 
        DB::beginTransaction();

        try {
            $owner = Owner::find($request->owner_id);

            $account = AccountTypeChargeRequest::find($request->id);
            $account->status = 0;
            $account->update();

            $helper = new Helper(); 
            $id     = $owner->n_key;
            $title  = 'Account Type Change Request Cancel';            
            $msg    = 'Dear '.$owner->name.', your account type change request cacelled. Call for help 01611822829. Thanks Team Quicar';
            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner

            DB::commit();
            
        } catch (Exception $ex) {

            DB::rollback();

            return redirect()->route('partner.account_type_change_request')
                            ->with('error_message','Sorry, '.$ex->getMessage());
        }

        return redirect()->route('partner.account_type_change_request')->with('message','Request cancelled successfully');
    }
    
    //destroy
    public function destroy(Request $request){
        Owner::find($request->id)->delete();
        return response()->json();
    }
}
