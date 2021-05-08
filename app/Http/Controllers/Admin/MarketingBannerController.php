<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketingBanner;

class MarketingBannerController extends Controller
{
    //show use banner
    public function index(Request $request){
        $banners = MarketingBanner::orderBy('id','DESC')->where('type',$request->type)->paginate(12);
        $type = $request->type;
        return view('quicarbd.admin.marketing-banner.index', compact('banners','type'));
    }    
    
    //show partner banner create
    public function create(Request $request){
        $type = $request->type;
        return view('quicarbd.admin.marketing-banner.create', compact('type'));
    }

    //store
    public function store(Request $request){
        $this->validate($request,[
            'marketing_dialog_title' => 'required',
            'type'   => 'required',
            'marketing_banner_image' => 'required',
        ]);
    
        $marketing_banner            = new MarketingBanner();
        $marketing_banner->marketing_dialog_title     = $request->marketing_dialog_title;
        $marketing_banner->type   = $request->type;
        $marketing_banner->status = $request->status;
        if($request->hasFile('marketing_banner_image')){
            $image             = $request->file('marketing_banner_image');
            $imageName         = time().".".$image->getClientOriginalExtension();
            $directory         = '../mobileapi/asset/marketing-banner/';
            $image->move($directory, $imageName);
            $imageUrl          = $directory.$imageName;
            $marketing_banner->marketing_banner_image = "http://quicarbd.com/mobileapi/asset/marketing-banner/".$imageName;
        }
        if($marketing_banner->save()){
            return redirect()->route('marketing_banner.index',['type' => $request->type])->with('message','Banner added successfully');
        }else{
            return redirect()->back()->with('error_message','Something went wrong');
        }
    }
    
    //show use banner
    public function edit($id){ 
        $banner = MarketingBanner::find($id); 
        return view('quicarbd.admin.marketing-banner.edit', compact('banner'));
    }

    //update
    public function update(Request $request, $id){
        $this->validate($request,[
            'marketing_dialog_title' => 'required',
            'type'   => 'required',
            'marketing_banner_image' => 'required',
        ]);
        
        $marketing_banner           = MarketingBanner::find($request->id);
        $marketing_banner->marketing_dialog_title     = $request->marketing_dialog_title;
        $marketing_banner->type     = $request->type;
        $marketing_banner->status   = $request->status;
        $marketing_banner->status   = $request->status;
        if($request->hasFile('marketing_banner_image')){
            if(($marketing_banner->marketing_banner_image != null) && file_exists($marketing_banner->marketing_banner_image)){
                unlink($marketing_banner->marketing_banner_image);
            }
            $image             = $request->file('marketing_banner_image');
            $imageName         = time().".".$image->getClientOriginalExtension();
            $directory         = '../mobileapi/asset/marketing-banner/';
            $image->move($directory, $imageName);
            $marketing_banner->marketing_banner_image = "http://quicarbd.com/mobileapi/asset/marketing-banner/".$imageName;
        }
        if ($marketing_banner->update()) {
             return redirect()->route('marketing_banner.index',['type' => $marketing_banner->type])->with('message','Banner updated successfully');
        } else {
            return redirect()->back()->with('error_message','Something went wrong');
        }
    }

    //destroy
    public function destroy(Request $request){ 
        $marketing_banner = MarketingBanner::find($request->id);
        if(($marketing_banner->image_url != null) && file_exists($marketing_banner->image_url)){
            unlink($marketing_banner->image_url);
        }
        $marketing_banner->delete();
        return response()->json();
    }
}
