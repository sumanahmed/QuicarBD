<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bonus;
use App\Models\BonusCompleteList;
use DB;

class BonusController extends Controller
{
    /**
     * show all bonus
    */
    public function index (Request $request) 
    {
        $query = DB::table('bonus')->orderBy('id', 'DESC');
        
        if ($request->completed_ride) {
            $query = $query->where('completed_ride', $request->completed_ride);
        }
        
        if ($request->bonus_amount) {
            $query = $query->where('bonus_amount', $request->bonus_amount);
        }
        
        if ($request->offer_starting_time) {
            $query = $query->where('offer_starting_time', $request->offer_starting_time);
        }
        
        if ($request->offer_finishing_time) {
            $query = $query->where('offer_finishing_time', $request->offer_finishing_time);
        }
        
        if ($request->type) {
            $query = $query->where('type', $request->type);
        }
        
        if ($request->bonus_for && $request->bonus_for != 0) {
            $query = $query->where('bonus_for', $request->bonus_for);
        }
        
        $type = $request->type;
        
        $bonuses = $query->paginate(12)->appends(request()->query());
        
        return view('quicarbd.admin.bonus.index', compact('bonuses','type'));
    }    
    
    /**
     * bonus create page
    */
    public function create (Request $request) 
    {   
        $type = $request->type;
        return view('quicarbd.admin.bonus.create', compact('type'));
    }   
    
    /**
     * bonus store
    */
    public function store (Request $request) 
    {
        $this->validate($request, [
            'completed_ride'        => 'required',
            'bonus_amount'          => 'required',
            'offer_starting_time'   => 'required',
            'offer_finishing_time'  => 'required',
            'bonus_for'             => 'required',
        ]);
        
        Bonus::create($request->all());
        
        return redirect()->route('bonus.index')->with('message', 'Bonus added successfully');
    }
    
    /**
     * bonus edit page
    */
    public function edit ($id) 
    {   
        $bonus = Bonus::findOrFail($id);
        return view('quicarbd.admin.bonus.edit', compact('bonus'));
    }   
    
    /**
     * bonus update
    */
    public function update (Request $request, $id) 
    {
        $this->validate($request, [
            'completed_ride'        => 'required',
            'bonus_amount'          => 'required',
            'offer_starting_time'   => 'required',
            'offer_finishing_time'  => 'required',
            'bonus_for'             => 'required',
        ]);
        
        $bonus = Bonus::findOrFail($id);
        $bonus->update($request->all());
        
        return redirect()->route('bonus.index')->with('message', 'Bonus updated successfully');
    }   
    
    /**
     * bonus destroy
    */
    public function destroy (Request $request) 
    {
        $bonus = Bonus::findOrFail($request->id);
        
        return redirect()->route('bonus.index')->with('message', 'Bonus deleted successfully');
    } 
    
    /**
     * bonus capable
    */
    public function capable (Request $request) 
    {
        if ($request->type == 0) { //0 mean = user
        
            $records = DB::table('ride_list')
                        ->join('users','ride_list.user_id','users.id')
                        ->select('users.name','users.phone', DB::raw("COUNT(ride_list.id) as total_completed"))
                        ->where('ride_list.start_time', '>=', $request->start)
                        ->where('ride_list.start_time', '<=', $request->end)
                        ->where('ride_list.status', 4)
                        ->groupBy('ride_list.id','users.name','users.phone')
                        ->get();
                        
            $records = $records->where('total_completed', $request->total);
            
        } else { 
            
            $records = DB::table('ride_biting')
                        ->leftjoin('ride_list','ride_biting.ride_id','ride_list.id')
                        ->leftjoin('owners','ride_biting.owner_id','owners.id')
                        ->select('owners.name','owners.phone',DB::raw("COUNT(ride_list.id) as total_completed"))
                        ->where('ride_biting.status', 1)
                        ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                        ->where('ride_list.start_time', '>=', $request->start)
                        ->where('ride_list.start_time', '<=', $request->end)
                        ->where('ride_list.status', 4)
                        ->get();
                        
            $records = $records->where('total_completed', $request->total);
        }
        
        $type = $request->type;
        $required_completed = $request->total;
        
        return view('quicarbd.admin.bonus.capable', compact('records', 'type', 'required_completed'));
    }
}
