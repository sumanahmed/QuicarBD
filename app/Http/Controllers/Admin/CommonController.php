<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

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
}
