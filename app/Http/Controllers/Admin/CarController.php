<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarClass;
use App\Models\CarColor;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\CarYear;
use App\Models\City;
use App\Models\District;
use App\Models\Owner;
use App\Models\RideBiting;
use App\Models\Year;
use Response;
use Illuminate\Http\Request;

class CarController extends Controller
{
    //show all cars
    public function index(Request $request)
    {   
        $query = Car::leftjoin('owners','owners.id','cars.owner_id')
                    ->select('cars.*','owners.name as owner_name','owners.phone as owner_phone')
                    ->orderBy('cars.id','DESC');

        if ($request->carType && $request->carType != 0) {
            $query = $query->where('cars.carType', 'like', "{$request->carType}%");
        }

        if ($request->carBrand) {
            $query = $query->where('cars.carBrand', 'like', "{$request->carBrand}%");
        }

        if ($request->carModel) {
            $query = $query->where('cars.carModel', 'like', "{$request->carModel}%");
        }

        if ($request->owner_id && $request->owner_id != 0) { 
            $query = $query->where('cars.owner_id', $request->owner_id);
        }

        if ($request->carRegisterNumber != null) { 
            $query = $query->where('cars.carRegisterNumber', $request->carRegisterNumber);
        }

        if ($request->carYear && $request->carYear != 0) {
            $query = $query->where('cars.carYear', $request->carYear);
        }

        if (isset($request->status) && $request->status != 5) { 
            $query = $query->where('cars.status', $request->status);
        }

        $cars = isset($request->perPage) ? $query->paginate($request->perPage) : $query->paginate(10);

        $types  = CarType::all();
        $years  = Year::all();
        $owners = Owner::all();
        return view('quicarbd.admin.car.index', compact('cars','types','years','owners'));
    }

    //show create page
    public function create(){
        $types      = CarType::all();
        $colors     = CarColor::all();
        $classes    = CarClass::all();
        $owners     = Owner::where('account_status', 1)->get();
        $years      = Year::all();
        return view('quicarbd.admin.car.create', compact('types','colors','classes','owners','years'));
    }

    //car store
    public function store(Request $request){
        $this->validate($request,[
            'carType'   => 'required',
            'carBrand'  => 'required',
            'carModel'  => 'required',
            'carYear'   => 'required',
            'carColor'  => 'required',
            'carRegisterNumber' => 'required|unique:cars,carRegisterNumber',
            'owner_id'          => 'required',
        ]);
        
        $car                    = new Car();
        $car->carType           = $request->carType;
        $car->carBrand          = $request->carBrand;
        $car->carModel          = $request->carModel;
        $car->carYear           = $request->carYear;
        $car->carColor          = $request->carColor;
        $car->carClass          = $request->carClass;
        $car->carRegisterNumber = $request->carRegisterNumber;        
        $car->district_id       = 0;
        $car->city_id           = 0;
        $car->carServieLocation = 'test';
        $car->owner_id          = $request->owner_id;
        $car->status_message    = $request->status_message;
        $car->sit_capacity      = $request->sit_capacity;
        $car->tax_expired_date          = $request->tax_expired_date;
        $car->fitness_expired_date      = $request->fitness_expired_date;
        $car->registration_expired_date = $request->registration_expired_date;
        $car->insurance_expired_date    = $request->insurance_expired_date;
        $car->status    = $request->status;
        $car->verify    = $request->verify;
        if($request->hasFile('carImage')){
            $image1             = $request->file('carImage');
            $image1Name         = "carImage".time().".".$image1->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image1->move($directory, $image1Name);
            $image1Url          = $directory.$image1Name;
            $car->carImage      = $image1Url;
        }
        if($request->hasFile('carSmartCardFont')){
            $image2             = $request->file('carSmartCardFont');
            $image2Name         = "carSmartCardFont".time().".".$image2->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image2->move($directory, $image2Name);
            $image2Url          = $directory.$image2Name;
            $car->carSmartCardFont= $image2Url;
        }
        if($request->hasFile('carSmartCardBack')){
            $image3             = $request->file('carSmartCardBack');
            $image3Name         = "carSmartCardBack".time().".".$image3->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image3->move($directory, $image3Name);
            $image3Url          = $directory.$image3Name;
            $car->carSmartCardBack          = $image3Url;
        }
        if($request->hasFile('taxToken_image')){
            $image4             = $request->file('taxToken_image');
            $image4Name         = "taxToken_image".time().".".$image4->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image4->move($directory, $image4Name);
            $image4Url          = $directory.$image4Name;
            $car->taxToken_image= $image4Url;
        }
        if($request->hasFile('fitnessCertificate')){
            $image5             = $request->file('fitnessCertificate');
            $image5Name         = "fitnessCertificate".time().".".$image5->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image5->move($directory, $image5Name);
            $image5Url          = $directory.$image5Name;
            $car->fitnessCertificate          = $image5Url;
        }
        if($request->hasFile('insurancePaper_path')){
            $image6             = $request->file('insurancePaper_path');
            $image6Name         = "insurancePaper_path".time().".".$image6->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image6->move($directory, $image6Name);
            $image6Url          = $directory.$image6Name;
            $car->insurancePaper_path = $image6Url;
        }
        if($car->save()){
            return redirect()->route('car.index')->with('message','Car created successfully');
        }else{
            return redirect()->route('car.index')->with('error_message','Sorry, something went wrong');
        }
    }

    //show edit page
    public function edit($id){
        $car        = Car::find($id);
        $types      = CarType::all();
        $carType    = CarType::select('id')->where('name', $car->carType)->first();
        $classes    = CarClass::all();
        $owner      = Owner::select('id','name')->where('id', $car->owner_id)->where('account_status', 1)->first();
        $brands     = CarBrand::where('car_type_id', $carType->id)->where('value', $car->carBrand)->get();
        $carBrand   = CarBrand::select('id')->where('car_type_id', $carType->id)->where('value', $car->carBrand)->first();
        $models     = CarModel::select('id','value')->where('car_type_id', $carType->id)->where('car_brand_id', $carBrand->id)->get();
        $years      = Year::all();
        $colors     = CarColor::all();
        return view('quicarbd.admin.car.edit', compact('car','types','brands','models','years','classes','owner','colors'));
    }
    //show view page
    public function show($id){
        $car        = Car::find($id);
        $owner = Owner::find($car->owner_id)->name;
        return view('quicarbd.admin.car.show', compact('car','owner'));
    }

    //car update
    public function update(Request $request, $id){  
        $this->validate($request,[
            'carType'  => 'required',
            'carBrand'  => 'required',
            'carModel'  => 'required',
            'carYear'  => 'required',
            'carColor'  => 'required',
            'carRegisterNumber'  => 'required',
            'owner_id'  => 'required',
        ]);
        
        $car                    = Car::find($id);
        $car->carType           = $request->carType;
        $car->carBrand          = $request->carBrand;
        $car->carModel          = $request->carModel;
        $car->carYear           = $request->carYear;
        $car->carColor          = $request->carColor;
        $car->carClass          = $request->carClass;
        $car->carRegisterNumber = $request->carRegisterNumber;
        $car->district_id       = 0;
        $car->city_id           = 0;
        $car->carServieLocation = 'test';
        $car->owner_id          = $request->owner_id;
        $car->status_message    = $request->status_message;        
        $car->tax_expired_date          = $request->tax_expired_date;
        $car->fitness_expired_date      = $request->fitness_expired_date;
        $car->registration_expired_date = $request->registration_expired_date;
        $car->insurance_expired_date    = $request->insurance_expired_date;
        $car->status    = $request->status;
        $car->verify    = $request->verify;

        if ($car->verify == 1) {

            $helper = new Helper(); 
            $owner  = Owner::select('id','phone','name','n_key')->where('id', $request->owner_id)->first();
            $id     = $owner->n_key;
            $title  = 'Car Approved';            
            $msg    = 'Dear '.$owner->name.', your car('.$car->carRegisterNumber.') approved successfully. Thanks for connecting with Quicar';                        

            $helper->sendSinglePartnerNotification($id, $title, $msg); //push notificatio nsend
            $helper->smsSend($owner->phone, $msg); // sms send
            $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner
        }

        if($request->hasFile('carImage')){
            if(($car->carImage != null) && file_exists($car->carImage)){
                unlink($car->carImage);
            }
            $image1             = $request->file('carImage');
            $image1Name         = "carImage".time().".".$image1->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image1->move($directory, $image1Name);
            $image1Url          = $directory.$image1Name;
            $car->carImage      = $image1Url;
        }
        if($request->hasFile('carSmartCardFont')){
            if(($car->carSmartCardFont != null) && file_exists($car->carSmartCardFont)){
                unlink($car->carSmartCardFont);
            }
            $image2             = $request->file('carSmartCardFont');
            $image2Name         = "carSmartCardFont".time().".".$image2->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image2->move($directory, $image2Name);
            $image2Url          = $directory.$image2Name;
            $car->carSmartCardFont= $image2Url;
        }
        if($request->hasFile('carSmartCardBack')){
            if(($car->carSmartCardBack != null) && file_exists($car->carSmartCardBack)){
                unlink($car->carSmartCardBack);
            }
            $image3             = $request->file('carSmartCardBack');
            $image3Name         = "carSmartCardBack".time().".".$image3->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image3->move($directory, $image3Name);
            $image3Url          = $directory.$image3Name;
            $car->carSmartCardBack          = $image3Url;
        }
        if($request->hasFile('taxToken_image')){
            if(($car->taxToken_image != null) && file_exists($car->taxToken_image)){
                unlink($car->taxToken_image);
            }
            $image4             = $request->file('taxToken_image');
            $image4Name         = "taxToken_image".time().".".$image4->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image4->move($directory, $image4Name);
            $image4Url          = $directory.$image4Name;
            $car->taxToken_image= $image4Url;
        }
        if($request->hasFile('fitnessCertificate')){
            if(($car->fitnessCertificate != null) && file_exists($car->fitnessCertificate)){
                unlink($car->fitnessCertificate);
            }
            $image5             = $request->file('fitnessCertificate');
            $image5Name         = "fitnessCertificate".time().".".$image5->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image5->move($directory, $image5Name);
            $image5Url          = $directory.$image5Name;
            $car->fitnessCertificate          = $image5Url;
        }
        if($request->hasFile('insurancePaper_path')){
            if(($car->insurancePaper_path != null) && file_exists($car->insurancePaper_path)){
                unlink($car->insurancePaper_path);
            }
            $image6             = $request->file('insurancePaper_path');
            $image6Name         = "insurancePaper_path".time().".".$image6->getClientOriginalExtension();
            $directory          = '../mobileapi/asset/car/';
            $image6->move($directory, $image6Name);
            $image6Url          = $directory.$image6Name;
            $car->insurancePaper_path = $image6Url;
        }
        if($car->update()){
            return redirect()->route('car.index')->with('message','Car update successfully');
        }else{
            return redirect()->route('car.index')->with('error_message','Sorry, something went wrong');
        }
    }

    //car details
    public function details($id){
        $car = Car::find($id);
        $owners     = Owner::all();
        return view('quicarbd.admin.car.details', compact('car','owners'));
    }

    //car show with expired
    public function expired(){
        $today  = date('Y-m-d');
        $cars   = Car::join('owners','owners.id','cars.owner_id')
                    ->select('cars.*','owners.name as owner_name','owners.phone as owner_phone')
                    ->where(function($query) use ($today) {
                        return $query   ->where('cars.tax_expired_date', '<', $today)
                                        ->orWhere('cars.fitness_expired_date', '<', $today)
                                        ->orWhere('cars.registration_expired_date', '<', $today)
                                        ->orWhere('cars.insurance_expired_date', '<', $today);
                    }) 
                    ->where('cars.fitness_expired_date','!=','null')
                    ->where('cars.fitness_expired_date','!=','null')
                    ->where('cars.registration_expired_date','!=','null')
                    ->get();
        return view('quicarbd.admin.car.expired', compact('cars'));
    }

    //car expired notification send
    public function ownerSendNotification(Request $request)
    {        
        $helper = new Helper(); 
        $owner  = Owner::select('id','phone','name','n_key')->where('id', $request->owner_id)->first();
        $id     = $owner->n_key;
        $title  = 'Car Expired';            
        $msg    = 'Dear '.$owner->name.', your car ('.$request->car_reg_no.') expired. Please contact with Quicar';                        

        $helper->sendSinglePartnerNotification($id, $title, $msg); //push notification send
        $helper->smsSend($owner->phone, $msg); // sms send
        $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner
    }

    //car destroy
    public function destroy(Request $request)
    {        
        $rideBitting = RideBiting::where('car_id', $request->id)->get();
        if ($rideBitting->count() > 0) {
            return Response::json([
                'status'=> 403,
                'message' => 'Sorry, this car already used in Bidding',
                'data'  => []
            ]);
        }
        $car    = Car::select('id','owner_id','carRegisterNumber')->where('id', $request->id)->first();
        $helper = new Helper(); 
        $owner  = Owner::select('id','phone','name','n_key')->where('id', $car->owner_id)->first();
        $id     = $owner->n_key;
        $title  = 'Car Cancel';            
        $msg    = 'Dear '.$owner->name.', your car ('.$car->carRegisterNumber.') cancelled. Please contact with Quicar';                        

        $helper->sendSinglePartnerNotification($id, $title, $msg); //push notification send
        //$helper->smsSend($owner->phone, $msg); // sms send
        $helper->smsNotification($type = 2, $owner->id, $title, $msg); // send notification, 2=partner

        $car->delete();
        return response()->json();
    }
}
