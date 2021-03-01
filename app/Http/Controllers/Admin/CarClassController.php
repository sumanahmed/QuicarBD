<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;
use App\Models\CarClass;
use Validator;
use Response;

class CarClassController extends Controller
{
    //show car brands
    public function index(){
        $classes = CarClass::join('car_types','car_types.id','car_class.car_type_id')
                        ->select('car_class.*','car_types.name as car_type_name')
                        ->get();
        $car_types = CarType::all();
        return view('quicarbd.admin.car-info.class', compact('classes','car_types'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name'    => 'required',
            'car_type_id'    => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $class          = new CarClass();
            $class->value   = $request->name;
            $class->car_type_id   = $request->car_type_id;
            if($class->save()){
                $class = CarClass::join('car_types','car_types.id','car_class.car_type_id')
                                    ->select('car_class.*','car_types.name as car_type_name')
                                    ->where('car_class.id', $class->id)
                                    ->first();
                return Response::json([
                    'status'    => 201,
                    'data'      => $class
                ]);
            }else{
                return Response::json([
                    'status'        => 403,
                    'data'          => []
                ]);
            }
        }
    }

    //update
    public function update(Request $request){
        $validators=Validator::make($request->all(),[
            'name'    => 'required',
            'car_type_id'    => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $class          = CarClass::find($request->id);
            $class->value   = $request->name;
            $class->car_type_id   = $request->car_type_id;
            if($class->update()){
                $class = CarClass::join('car_types','car_types.id','car_class.car_type_id')
                                    ->select('car_class.*','car_types.name as car_type_name')
                                    ->where('car_class.id', $class->id)
                                    ->first();
                return Response::json([
                    'status'    => 201,
                    'data'      => $class
                ]);
            }else{
                return Response::json([
                    'status'        => 403,
                    'data'          => []
                ]);
            }
        }
    }

    //destroy
    public function destroy(Request $request){
        $class = CarClass::find($request->id)->delete();
        return response()->json();
    }
}
