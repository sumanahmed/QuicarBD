<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBannerOwner;
use Illuminate\Http\Request;
use Validator;
use Response;

class PartnerBannerController extends Controller
{
    //show use banner
    public function index(){
        $partner_banners = HomeBannerOwner::orderBy('id','DESC')->get();
        return view('quicarbd.admin.banner.partner-banner', compact('partner_banners'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'title'     => 'required',
            'details'   => 'required',
            'image_url' => 'required'
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $partner_banner            = new HomeBannerOwner();
            $partner_banner->title     = $request->title;
            $partner_banner->details   = $request->details;
            $partner_banner->status    = $request->status;
            if($request->hasFile('image_url')){
                $image             = $request->file('image_url');
                $imageName         = time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/partner-banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $partner_banner->image_url = $imageUrl;
            }
            if($partner_banner->save()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $partner_banner
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
            'title'     => 'required',
            'details'   => 'required',
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $partner_banner             = HomeBannerOwner::find($request->id);
            $partner_banner->title      = $request->title;
            $partner_banner->details    = $request->details;
            $partner_banner->status     = $request->status;
            if($request->hasFile('image_url')){
                if(($partner_banner->image_url != null) && file_exists($partner_banner->image_url)){
                    unlink($partner_banner->image_url);
                }
                $image             = $request->file('image_url');
                $imageName         = time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/partner-banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $partner_banner->image_url = $imageUrl;
            }
            if($partner_banner->update()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $partner_banner
                ]);
            }else{
                return Response::json([
                    'status'    => 403,
                    'data'      => []
                ]);
            }
        }
    }

    //destroy
    public function destroy(Request $request){
        $partner_banner = HomeBannerOwner::find($request->id);
        if(($partner_banner->image_url != null) && file_exists($partner_banner->image_url)){
            unlink($partner_banner->image_url);
        }
        $partner_banner->delete();
        return response()->json();
    }
}
