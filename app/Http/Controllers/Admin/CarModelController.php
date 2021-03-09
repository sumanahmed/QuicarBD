<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\CarType;
use Illuminate\Http\Request;
use Validator;
use Response;

class CarModelController extends Controller
{
    //all models
    public function index(Request $request){ 
        $query     = CarModel::join('car_types','car_types.id','car_model.car_type_id')
                            ->join('car_brand','car_brand.id','car_model.car_brand_id')
                            ->select('car_model.*','car_types.name as car_type_name','car_brand.value as car_brand_name');

        if ($request->car_type_id) {
            $query = $query->where('car_model.car_type_id', $request->car_type_id);
        } 

        if ($request->car_brand_id) {
            $query = $query->where('car_model.car_brand_id', $request->car_brand_id);
        }

        $models  = $query->get();

        $car_types  = CarType::all();
        $brands     = CarBrand::all();
        return view('quicarbd.admin.car-info.model', compact('models','car_types','brands'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name'          => 'required',
            'car_type_id'   => 'required',
            'car_brand_id'  => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $model              = new CarModel();
            $model->value       = $request->name;
            $model->car_type_id = $request->car_type_id;
            $model->car_brand_id= $request->car_brand_id;
            if($model->save()){
                $model = CarModel::join('car_types','car_types.id','car_model.car_type_id')
                            ->join('car_brand','car_brand.id','car_model.car_brand_id')
                            ->select('car_model.*','car_types.name as car_type_name','car_brand.value as car_brand_name')
                            ->where('car_model.id', $model->id)
                            ->first();
                return Response::json([
                    'status'    => 201,
                    'data'      => $model
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
            'car_type_id'   => 'required',
            'car_brand_id'  => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $model              = CarModel::find($request->id);
            $model->value       = $request->name;
            $model->car_type_id = $request->car_type_id;
            $model->car_brand_id= $request->car_brand_id;
            if($model->update()){
                $model = CarModel::join('car_types','car_types.id','car_model.car_type_id')
                                ->join('car_brand','car_brand.id','car_model.car_brand_id')
                                ->select('car_model.*','car_types.name as car_type_name','car_brand.value as car_brand_name')
                                ->where('car_model.id', $model->id)
                                ->first();
                return Response::json([
                    'status'    => 201,
                    'data'      => $model
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
        $model = CarModel::find($request->id)->delete();
        return response()->json();
    }
}
