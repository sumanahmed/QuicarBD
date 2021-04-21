<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CouponList;
use App\Models\CouponUsedList;
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
        
        $coupons= $query->paginate(12); 
        
        $coupon_for= $request->coupon_for;
        $users  = DB::table('users')->select('id','name')->orderBy('id','DESC')->get();
        
        return view('quicarbd.admin.coupon.index', compact('coupons','coupon_for','users'));
    }     
    
    //show create method
     public function create(Request $request){
        $users  = DB::table('users')->select('id','name')->orderBy('id','DESC')->get();
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
       
        $coupon         = new CouponList();
        $coupon->coupon = $request->coupon;
        $coupon->status = $request->status;
        $coupon->type   = $request->type;
        $coupon->coupon_for   = $request->coupon_for;
        $coupon->start  = $request->start;
        $coupon->end    = $request->end;
        $coupon->percentage = isset($request->percentage) ? $request->percentage : 0;
        $coupon->amount     = isset($request->amount) ? $request->amount : 0;
        $coupon->spacifice_user = $request->spacifice_user;
        $coupon->user_id        = isset($request->user_id) ? $request->user_id : 0;
        $coupon->upto_amount    = isset($request->upto_amount) ? $request->upto_amount : 0;
        
        if($coupon->save()){
            return redirect()->route('coupon.index',['coupon_for' => $request->coupon_for]);
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }
    
    //show edit method
     public function edit($id){
        $users  = DB::table('users')->select('id','name')->orderBy('id','DESC')->get();
        $coupon = CouponList::find($id); 
        return view('quicarbd.admin.coupon.edit', compact('users','coupon'));
    }

    //update
    public function update(Request $request, $id){
        $this->validate($request,[
            'coupon' => 'required',
            'status' => 'required',
            'type'   => 'required',
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
        $coupon->spacifice_user = $request->spacifice_user;
        $coupon->user_id        = isset($request->user_id) ? $request->user_id : 0;
        $coupon->upto_amount    = isset($request->upto_amount) ? $request->upto_amount : 0;
        
        if($coupon->update()){
            return redirect()->route('coupon.index',['coupon_for' => $request->coupon_for]);
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
