<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\CarYear;
use App\Models\City;
use App\Models\Owner;
use App\Models\TourSpot;
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

    /**
     * get spots
     */
    public function getSpot ($district_id) {
        $spots  = TourSpot::select('id','name')->where('district_id', $district_id)->get();
        return response()->json($spots);
    }

    /**
     * get car
     */
    public function getSit ($car_type_id) {
        $sitCapacity  = CarType::find($car_type_id)->seat;
        return response()->json($sitCapacity);
    }

    /**
     * get car
     */
    public function getCar ($owner_id) {
        $cars  = Car::select('id','carRegisterNumber')->where('owner_id',$owner_id)->where('status', 1)->get();
        $car_package_charge = Owner::find($owner_id)->car_package_charge;
        return response()->json([
            'data' => $cars,
            'car_package_charge' => $car_package_charge
        ]);
    }

    /**
     * get car brand
     */
    public function getCarBrand ($car_type) {
        $carType = CarType::select('id','seat')->where('name', $car_type)->first();
        $brands  = CarBrand::select('id','value')->where('car_type_id', $carType->id)->get();
        $prefix = "to ";
        $index = strpos($carType->seat, $prefix) + strlen($prefix);
        $sit = substr($carType->seat, $index);

        return response()->json([
            'sit'   => $sit,
            'brands'=> $brands,
        ]);
    }

    /**
     * get car model
     */
    public function getCarModel ($car_type, $car_brand) {
        $carType  = CarType::select('id')->where('name', $car_type)->first();
        $carBrand = CarBrand::select('id')->where('car_type_id', $carType->id)->where('value', $car_brand)->first();
        $models   = CarModel::select('id','value')
                                ->where('car_type_id', $carType->id)
                                ->where('car_brand_id', $carBrand->id)
                                ->get();
        return response()->json($models);
    }

    /**
     * get car year
     */
    public function getCarYear ($car_type, $car_model) {
        $carType  = CarType::select('id')->where('name', $car_type)->first();
        $CarModel = CarModel::select('id')->where('car_type_id', $carType->id)->where('value', $car_model)->first();
        $years    = CarYear::select('id','value')
                                ->where('car_type_id', $carType->id)
                                ->where('car_model_id', $CarModel->id)
                                ->get();
        return response()->json($years);
    }

    /**
     * get car sit
     */
    public function getCarSit ($car_id) {
        $carType  = Car::select('sit_capacity')->where('id', $car_id)->first();
        return response()->json($carType->sit_capacity);
    }

    /**
     * get hotel package charge
     */
    public function getHotelPackageCharge ($owner_id) {
        $hotel_package_charge  = Owner::find($owner_id)->hotel_package_charge;
        return response()->json($hotel_package_charge);
    }

    /**
     * get hotel package charge
     */
    public function getTravelPackageCharge ($owner_id) {
        $travel_package_charge  = Owner::find($owner_id)->travel_package_charge;
        return response()->json($travel_package_charge);
    }
}
