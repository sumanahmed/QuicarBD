<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAppNotice;
use App\Models\PartnerAppNotice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * show notice packages
     */
    public function noticePackages(Request $request) 
    {
        if ($request->type == 0) { // 1 mean Home Page
            $notice = UserAppNotice::find(1);
            $title  = 'Home Page';
            $name   = 'homepage_notice';
            $type   = 0;
        } else if ($request->type == 1) { // 1 mean car package
            $notice = UserAppNotice::find(1);
            $title  = 'Car Package';
            $name   = 'car_package_homepage_notice';
            $type   = 1;
        } else if ($request->type == 2) { // 2 mean hotel package
            $notice = UserAppNotice::find(1);
            $title  = 'Hotel Package';
            $name   = 'hotel_package_homepage_notice';
            $type   = 2;
        } else if ($request->type == 3) { // 3 mean travel package
            $notice = UserAppNotice::find(1);
            $title  = 'Travel Package';
            $name   = 'travel_group_homepage_notice';
            $type   = 3;
        }
        return view('quicarbd.admin.notice.package-notice',compact('notice', 'title', 'name', 'type'));
    }

    public function noticePackagesUpdate(Request $request)
    {  
        $package_notice = UserAppNotice::find(1);

        if($request->type == 0) {
            $package_notice->homepage_notice = $request->homepage_notice;
        } else if($request->type == 1) {
            $package_notice->car_package_homepage_notice = $request->car_package_homepage_notice;
        } else if($request->type == 2) {
            $package_notice->hotel_package_homepage_notice = $request->hotel_package_homepage_notice;
        } else if($request->type == 3) {
            $package_notice->travel_group_homepage_notice = $request->travel_group_homepage_notice;
        }

        $package_notice->update();

        return redirect()->route('notice.packages',['type' => $request->type]);
    }
    
     /**
     * show notice partner app
     */
    public function noticePartnerApp(Request $request) 
    {
        $notice = PartnerAppNotice::find(1);
        return view('quicarbd.admin.notice.partner-app',compact('notice'));
    }

    public function noticePartnerAppUpdate(Request $request)
    {  
        $notice = PartnerAppNotice::find(1);
        $notice->homepage = $request->homepage;
        $notice->update();

        return redirect()->route('notice.partner_app')->with('message','Update successfully');
    }
}
