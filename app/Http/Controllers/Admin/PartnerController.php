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
use App\Models\PartnerAppSetting;
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
        $query = DB::table('owners')
                ->leftjoin('district','owners.service_location_district','district.id')
                ->select('owners.*','district.value as district_name')
                ->orderBy('owners.id','DESC')
                ->where('owners.account_status', 1);
        
        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        if ($request->nid) {
            $query = $query->where('owners.nid', $request->nid);
        }
      
        if ($request->service_location_district) {
            $query = $query->where('owners.service_location_district', $request->service_location_district);
        }
        
        if ($request->service_location_district == null) {
            $query = $query->where('owners.service_location_district', '=', '');
        }
        
        $partners = $query->paginate(12);
        
        if ($request->service_location_district) {
            $total_partner = DB::table('owners')->where('service_location_district',$request->service_location_district)->count('id');
        } elseif ($request->service_location_district == null) {
            $total_partner = DB::table('owners')->where('service_location_district', '=', '')->count('id');
        } else {
            $total_partner = 0;
        }
        
        $districts = DB::table('district')->select('id','value as name')->orderBy('value','ASC')->get();
        $sms   = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
        
        return view('quicarbd.admin.partner.index', compact('partners','districts','total_partner','sms'));
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
        $data['accounts']   = DB::table('owner_account')->where('owner_id', $id)->orderBy('id','DESC')->get();
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
        
        if ($request->nid) {
            $query = $query->where('nid', $request->nid);
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
        $sms      = DB::table('sms')->select('id','title','message')->orderBy('id','DESC')->get();
        
        return view('quicarbd.admin.partner.verification', compact('partners','sms'));
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
    public function accountTypeChangeRequest(Request $request)
    {
        $query = DB::table('account_type_chage_request')
                    ->leftjoin('owners','account_type_chage_request.owner_id','owners.id')
                    ->select('account_type_chage_request.id','owners.name','owners.phone','owners.account_type',
                            'account_type_chage_request.owner_id','account_type_chage_request.which_acount',
                            'account_type_chage_request.created_at')
                    ->where('account_type_chage_request.status', 0)
                    ->orderBy('account_type_chage_request.id', 'DESC');            
                    
        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        if (isset($request->which_acount) && $request->which_acount != 100) { 
            $query = $query->where('account_type_chage_request.which_acount', $request->which_acount);
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
            $owner->account_type = $this->getNewAccountType($owner->account_type, $request->which_acount, $request->owner_id);
            $owner->update();

            $account = AccountTypeChargeRequest::find($request->id);
            $account->status = 1;
            $account->update();

            $helper = new Helper(); 
            $id     = $owner->n_key;
            $title  = 'Account Type Change';            
            $msg    = 'Dear '.$owner->name.', your account type change request approve successfully. Thanks Team Quicar';
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
    
    //change account type
    public function getNewAccountType ($current_type, $change_type, $owner_id) 
    {
        if ($change_type == 1) {  //want to go in hotel package
            if ($current_type == 0) { //current account in car    
                return 3; //3 mean car & hotel
            } elseif ($current_type == 2) { //current account in travel    
                return 5; //mean hotel & travel
            } elseif ($current_type == 4) { //current account in car, hotel & travel    
                return 1; // mean car
            } elseif ($current_type == 5) { //current account in hotel & travel    
                return 4; // mean car
            } elseif ($current_type == 6) { //current account in car & travel    
                return 1; // mean car
            }
        } elseif ($change_type == 2) { //want to go in travel package
            if ($current_type == 0) { //current account in car    
                return 6; // mean travel
            } elseif ($current_type == 1) { //current account in hotel    
                return 5; //mean hotel & travel
            } elseif ($current_type == 4) { //current account in car, hotel & travel    
                return 2; //mean hotel
            } elseif ($current_type == 5) { //current account in hotel & travel    
                return 4; //mean car
            } elseif ($current_type == 6) { //current account in car & travel    
                return 2; //mean car
            }
        } elseif ($change_type == 0) { //want to go in car package
            if ($current_type == 1) { //current account in hotel    
                return 3; // mean travel
            } elseif ($current_type == 2) { //current account in hotel    
                return 6; //mean car & travel
            } elseif ($current_type == 4) { //current account in car, hotel & travel    
                return 0; //mean car
            } elseif ($current_type == 5) { //current account in hotel & travel    
                return 4; //mean car
            } elseif ($current_type == 6) { //current account in car & travel    
                return 0; //mean car
            }
        }
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
    
    //balance add
    public function balanceAdd(Request $request)
    {       
        $validators=Validator::make($request->all(),[
            'id'   => 'required',
            'balance' => 'required',
            'add_balance' => 'required',
            'n_key' => 'required',
        ]);
        
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }
        
        $partner = Owner::find($request->id); 
        $partner->current_balance = ($partner->current_balance + $request->add_balance); 
        $partner->update();

        $id      = $request->n_key;
        $title   = "New balance add";
        $body    = "New balance ". $request->add_balance ." with your current balance. Thanks Team Quicar";

        $helper = new Helper();
        $helper->sendSinglePartnerNotification($id, $title, $body); //push notification send
        
        return Response::json([
            'status'    => 200,
            'message'   => "Balance added successfully",
        ]);  
    }
    
        
    //partner app settting edit
    public function partnerAppSettingEdit()
    {
        $setting = PartnerAppSetting::find(1);
        return view('quicarbd.admin.setting.partner-app', compact('setting'));
    }    
    
    //partner app settting update
    public function partnerAppSettingUpdate(Request $request)
    {
        $this->validate($request,[
            'trip_count'                => 'required',
            'bonous'                    => 'required',
            'date'                      => 'required',
            'time'                      => 'required',
            'info'                      => 'required',
            'app_vertion_code'          => 'required',
            'app_vertion_name'          => 'required',
            'mandatory_update'          => 'required',
            'bidding_percent'           => 'required',
            'car_package_charge'        => 'required',
            'hotel_package_charge'      => 'required',
            'travel_package_charge'     => 'required',
            'direct_contact_number'     => 'required',
            'direct_contact_number_for_user'  => 'required',
            'office_address'            => 'required',
            'facebook_link'             => 'required',
            'twitter_link'              => 'required',
            'user_app_version_code'     => 'required',
            'user_app_mandatory_audate' => 'required',
        ]);
    
        $partner_app                        = PartnerAppSetting::find(1);
        $partner_app->trip_count            = $request->trip_count;
        $partner_app->bonous                = $request->bonous;
        $partner_app->date                  = $request->date;
        $partner_app->time                  = $request->time;
        $partner_app->api                   = $request->api;
        $partner_app->info   = $request->info;
        $partner_app->app_vertion_code      = $request->app_vertion_code;
        $partner_app->app_vertion_name      = $request->app_vertion_name;
        $partner_app->whats_new_in_update   = $request->whats_new_in_update;
        $partner_app->mandatory_update      = $request->mandatory_update;
        $partner_app->download_url          = $request->download_url;
        $partner_app->bidding_percent       = $request->bidding_percent;
        $partner_app->car_package_charge    = $request->car_package_charge;
        $partner_app->hotel_package_charge  = $request->hotel_package_charge;
        $partner_app->travel_package_charge = $request->travel_package_charge;
        $partner_app->direct_contact_number = $request->direct_contact_number;
        $partner_app->direct_contact_number_for_user = $request->direct_contact_number_for_user;
        $partner_app->office_address        = $request->office_address;
        $partner_app->facebook_link         = $request->facebook_link;
        $partner_app->twitter_link          = $request->twitter_link;
        $partner_app->user_app_version_code = $request->user_app_version_code;
        $partner_app->user_app_version_name = $request->user_app_version_name;
        $partner_app->user_app_mandatory_audate = $request->user_app_mandatory_audate;
        if ($partner_app->update()) {
            return redirect()->route('setting.partner-app.edit')->with('message','Updated successfully');
        } else {
            return redirect()->back();
        }
    }
}
