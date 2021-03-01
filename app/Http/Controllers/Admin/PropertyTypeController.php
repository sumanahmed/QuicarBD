<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Response;
use Validator;

class PropertyTypeController extends Controller
{
     //all property
     public function index(){
        $property_types = PropertyType::all();
        return view('quicarbd.admin.hotel-info.property-type.index', compact('property_types'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $property_type           = new PropertyType();
            $property_type->name     = $request->name;
            $property_type->status   = $request->status;
            if($property_type->save()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $property_type
                ]);
            }else{
                return Response::json([
                    'status'    => 403,
                    'data'      => []
                ]);
            }
        }
    }

    //update
    public function update(Request $request){
        $validators=Validator::make($request->all(),[
            'name'=> 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $property_type           = PropertyType::find($request->id);
            $property_type->name     = $request->name;
            $property_type->status   = $request->status;
            if($property_type->update()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $property_type
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
        PropertyType::find($request->id)->delete();
        return response()->json();
    }
}
