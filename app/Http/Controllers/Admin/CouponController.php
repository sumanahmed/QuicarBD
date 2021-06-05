<?php

namespace App\Http\Controllers\Admin;

use App\Http\Lib\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CouponList;
use App\Models\CouponUsedList;
use GuzzleHttp\Client;
use DateTimeZone;
use DateTime;
use DB;

class CouponController extends Controller
{
     //show all
     public function index(Request $request){
        $query  = DB::table('coupon_list')->select('*')->orderBy('id','DESC');
        
        if ($request->coupon) {
            $query = $query->where('coupon', 'like', "{$request->coupon}%");
        }         
        
        if ($request->status) {
            $query = $query->where('status', $request->status);
        }   
        
        $coupons= $query->paginate(12)->appends(request()->query());
        
        $coupon_for= $request->coupon_for;
        $users  = DB::table('users')->select('id','name')->orderBy('id','DESC')->get();
        
        return view('quicarbd.admin.coupon.index', compact('coupons','coupon_for','users'));
    }     
    
    //show create method
     public function create(Request $request){
        $users  = DB::table('users')->select('id','name','phone')->orderBy('id','DESC')->get();
        $coupon_for= $request->coupon_for;
        return view('quicarbd.admin.coupon.create', compact('coupon_for','users'));
    }

    //store
    public function store(Request $request)
    { 
        $this->validate($request,[
            'coupon' => 'required',
            'status' => 'required',
            'type'   => 'required',
            'spacifice_user'  => 'required',
            'how_many_use'  => 'required',
            'start'  => 'required',
            'end'    => 'required',
        ]);
        
        if ($request->type == 1) {
            $this->validate($request,[
                'percentage' => 'required'
            ]);
        }  
        
        if ($request->type == 2) {
            $this->validate($request,[
                'amount' => 'required'
            ]);
        }        
        
        if ($request->spacifice_user == 1) {
            $this->validate($request,[
                'user_id' => 'required'
            ]);
        }
        
        DB::beginTransaction();
        
        try {
       
            $coupon         = new CouponList();
            $coupon->coupon = $request->coupon;
            $coupon->status = $request->status;
            $coupon->type   = $request->type;
            $coupon->coupon_for   = $request->coupon_for;
            $coupon->start  = $request->start;
            $coupon->end    = $request->end;
            $coupon->percentage = isset($request->percentage) ? $request->percentage : 0;
            $coupon->amount     = isset($request->amount) ? $request->amount : 0;
            $coupon->complete_service = $request->complete_service > 0 ? $request->complete_service : NULL;
            $coupon->spacifice_user = $request->spacifice_user;
            $coupon->how_many_use   = $request->how_many_use;
            $coupon->total_use      = $request->how_many_use;
            $coupon->user_id        = isset($request->user_id) ? $request->user_id : 0;
            $coupon->upto_amount    = isset($request->upto_amount) ? $request->upto_amount : 0;
            
            if ($request->hasFile('image')) {
                $image             = $request->file('image');
                $imageName         = time().".".$image->getClientOriginalExtension();
                $directory         = '../mobileapi/asset/coupon/';
                $image->move($directory, $imageName);
                $imageUrl          = $imageName;
                $coupon->image   = "http://quicarbd.com/mobileapi/asset/coupon/".$imageUrl;
            }
            
            $coupon->save();
            
            $request_start = date('Y-m-d H:i:s', strtotime($request->start)); 
            $request_end   = date('Y-m-d H:i:s', strtotime($request->end)); 
            $start = DateTime::createFromFormat('Y-m-d H:i:s', $request_start, new DateTimeZone("UTC"))->format('j M, Y h:i A');
            $end   = DateTime::createFromFormat('Y-m-d H:i:s', $request_end, new DateTimeZone("UTC"))->format('j M, Y h:i A');
            
            $title   = $request->coupon;
            $message = "আপনার জন্য একটি কুইকার ডিসকাউন্ট কুপন ইস্যু করা হয়েছে। \n কুপন কোড: " .$coupon->coupon." \n কুপনের মেয়াদ : (".$start ." to ".$end.") \nকুপনের পরিমান: ".$coupon->amount."\n এই কুপনটি আপনি অ্যাডভান্স করার সময় এডজাস্ট করতে পারবেন।\n কুইকারের সাথেই থাকুন \nকুইকার বিজনেস টিম";;

            if ($request->spacifice_user == 0) {
                
                $helper = new Helper(); 
                $helper->smsNotification($type = 1, 0, $title, $message); // bell notification, 1=user
                
                $client = new Client();
                $client->request("GET", "https://quicarbd.com//mobileapi/notification/globalNotification.php?notification=global&id=1&title=".$title ."&body=".$message."&type=1&token=quicar");    
                
            } elseif ($request->spacifice_user == 1) {
                
                $msg    = strip_tags($message);
                $id     = User::find($coupon->user_id)->n_key;
                
                $helper = new Helper();
                $helper->sendSinglePartnerNotification($id, $title, $msg); //push notification send
                $helper->smsNotification($type = 1, $coupon->user_id, $title, $msg); // send notification, 1=user
            }
            
            DB::commit();
        
        } catch (\Exception $ex) {
            
            DB::rollback();
            
            return redirect()->back()->with('error_message', $ex->getMessage());
        }
        
        return redirect()->route('coupon.index',['coupon_for' => $request->coupon_for]);
    }
    
    //show edit method
     public function edit($id){
        $users  = DB::table('users')->select('id','name','phone')->orderBy('id','DESC')->get();
        $coupon = CouponList::find($id); 
        return view('quicarbd.admin.coupon.edit', compact('users','coupon'));
    }

    //update
    public function update(Request $request, $id){
        $this->validate($request,[
            'coupon' => 'required',
            'status' => 'required',
            'type'   => 'required',
            'spacifice_user'  => 'required',
            'how_many_use'  => 'required',
            'start'  => 'required',
            'end'    => 'required',
        ]);
        
        if ($request->type == 1) {
            $this->validate($request,[
                'percentage' => 'required'
            ]);
        }  
        
        if ($request->type == 2) {
            $this->validate($request,[
                'amount' => 'required'
            ]);
        }        
        
        if ($request->spacifice_user == 1) {
            $this->validate($request,[
                'user_id' => 'required'
            ]);
        }
       
        $coupon         = CouponList::find($id);
        $coupon->coupon = $request->coupon;
        $coupon->status = $request->status;
        $coupon->type   = $request->type;
        $coupon->coupon_for   = $request->coupon_for;
        $coupon->start  = $request->start;
        $coupon->end    = $request->end;
        $coupon->percentage = isset($request->percentage) ? $request->percentage : 0;
        $coupon->amount     = isset($request->amount) ? $request->amount : 0;
        $coupon->complete_service = $request->complete_service > 0 ? $request->complete_service : NULL;
        $coupon->spacifice_user = $request->spacifice_user;
        $coupon->how_many_use   = $request->how_many_use;
        $coupon->total_use      = $request->how_many_use;
        $coupon->user_id        = isset($request->user_id) ? $request->user_id : 0;
        $coupon->upto_amount    = isset($request->upto_amount) ? $request->upto_amount : 0;
        
        if($request->hasFile('image')){
            
            if(($coupon->image != null) && file_exists($coupon->image)){
                unlink($coupon->image);
            }
            
            $image             = $request->file('image');
            $imageName         = time().".".$image->getClientOriginalExtension();
            $directory         = '../mobileapi/asset/coupon/';
            $image->move($directory, $imageName);
            $imageUrl          = $imageName;
            $coupon->image = "http://quicarbd.com/mobileapi/asset/coupon/".$imageUrl;
        }
        
        if($coupon->update()){
            return redirect()->route('coupon.index',['coupon_for' => $request->coupon_for]);
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }
    
    //update
    public function block(Request $request)
    {
        $coupon         = CouponList::find($request->id);
        $coupon->status = $request->status;
        
        if($coupon->update()){
            return redirect()->route('coupon.index',['coupon_for' => $coupon->coupon_for])->with('message','Coupon blocked');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    //destroy
    public function destroy(Request $request){
        CouponList::find($request->id)->delete();
        return response()->json();
    }
    
    //used list
    public function usedList(Request $request){
        $coupon_users = DB::table('coupon_used_list')
                    ->leftjoin('coupon_list','coupon_used_list.coupon_id','coupon_list.id')
                    ->leftjoin('users','coupon_used_list.used_user_id','users.id')
                    ->select('coupon_used_list.created_at','coupon_list.coupon','users.name','users.phone')
                    ->where('coupon_for',$request->coupon_for)
                    ->orderBy('coupon_used_list.id','DESC')
                    ->paginate(12); 
                    
        return view('quicarbd.admin.coupon.used-list', compact('coupon_users'));
    }
}
