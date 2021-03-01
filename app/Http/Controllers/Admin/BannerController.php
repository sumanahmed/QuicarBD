<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * show banner packages
     */
    public function bannerPackages(Request $request) 
    {
        if ($request->type == 1) { // 1 mean car package
            $banner = PackageBanner::find(1);
            $title  = 'Car Package';
            $name   = 'car_package';
            $type   = 1;
        } else if ($request->type == 2) { // 2 mean hotel package
            $banner = PackageBanner::find(1);
            $title  = 'Hotel Package';
            $name   = 'hotel_package';
            $type   = 2;
        } else if ($request->type == 3) { // 3 mean travel package
            $banner = PackageBanner::find(1);
            $title  = 'Travel Package';
            $name   = 'travel_package';
            $type   = 3;
        }
        return view('quicarbd.admin.banner.package-banner',compact('banner', 'title', 'name', 'type'));
    }

    public function bannerPackagesUpdate(Request $request)
    {
        $package_banner = PackageBanner::find(1);
        if($request->type == 1) {
            if($request->hasFile('car_package')){
                if(($package_banner->car_package != null) && file_exists($package_banner->car_package)){
                    unlink($package_banner->car_package);
                }
                $image             = $request->file('car_package');
                $imageName         = "carPackage".time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $package_banner->car_package = $imageUrl;
            }
        }
        if($request->type == 2) {
            if($request->hasFile('hotel_package')){
                if(($package_banner->hotel_package != null) && file_exists($package_banner->hotel_package)){
                    unlink($package_banner->hotel_package);
                }
                $image             = $request->file('hotel_package');
                $imageName         = "hotelPackage".time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $package_banner->hotel_package = $imageUrl;
            }
        }
        if($request->type == 2) {
            if($request->hasFile('travel_package')){
                if(($package_banner->travel_package != null) && file_exists($package_banner->travel_package)){
                    unlink($package_banner->travel_package);
                }
                $image             = $request->file('travel_package');
                $imageName         = "travelPackage".time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/banner/';
                $image->move($directory, $imageName);
                $imageUrl          = $directory.$imageName;
                $package_banner->travel_package = $imageUrl;
            }
        }
        $package_banner->update();

        return redirect()->route('banner.packages',['type' => $request->type]);
    }
}
