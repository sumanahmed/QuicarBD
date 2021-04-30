<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RidePricing;
use Response;
use DB;

class RidePricingController extends Controller
{
    //show all
    public function index(Request $request)
    {     
        $query  = DB::table('pricing_table')
                    ->join('car_types','pricing_table.car_type','car_types.id')
                    ->select('pricing_table.*','car_types.name as car_type_name')
                    ->orderBy('pricing_table.id','DESC');

        if ($request->starting_district) {
            $query = $query->where('starting_district', $request->starting_district);
        }
        
        if ($request->destination_district) {
            $query = $query->where('destination_district', $request->destination_district);
        }   
        
        if ($request->car_type) {
            $query = $query->where('car_type', $request->car_type);
        }
        
        if ($request->ride_type) {
            $query = $query->where('ride_type', $request->ride_type);
        }
        
        if ($request->minimum_price) {
            $query = $query->where('minimum_price', $request->minimum_price);
        }
        
        if ($request->maximum_price) {
            $query = $query->where('maximum_price', $request->maximum_price);
        }

        $pricings = $query->paginate(12); 
        $districts  = DB::table('district')->orderBy('value','ASC')->get();
        $car_types  = DB::table('car_types')->orderBy('id','ASC')->get();
 
        return view('quicarbd.admin.pricing.index', compact('pricings','districts','car_types'));
    }

    //show create page
    public function create(){
        $districts  = DB::table('district')->orderBy('value','ASC')->get();
        $car_types  = DB::table('car_types')->orderBy('id','ASC')->get();      
        return view('quicarbd.admin.pricing.create', compact('districts','car_types'));
    }

    //driver store
    public function store(Request $request)
    { 
        $this->validate($request,[
            'starting_district'     => 'required',
            'destination_district'  => 'required',
            'car_type'              => 'required',
            'ride_type'             => 'required',
            'minimum_price'         => 'required',
            'maximum_price'         => 'required'
        ]);
        
        $pricing             = new RidePricing();
        $pricing->starting_district     = $request->starting_district;
        $pricing->destination_district  = $request->destination_district;
        $pricing->car_type              = $request->car_type;
        $pricing->ride_type             = $request->ride_type;
        $pricing->minimum_price         = $request->minimum_price;
        $pricing->maximum_price         = $request->maximum_price;
        $pricing->extra_note            = $request->extra_note;
        
        if($pricing->save()){
            return redirect()->route('pricing.index')->with('message','Pricing created successfully');
        }else{
            return redirect()->route('pricing.index')->with('error_message','Sorry, something went wrong');
        }
    }

    //show edit page
    public function edit($id){
        $pricing    = RidePricing::find($id);  
        $districts  = DB::table('district')->orderBy('value','ASC')->get();
        $car_types  = DB::table('car_types')->orderBy('id','ASC')->get();  
        return view('quicarbd.admin.pricing.edit', compact('pricing','districts','car_types'));
    }
    
    //update pricing
    public function update(Request $request, $id)
    { 
        $this->validate($request,[
            'starting_district'     => 'required',
            'destination_district'  => 'required',
            'car_type'              => 'required',
            'ride_type'             => 'required',
            'minimum_price'         => 'required',
            'maximum_price'         => 'required'
        ]);
        
        $pricing                        = RidePricing::find($id);
        $pricing->starting_district     = $request->starting_district;
        $pricing->destination_district  = $request->destination_district;
        $pricing->car_type              = $request->car_type;
        $pricing->ride_type             = $request->ride_type;
        $pricing->minimum_price         = $request->minimum_price;
        $pricing->maximum_price         = $request->maximum_price;
        $pricing->extra_note            = $request->extra_note;
        
        if($pricing->update()){
            return redirect()->route('pricing.index')->with('message','Pricing update successfully');
        }else{
            return redirect()->route('pricing.index')->with('error_message','Sorry, something went wrong');
        }
    }
    
    //destroy driver
    public function destroy(Request $request){
        $pricing = RidePricing::find($request->id)->delete();
        return Response::json([
            'status'  => 200,
            'message' => 'Pricing deleted'
        ]);
    }
}
