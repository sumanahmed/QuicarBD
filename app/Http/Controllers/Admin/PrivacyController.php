<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PolicyPartner;
use App\Models\PolicyUser;
use App\Models\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    
     /**
     * partner edit privacy
     */
    public function userEedit(Request $request){

        if ($request->type == 1) {
            $name = "about_us";
        } else if ($request->type == 2) {
            $name = "terms_of_services";
        } else if ($request->type == 3) {
            $name = "privacy_policy";
        } else if ($request->type == 4) {
            $name = "booking_policy";
        } else if ($request->type == 5) {
            $name = "cancellation_policy";
        } else if ($request->type == 6) {
            $name = "payment_policy";
        } else if ($request->type == 7) {
            $name = "refund_policy";
        }
        
        $privacy = PolicyUser::find(1);

        $type = $request->type;
        
        return view('quicarbd.admin.privacy.user', compact('privacy','name','type'));
    }

     /**
     * user update privacy
     */
    public function userUpdate(Request $request)
    {  
        $privacy  = PolicyUser::find(1);  
            
        if ($request->type == 1) {
            $privacy->about_us = $request->about_us;
        } else if ($request->type == 2) {
            $privacy->terms_of_services = $request->terms_of_services;
        }  else if ($request->type == 3) {
            $privacy->privacy_policy    = $request->privacy_policy;
        } else if ($request->type == 4) {
            $privacy->booking_policy    = $request->booking_policy;
        } else if ($request->type == 5) {
            $privacy->cancellation_policy = $request->cancellation_policy;
        } else if ($request->type == 6) {
            $privacy->payment_policy    = $request->payment_policy;
        } else if ($request->type == 7) {
            $privacy->refund_policy   = $request->refund_policy;
        } 

        $privacy->update();       

        if($privacy->update()){
            return redirect()->route('privacy.user.edit',['for'=> 1, 'type'=>$request->type])->with('message','Privacy updated successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

     /**
     * partner edit privacy
     */
    public function partnerEdit (Request $request)
    {
        if ($request->type == 1) {
            $name = "about_us";
        } else if ($request->type == 2) {
            $name = "terms_of_services";
        } else if ($request->type == 3) {
            $name = "privacy_policy";
        } else if ($request->type == 4) {
            $name = "booking_policy";
        } else if ($request->type == 5) {
            $name = "cancellation_policy";
        } else if ($request->type == 6) {
            $name = "payment_policy";
        } else if ($request->type == 7) {
            $name = "cashback_policy";
        } else if ($request->type == 8) {
            $name = "return_policy";
        } else if ($request->type == 9) {
            $name = "tips_and_trick";
        }
        
        $privacy = PolicyPartner::find(1);

        $type = $request->type;

        return view('quicarbd.admin.privacy.partner', compact('privacy','name','type'));
    }

     /**
     * user update privacy
     */
    public function partnerUpdate(Request $request)
    {       
        $privacy    = PolicyPartner::find(1);   

        if ($request->type == 1) {
            $privacy->about_us = $request->about_us;
        } else if ($request->type == 2) {
            $privacy->terms_of_services = $request->terms_of_services;
        }  else if ($request->type == 3) {
            $privacy->privacy_policy    = $request->privacy_policy;
        } else if ($request->type == 4) {
            $privacy->booking_policy    = $request->booking_policy;
        } else if ($request->type == 5) {
            $privacy->cancellation_policy = $request->cancellation_policy;
        } else if ($request->type == 6) {
            $privacy->payment_policy    = $request->payment_policy;
        } else if ($request->type == 7) {
            $privacy->cashback_policy   = $request->cashback_policy;
        }  else if ($request->type == 8) {
            $privacy->return_policy     = $request->return_policy;
        }  else if ($request->type == 9) {
            $privacy->tips_and_trick  = $request->tips_and_trick;
        }       

        $privacy->update();       

        if($privacy->update()){
            return redirect()->route('privacy.partner.edit',['for'=>2, 'type'=>$request->type])->with('message','Privacy updated successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }
}
