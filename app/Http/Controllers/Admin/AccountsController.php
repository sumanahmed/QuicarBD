<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Lib\Helper;
use App\Models\Owner;
use App\Models\UserAccount;
use App\Models\WithdrawListPartner;
use App\Models\WithdrawMethodPartner;
use Illuminate\Http\Request;
use DB;

class AccountsController extends Controller
{
    /**
     * show summary
     */
    public function summary()
    {
        
        $debit  = DB::table('user_account')->where('type', 0)->sum('amount');
        $credit = DB::table('user_account')->where('type', 1)->sum('amount');
        
        $data['user_balance']   = DB::table('users')->sum('balance'); 
        $data['user_cashback']  = DB::table('users')->sum('cash_back_balance');
        $data['partner_balance']= DB::table('owners')->sum('current_balance');
        $data['quicar_income']  = $debit - $credit;
        
        return view('quicarbd.admin.accounts.summary', $data);
    }    
    
    /**
     * show transaction
     */
    public function transaction (Request $request)
    {
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-30 days'));
        $end_date   = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : date('Y-m-d');
        
        $query = DB::table('user_account')
                    ->leftjoin('users','user_account.user_id','users.id')
                    ->select('user_account.*','users.phone')
                    // ->where('user_account.type', 0)
                    //->where('user_account.advance_payment', 1)
                    ->whereDate('user_account.created_at','>=', $start_date)
                    ->whereDate('user_account.created_at','<=', $end_date)
                    ->orderBy('user_account.id','DESC');

        if ($request->phone) {
            $query = $query->where('users.phone', $request->phone);
        }        
        
        if (isset($request->type) && $request->type != 100) {
            $query = $query->where('user_account.type', $request->type);
        }

        $transactions = $query->paginate(12);
        
        return view('quicarbd.admin.accounts.transaction', compact('transactions'));
    }

    /**
     * show refund
     */
    public function refund (Request $request)
    {
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-30 days'));
        $end_date   = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : date('Y-m-d');
        
        $query = DB::table('user_account')
                    ->leftjoin('users','user_account.user_id','users.id')
                    ->select('user_account.*','users.phone',
                        'users.balance as user_balance','users.cash_back_balance as cashback'
                    )
                    ->where('user_account.id_refund', 1)
                    ->whereDate('user_account.created_at','>=', $start_date)
                    ->whereDate('user_account.created_at','<=', $end_date)
                    ->orderBy('user_account.id','DESC');

        $query->when(request('filter_by') == 'date', function ($q) {
            return $q->orderBy('created_at', request('ordering_rule', 'desc'));
        });

        if ($request->phone) {
            $query = $query->where('users.phone', $request->phone);
        }

        $refunds = $query->paginate(12);

        return view('quicarbd.admin.accounts.refund', compact('refunds'));
    }

    /**
     * show user balance
     */
    public function userBalance (Request $request)
    {
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-30 days'));
        $end_date   = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : date('Y-m-d');
     
        $query = DB::table('users')
                    ->select('users.id','users.name','users.phone','users.balance','users.cash_back_balance')                    
                    ->whereDate('created_at','>=', $start_date)
                    ->whereDate('created_at','<=', $end_date)
                    ->where('account_status', 1)
                    ->orderBy('id','DESC');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }

        $balances = $query->paginate(12);

        return view('quicarbd.admin.accounts.user-balance',compact('balances'));
    }

    /**
     * show partner balance
     */
    public function partnerBalance (Request $request)
    {
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-30 days'));
        $end_date   = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : date('Y-m-d');
        
        $query = DB::table('owner_account')
                    ->leftjoin('owners','owner_account.owner_id','owners.id')
                    ->leftjoin('withdraw_list_partner','owner_account.owner_id','withdraw_list_partner.owner_id')
                    ->selectRaw('owners.id, owners.name, owners.phone,
                        sum(owners.current_balance) as balance,
                        sum(owner_account.amount) as total_amount,
                        sum(owner_account.quicar_charge) as total_commission,
                        sum(withdraw_list_partner.amount) as total_withdraw'
                    )
                    ->where('owner_account.type', 1)
                    ->whereDate('owner_account.created_at', '>=', $start_date)
                    ->whereDate('owner_account.created_at', '<=', $end_date)
                    ->orderBy('owner_account.id','DESC')
                    ->groupBy('owners.id','owners.name','owners.phone');

        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }

        $balances = $query->paginate(12);

        return view('quicarbd.admin.accounts.partner-balance', compact('balances'));
    }

    /**
     * show withdraw
     */
    public function withdraw (Request $request)
    {   
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-30 days'));
        $end_date   = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : date('Y-m-d');
        
        $query = DB::table('withdraw_list_partner')
                    ->leftjoin('owners','withdraw_list_partner.owner_id','owners.id')
                    ->leftjoin('withdraw_method_partner','withdraw_list_partner.withdraw_mathord','withdraw_method_partner.id')
                    ->select('withdraw_list_partner.*',
                        'owners.name', 'owners.phone', 'owners.current_balance',
                        'withdraw_method_partner.name as withdraw_method'
                    )
                    ->whereDate('withdraw_list_partner.created_at', '>=', $start_date)
                    ->whereDate('withdraw_list_partner.created_at', '<=', $end_date)
                    ->orderBy('withdraw_list_partner.id','DESC');

        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }

        if ($request->status) {
            $query = $query->where('withdraw_list_partner.status', $request->status);
        }

        $withdraws = $query->paginate(12); 

        return view('quicarbd.admin.accounts.withdraw', compact('withdraws'));
    }

    /**
     * withdraw cancel
     */
    public function withdrawCancel (Request $request) 
    {   
        $helper = new Helper();
        $withdraw = WithdrawListPartner::select('id','amount','number','withdraw_mathord')->where('id',$request->id)->first();
        $method = WithdrawMethodPartner::find($withdraw->withdraw_mathord)->name;
        $owner_name = Owner::find($request->owner_id)->name;
        $title = "Withdraw Approved";
        $body  = "Dear ". $owner_name ." Your Withdrawal request denied : ". $withdraw->amount ." Tk to your given ".$method." number : ".$withdraw->number." Please Call for further support 01611822829. Thank You Team Quicar";
        $helper->smsNotification($type = 2, $request->owner_id, $title, $body); // send bell notification
        $helper->smsSend($request->phone, $body); // sms send
        $withdraw->status = 2;
        $withdraw->update();
    }

    /**
     * withdraw cancel
     */
    public function withdrawAccept (Request $request) 
    {  
        $helper = new Helper();
        $withdraw = WithdrawListPartner::select('id','amount','number','withdraw_mathord')->where('id', $request->id)->first();
        $method = WithdrawMethodPartner::find($withdraw->withdraw_mathord)->name;
        $owner_name = Owner::find($request->owner_id)->name;
        $title = "Withdraw Approved";
        $body  = "Dear ". $owner_name ." We transferred money : ". $withdraw->amount ." Tk to your given ".$method." number : ".$withdraw->number." Thank You Team Quicar";
        $helper->smsNotification($type = 2, $request->owner_id, $title, $body); // send bell notification
        $helper->smsSend($request->phone, $body); // sms send
        $withdraw->status = 1;
        $withdraw->update();
    }
}
