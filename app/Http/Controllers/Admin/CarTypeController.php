<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;
use Validator;
use Response;

class CarTypeController extends Controller
{
    //all car types
    public function index(){
        $car_types = CarType::all();
        return view('quicarbd.admin.car-info.car-type', compact('car_types'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name' => 'required',
            'seat' => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $car_type         = new CarType();
            $car_type->name   = $request->name;
            $car_type->seat   = $request->seat;
            if($car_type->save()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $car_type
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
            'name' => 'required',
            'seat' => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $car_type         = CarType::find($request->id);
            $car_type->name   = $request->name;
            $car_type->seat   = $request->seat;
            if($car_type->update()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $car_type
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
        $car_type = CarType::find($request->id)->delete();
        return response()->json();
    }
}
