<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\City;
use Illuminate\Http\Request;
use Response;

class CommonController extends Controller
{
    /**
     * getCity
     */
    public function getCity ($district_id) 
    {
        $cities= City::select('id','name')->where('district_id',$district_id)->get();
        return response()->json($cities);
    }

    /**
     * get Brand
     */
    public function getBrand ($car_type_id) {
        $car_brand = CarBrand::select('id','value as name')->where('car_type_id', $car_type_id)->get();
        if($car_brand->count() > 0){
            return Response::json([
                'status'    => 200,
                'data'      => $car_brand
            ]);
        }else{
            return Response::json([
                'status'    => 403,
                'data'      => []
            ]);
        }
    }
}
