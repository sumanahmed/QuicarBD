<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class CityController extends Controller
{
     //show city
     public function index(){
        $citys      = City::join('district','district.id','city.district_id')
                            ->select('city.*','district.value as district_name')
                            ->get();

        $districts  = District::all();
        return view('quicarbd.admin.setting.city.index', compact('citys','districts'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name'          => 'required',
            'bn_name'       => 'required',
            'district_id'   => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $city           = new City();
            $city->name     = $request->name;
            $city->bn_name  = $request->bn_name;
            $city->district_id= $request->district_id;
            if($city->save()){
                $city= City::join('district','district.id','city.district_id')
                            ->select('city.*','district.value as district_name')
                            ->where('city.id', $city->id)
                            ->first();
                return Response::json([
                    'status'    => 201,
                    'data'      => $city
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
            'name'          => 'required',
            'bn_name'       => 'required',
            'district_id'   => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $city           = City::find($request->id);
            $city->name     = $request->name;
            $city->bn_name  = $request->bn_name;
            $city->district_id  = $request->district_id;
            if($city->update()){
                $city= City::join('district','district.id','city.district_id')
                        ->select('city.*','district.value as district_name')
                        ->where('city.id', $city->id)
                        ->first();
                return Response::json([
                    'status'    => 201,
                    'data'      => $city
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
        $city = City::find($request->id)->delete();
        return response()->json();
    }
}
