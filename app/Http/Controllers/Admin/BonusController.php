<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\User;
use App\Models\Bonus;
use App\Models\BonusCompleteList;
use App\Http\Lib\Helper;
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
                        ->select('users.id','users.name','users.phone', DB::raw("COUNT(ride_list.id) as total_completed"))
                        ->where('ride_list.start_time', '>=', $request->start)
                        ->where('ride_list.start_time', '<=', $request->end)
                        ->where('ride_list.status', 4)
                        ->groupBy('ride_list.id','users.id','users.name','users.phone')
                        ->get();
                        
            $records = $records->where('total_completed', 1);
            
        } else { 
            
            $records = DB::table('ride_biting')
                        ->leftjoin('ride_list','ride_biting.ride_id','ride_list.id')
                        ->leftjoin('owners','ride_biting.owner_id','owners.id')
                        ->select('owners.id','owners.name','owners.phone',DB::raw("COUNT(ride_list.id) as total_completed"))
                        ->where('ride_biting.status', 1)
                        ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                        ->where('ride_list.start_time', '>=', $request->start)
                        ->where('ride_list.start_time', '<=', $request->end)
                        ->where('ride_list.status', 4)
                        ->groupBy('ride_list.id','owners.id','owners.name','owners.phone')
                        ->get();
                        
            $records = $records->where('total_completed', $request->completed);
        }
        
        $type = $request->type;
        $required_completed = $request->completed;
        $bonus_id = $request->bonus_id;
     
        return view('quicarbd.admin.bonus.capable', compact('records', 'type', 'required_completed','bonus_id'));
    }
    
    /**
     * Pay Now
    */ 
    public function payNow (Request $request) 
    {
        $bonus = Bonus::find($request->bonus_id);
        
        if ($request->type == 0) { //0 mean user
        
            $userAccount = new UserAccount();
            $userAccount->amount          = $bonus->bonus_amount;
            $userAccount->adjust_cashback = 0;
            $userAccount->adjust_quicar_balance = 0;
            $userAccount->discount        = 0;
            $userAccount->online_payment  = 0;
            $userAccount->tnx_id          = time();
            $userAccount->type            = 1; // 1 credit, user income
            $userAccount->income_from     = 1; // 1 mean ride
            $userAccount->history_id      = $request->bonus_id;
            $userAccount->reason          = 'Ride bonus added';
            $userAccount->user_id         = $request->id;
            $userAccount->save();
            
            $user_n_key   = User::find($request->id)->n_key;
            $title  = 'Quicar Bonus';
            $msg    = 'Dear, '.$request->name.' Bonus: '. $bonus->bonus_amount.' Tk added to your account. Thanks Team Quicar'; 
            $helper = new Helper(); 
            $helper->sendSinglePartnerNotification($user_n_key, $title, $msg); //push notification send to user
            $helper->smsNotification($type=1, $request->id, $title, $msg); // send notification, 1=user
        }
    }
}
