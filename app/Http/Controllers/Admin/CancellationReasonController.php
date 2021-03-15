<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidCancelList;
use App\Models\Policy;
use Illuminate\Http\Request;

class CancellationReasonController extends Controller
{
     /**
     * show cancellation reason
     */
    public function index(Request $request){

        $reasons = BidCancelList::where('app_type', $request->app_type)
                        ->where('type', $request->type)
                        ->get();

        $app_type    = $request->app_type;
        $type   = $request->type;

        return view('quicarbd.admin.reason.cancellation', compact('reasons','app_type','type'));
    }

     /**
     * create policy
     */
    public function create(Request $request){
        $app_type   = $request->app_type;
        $type       = $request->type;
        return view('quicarbd.admin.reason.create', compact('app_type','type'));
    }

     /**
     * store policy
     */
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'bn_name' => 'required',
            'status' => 'required'
        ]);

        $reason             = new BidCancelList();
        $reason->app_type   = $request->app_type;
        $reason->type       = $request->type;
        $reason->name       = $request->name;
        $reason->bn_name    = $request->bn_name;
        $reason->status     = $request->status;
        $reason->save();

        if($reason->save()){
            return redirect()->route('policy.index',['app_type'=>$request->app_type, 'type'=>$request->type])->with('message','Policy added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

     /**
     * edit policy
     */
    public function edit($id)
    {
        $reason = BidCancelList::find($id);
        return view('quicarbd.admin.reason.edit', compact('reason'));
    }

     /**
     * store policy
     */
    public function update(Request $request, $id){
        $this->validate($request,[
            'name' => 'required',
            'bn_name' => 'required',
            'status' => 'required'
        ]);

        $reason             = BidCancelList::find($id);
        $reason->app_type   = $request->app_type;
        $reason->type       = $request->type;
        $reason->name       = $request->name;
        $reason->bn_name    = $request->bn_name;
        $reason->status     = $request->status;
        $reason->update();

        if($reason->update()){
            return redirect()->route('reason.index',['app_type'=>$request->app_type, 'type'=>$request->type])->with('message','Cancellation reason updated successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    //destroy
    public function destroy(Request $request){
        BidCancelList::find($request->id)->delete();
        return response()->json();
    }
}
