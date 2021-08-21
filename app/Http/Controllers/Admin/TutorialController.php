<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutorial;
use DB;

class TutorialController extends Controller
{
    /**
     * show all tutorial
    */
    public function index (Request $request) 
    {
        $query = DB::table('youtubeVideos')->orderBy('id', 'DESC');
        
        if ($request->title) {
            $query = $query->where('title', $request->title);
        }
        
        if ($request->video_id) {
            $query = $query->where('video_id', $request->video_id);
        }
        
        if ($request->type) {
            $query = $query->where('type', $request->type);
        }
        
        $type = $request->type;
        
        $tutorials = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.tutorial.index', compact('tutorials','type'));
    }    
    
    /**
     * tutorial create page
    */
    public function create (Request $request) 
    {   
        $type           = $request->type;
        $last_record    = Tutorial::select('serial')->orderBy('serial','DESC')->first();
        $serial         = $last_record != null ? $last_record->serial + 1 : 1;
        return view('quicarbd.admin.tutorial.create', compact('type','serial'));
    }   
    
    /**
     * bonus store
    */
    public function store (Request $request) 
    {
        $this->validate($request, [
            'title'     => 'required',
            'type'      => 'required',
            'video_id'  => 'required',
        ]);
        
        Tutorial::create($request->all());
        
        return redirect()->route('tutorial.index')->with('message', 'Tutorial added successfully');
    }
    
    /**
     * bonus edit page
    */
    public function edit ($id) 
    {   
        $tutorial = Tutorial::findOrFail($id);
        return view('quicarbd.admin.tutorial.edit', compact('tutorial'));
    }   
    
    /**
     * tutorial update
    */
    public function update (Request $request, $id) 
    {
        $this->validate($request, [
            'title'     => 'required',
            'type'      => 'required',
            'video_id'  => 'required',
        ]);
        
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->update($request->all());
        
        return redirect()->route('tutorial.index')->with('message', 'Tutorial updated successfully');
    }   
    
    /**
     * tutorial destroy
    */
    public function destroy (Request $request) 
    {
        $tutorial = Tutorial::findOrFail($request->id);
        
        if ($tutorial->delete()) {
            return redirect()->route('tutorial.index')->with('message', 'Tutorial deleted successfully');
        } else {
            return redirect()->route('tutorial.index')->with('error_message', 'Sorry, something went wrong');
        }        
    } 
}
