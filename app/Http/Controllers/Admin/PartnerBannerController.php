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
    
    //show partner banner create
    public function create(){
        return view('quicarbd.admin.banner.partner-banner-create');
    }

    //store
    public function store(Request $request){
        $this->validate($request,[
            'title'     => 'required',
            'details'   => 'required',
            'image_url' => 'required'
        ]);
    
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
            return redirect()->route('partner_banner.index')->with('message','Banner added successfully');
        }else{
            return redirect()->back()->with('error_message','Something went wrong');
        }
    }
    
     //show use banner
    public function edit($id){ 
        $partner_banner = HomeBannerOwner::find($id); 
        return view('quicarbd.admin.banner.partner-banner-edit', compact('partner_banner'));
    }

    //update
    public function update(Request $request, $id){
        $this->validate($request,[
            'title'     => 'required',
            'details'   => 'required',
        ]);
        
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
             return redirect()->route('partner_banner.index')->with('message','Banner updated successfully');
        }else{
            return redirect()->back()->with('error_message','Something went wrong');
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
