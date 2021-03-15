<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
     /**
     * show policy
     */
    public function index(Request $request){

        $policies = Policy::where('for', $request->for)
                        ->where('type', $request->type)
                        ->get();

        $for    = $request->for;
        $type   = $request->type;

        return view('quicarbd.admin.policy.cancellation', compact('policies','for','type'));
    }

     /**
     * create policy
     */
    public function create(Request $request){
        $for    = $request->for;
        $type   = $request->type;

        return view('quicarbd.admin.policy.create', compact('for','type'));
    }

     /**
     * store policy
     */
    public function store(Request $request){
        $this->validate($request,[
            'description' => 'required',
            'status' => 'required'
        ]);

        $policy = new Policy();
        $policy->for = $request->for;
        $policy->type = $request->type;
        $policy->description = $request->description;
        $policy->status = $request->status;
        $policy->save();

        if($policy->save()){
            return redirect()->route('policy.index',['for'=>$request->for, 'type'=>$request->type])->with('message','Policy added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

     /**
     * edit policy
     */
    public function edit($id)
    {
        $policy = Policy::find($id);
        return view('quicarbd.admin.policy.edit', compact('policy'));
    }

     /**
     * store policy
     */
    public function update(Request $request, $id){
        $this->validate($request,[
            'description' => 'required',
            'status' => 'required'
        ]);

        $policy = Policy::find($id);
        $policy->for = $request->for;
        $policy->type = $request->type;
        $policy->description = $request->description;
        $policy->status = $request->status;
        $policy->save();

        if($policy->update()){
            return redirect()->route('policy.index',['for'=>$request->for, 'type'=>$request->type])->with('message','Policy added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    //destroy
    public function destroy(Request $request){
        Policy::find($request->id)->delete();
        return response()->json();
    }
}
