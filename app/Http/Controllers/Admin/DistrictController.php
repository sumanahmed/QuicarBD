<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use Validator;
use Response;

class DistrictController extends Controller
{
    //show district
    public function index(){
        $districts = District::all();
        return view('quicarbd.admin.setting.district.index', compact('districts'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name'    => 'required',
            'bn_name' => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $district          = new District();
            $district->value   = $request->name;
            $district->bn_name = $request->bn_name;
            if($district->save()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $district
                ]);
            }else{
                return Response::json([
                    'status'=> 403,
                    'data'  => []
                ]);
            }
        }
    }

    //update
    public function update(Request $request){
        $validators=Validator::make($request->all(),[
            'name'    => 'required',
            'bn_name' => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $district          = District::find($request->id);
            $district->value   = $request->name;
            $district->bn_name = $request->bn_name;
            if($district->update()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $district
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
        District::find($request->id)->delete();
        return response()->json();
    }
}
