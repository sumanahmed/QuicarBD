<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WithdrawController extends Controller
{
    //Pending list
    public function pending(Request $request)
    {
        $query = DB::table('withdraw_list_partner')
                    ->leftjoin('withdraw_method_partner','withdraw_list_partner.withdraw_mathord','withdraw_method_partner.id')
                    ->leftjoin('owners','withdraw_list_partner.owner_id','owners.id')
                    ->select('withdraw_list_partner.*',
                            'withdraw_method_partner.name as withdraw_method',
                            'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('withdraw_list_partner.amount','!=', 0)
                    ->where('withdraw_list_partner.number','!=', null)
                    ->where('withdraw_list_partner.status', 0)
                    ->orderBy('withdraw_list_partner.id','ASC');
                    
        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        $withdraws = $query->paginate(12)->appends(request()->query());;
        
        return view('quicarbd.admin.withdraw.pending', compact('withdraws'));
    }  
    
    //complete list
    public function complete(Request $request)
    {
        $query = DB::table('withdraw_list_partner')
                    ->leftjoin('withdraw_method_partner','withdraw_list_partner.withdraw_mathord','withdraw_method_partner.id')
                    ->leftjoin('owners','withdraw_list_partner.owner_id','owners.id')
                    ->select('withdraw_list_partner.*',
                            'withdraw_method_partner.name as withdraw_method',
                            'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('withdraw_list_partner.amount','!=', 0)
                    ->where('withdraw_list_partner.number','!=', null)
                    ->where('withdraw_list_partner.status', 1)
                    ->orderBy('withdraw_list_partner.id','ASC');
                    
        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        $withdraws = $query->paginate(12)->appends(request()->query());;
        
        return view('quicarbd.admin.withdraw.complete', compact('withdraws'));
    }
    
    //cancel list
    public function cancel(Request $request)
    {
        $query = DB::table('withdraw_list_partner')
                    ->leftjoin('withdraw_method_partner','withdraw_list_partner.withdraw_mathord','withdraw_method_partner.id')
                    ->leftjoin('owners','withdraw_list_partner.owner_id','owners.id')
                    ->select('withdraw_list_partner.*',
                            'withdraw_method_partner.name as withdraw_method',
                            'owners.name as owner_name','owners.phone as owner_phone'
                    )
                    ->where('withdraw_list_partner.amount','!=', 0)
                    ->where('withdraw_list_partner.number','!=', null)
                    ->where('withdraw_list_partner.status', 2)
                    ->orderBy('withdraw_list_partner.id','ASC');
                    
        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        $withdraws = $query->paginate(12)->appends(request()->query());;
        
        return view('quicarbd.admin.withdraw.cancel', compact('withdraws'));
    }  
}
