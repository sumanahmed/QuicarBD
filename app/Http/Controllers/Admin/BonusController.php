<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\OwnerAccount;
use App\Models\UserAccount;
use App\Models\User;
use App\Models\Bonus;
use App\Models\BonusCompleteList;
use App\Http\Lib\Helper;
use Carbon\Carbon;
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
        
        $bonus_exist_in_complete = BonusCompleteList::where('bonus_id', $request->id)->first();
        
        if (!$bonus_exist_in_complete) {
            $bonus->delete();
            return redirect()->route('bonus.index')->with('message', 'Bonus deleted successfully');
        } else {
            return redirect()->route('bonus.index')->with('error_message', 'Sorry, this bonus has transaction');
        }
        
    } 
    
    /**
     * bonus capable
    */
    public function capable (Request $request) 
    {  
        $current_date_time = Carbon::now()->toDateTimeString(); 
        $bonus = Bonus::find($request->bonus_id);
        if ($current_date_time <= $bonus->offer_finishing_time) {
            if ($request->type == 0) { //0 mean = user
        
                $records = DB::table('ride_list')
                            ->join('users','ride_list.user_id','users.id')
                            ->select('users.id','users.name','users.phone', DB::raw("COUNT(ride_list.id) as total_completed"))
                            ->where('ride_list.start_time', '>=', $request->start)
                            ->where('ride_list.start_time', '<=', $request->end)
                            ->where('ride_list.status', 4)
                            ->groupBy('ride_list.id','users.id','users.name','users.phone')
                            ->get();
                            
                $records = $records->where('total_completed', $request->completed);
                
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
        } else {
            return redirect()->back()->with('error_message','Bonus already expired');
        }
        
    }
    
    /**
     * Pay Now
    */ 
    public function payNow (Request $request) 
    {
        $bonus = Bonus::find($request->bonus_id);
        
        DB::beginTransaction();
        
        try {
        
            if ($request->type == 0) { //0 mean user
            
                $userAccount = new UserAccount();
                $userAccount->amount          = $bonus->bonus_amount;
                $userAccount->adjust_cashback = 0;
                $userAccount->adjust_quicar_balance = $bonus->bonus_amount;
                $userAccount->discount        = 0;
                $userAccount->online_payment  = 0;
                $userAccount->tnx_id          = time();
                $userAccount->type            = 1; // 1 credit, user income
                $userAccount->income_from     = 5; // 5 mean bonus
                $userAccount->history_id      = $request->bonus_id;
                $userAccount->reason          = 'Ride bonus added';
                $userAccount->user_id         = $request->id;
                $userAccount->save();
                
                $user = User::find($request->id);
                $user->balance = ($user->balance + $bonus->bonus_amount);
                $user->update();
                
                $title  = 'Quicar Bonus';
                $msg    = "Dear, ". $request->name. " Quicar added Bonus: ".$bonus->bonus_amount.' Tk, to your account. Thanks Team Quicar'; 
                
                $helper = new Helper();
                $helper->sendSinglePartnerNotification($user->n_key, $title, $msg); //push notification send to user
                $helper->smsNotification($type=1, $user->id, $title, $msg); // send notification, 1=user
                
            } else { //0 mean user
            
                $parnterAccount = new OwnerAccount();
                $parnterAccount->amount         = $bonus->bonus_amount;
                $parnterAccount->quicar_charge  = 0;
                $parnterAccount->net_amount     = $bonus->bonus_amount;
                $parnterAccount->type           = 1; //1=credit, partner income
                $parnterAccount->income_from    = 5; //5 mean bonus
                $parnterAccount->reason_text    = 'Bonus added';
                $parnterAccount->history_id     = $request->bonus_id;
                $parnterAccount->owner_id       = $request->id;
                $parnterAccount->status         = 1;
                $parnterAccount->save();
                
                $owner = Owner::find($request->id);
                $owner->current_balance = ($owner->current_balance + $bonus->bonus_amount);
                $owner->update();
                
                $title  = 'Quicar Bonus';
                $msg    = "Dear, ". $request->name. " Quicar added Bonus: ".$bonus->bonus_amount.' Tk, to your account. Thanks Team Quicar'; 
                
                $helper = new Helper(); 
                $helper->sendSinglePartnerNotification($owner->n_key, $title, $msg); //push notification send to partner
                $helper->smsNotification($type=2, $request->id, $title, $msg); // send notification, 2=partner
            }
            
            $bonus_complete = new BonusCompleteList();
            $bonus_complete->bonus_id = $request->bonus_id;
            $bonus_complete->receiver_id = $request->id;
            $bonus_complete->type  = $request->type;
            $bonus_complete->save();
            
            DB::commit();
            
        } catch (Exception $ex) {
            
            DB::rollback();
            
            return redirect()->back()->with('error_message', 'Sorry '. $ex->getMessage());
        }
        
        return view('quicarbd.admin.bonus.index')->with('message', 'Bonus paid successfully');
    }
    
    /**
     * Paid list
    */ 
    public function paidList ($id)
    {
        $bonus = Bonus::find($id);
        
        if ($bonus->type == 0) { //0 mean user
            $bonus_completed_user = BonusCompleteList::select('receiver_id')->where('bonus_id', $id)->get()->toArray();
            $users = User::whereIn('receiver_id', $bonus_completed_user)->get();
        } else {
            $bonus_completed_owner = BonusCompleteList::select('receiver_id')->where('bonus_id', $id)->get()->toArray();
            $users = Owner::whereIn('receiver_id', $bonus_completed_owner)->get();
        }
        
        return view('quicarbd.admin.bonus.paid', compact('bonus', 'users'));
    }
}
