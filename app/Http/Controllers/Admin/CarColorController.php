<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarColor;
use Illuminate\Http\Request;
use Validator;
use Response;

class CarColorController extends Controller
{
    //show car brands
    public function index(){
        $colors = CarColor::all();
        return view('quicarbd.admin.car-info.color', compact('colors'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name'  => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $color          = new CarColor();
            $color->name    = $request->name;
            if($color->save()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $color
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
            'name'  => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $color          = CarColor::find($request->id);
            $color->name   = $request->name;
            if($color->update()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $color
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
        CarColor::find($request->id)->delete();
        return response()->json();
    }
}
