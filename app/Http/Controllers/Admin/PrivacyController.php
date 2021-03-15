<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
     /**
     * show privacy
     */
    public function index(Request $request){

        $privacies = Privacy::where('for', $request->for)
                        ->where('type', $request->type)
                        ->get();

        $for    = $request->for;
        $type   = $request->type;

        return view('quicarbd.admin.privacy.index', compact('privacies','for','type'));
    }

     /**
     * create privacy
     */
    public function create(Request $request){
        $for    = $request->for;
        $type   = $request->type;

        return view('quicarbd.admin.privacy.create', compact('for','type'));
    }

     /**
     * store privacy
     */
    public function store(Request $request){
        $this->validate($request,[
            'description' => 'required',
        ]);

       $privacy = new Privacy();
       $privacy->for = $request->for;
       $privacy->type = $request->type;
       $privacy->description = $request->description;
       $privacy->save();

        if($privacy->save()){
            return redirect()->route('privacy.index',['for'=>$request->for, 'type'=>$request->type])->with('message','privacy added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

     /**
     * edit privacy
     */
    public function edit($id)
    {
        $privacy = Privacy::find($id);
        return view('quicarbd.admin.privacy.edit', compact('privacy'));
    }

     /**
     * store privacy
     */
    public function update(Request $request, $id){
        $this->validate($request,[
            'description' => 'required',
        ]);

       $privacy = Privacy::find($id);
       $privacy->for = $request->for;
       $privacy->type = $request->type;
       $privacy->description = $request->description;
       $privacy->save();

        if($privacy->update()){
            return redirect()->route('privacy.index',['for'=>$request->for, 'type'=>$request->type])->with('message','privacy added successfully');
        }else{
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    //destroy
    public function destroy(Request $request){
        Privacy::find($request->id)->delete();
        return response()->json();
    }
}
