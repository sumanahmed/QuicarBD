<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarPackage;
use App\Models\HotelPackage;
use App\Models\TravelPackage;
use App\Models\UserBanner;
use Illuminate\Http\Request;
use Validator;
use Response;

class UserBannerController extends Controller
{
    //show use banner
    public function index(){
        $user_banners = UserBanner::orderBy('id','DESC')->get();
        return view('quicarbd.admin.banner.user-banner', compact('user_banners'));
    }

    //create page
    public function create(){
        return view('quicarbd.admin.banner.user-banner-create');
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'title'         => 'required',
            'description'   => 'required',
            'clickable'     => 'required',
            'out_of_app'    => 'required',
            'where_go'      => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $user_banner                    = new UserBanner();
            $user_banner->title             = $request->title;
            $user_banner->description       = $request->description;
            $user_banner->clickable         = $request->clickable;
            $user_banner->out_of_app        = $request->out_of_app;
            $user_banner->where_go          = $request->where_go;
            $user_banner->specific_item_id  = $request->specific_item_id;
            $user_banner->click_linke       = $request->click_linke;
            $user_banner->package_id        = $request->package_id;
            if($request->hasFile('image_url')){
                $image             = $request->file('image_url');
                $imageName         = time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/user-banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $user_banner->image_url = $imageUrl;
            }
            if($user_banner->save()){
                return redirect()->route('user_banner.index');
            }else{
                return redirect()->back();
            }
        }
    }

    //edit page
    public function edit($id){
        $user_banner = UserBanner::find($id);
        return view('quicarbd.admin.banner.user-banner-edit', compact('user_banner'));
    }

    //update
    public function update(Request $request, $id){
        $validators=Validator::make($request->all(),[
            'title'         => 'required',
            'description'   => 'required',
            'clickable'     => 'required',
            'out_of_app'    => 'required',
            'where_go'      => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $user_banner          = UserBanner::find($id);
            $user_banner->title         = $request->title;
            $user_banner->description   = $request->description;
            $user_banner->clickable     = $request->clickable;
            $user_banner->out_of_app    = $request->out_of_app;
            $user_banner->where_go      = $request->where_go;
            $user_banner->specific_item_id  = $request->specific_item_id;
            $user_banner->click_linke       = $request->click_linke;
            $user_banner->package_id        = $request->package_id;
            if($request->hasFile('image_url')){
                if(($user_banner->image_url != null) && file_exists($user_banner->image_url)){
                    unlink($user_banner->image_url);
                }
                $image             = $request->file('image_url');
                $imageName         = time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/user-banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $user_banner->image_url = $imageUrl;
            }
            if($user_banner->update()){
                return redirect()->route('user_banner.index');
            }else{
                return redirect()->back();
            }
        }
    }

    //destroy
    public function destroy(Request $request){
        $user_banner = UserBanner::find($request->id);
        if(($user_banner->image_url != null) && file_exists($user_banner->image_url)){
            unlink($user_banner->image_url);
        }
        $user_banner->delete();
        return response()->json();
    }
}
