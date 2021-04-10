<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * show income
     */
    public function income (Request $request)
    {
        return view('quicarbd.admin.accounts.income');
    }

    /**
     * show refund
     */
    public function refund (Request $request)
    {
        return view('quicarbd.admin.accounts.refund');
    }

    /**
     * show user balance
     */
    public function userBalance (Request $request)
    {
        return view('quicarbd.admin.accounts.user-balance');
    }

    /**
     * show partner balance
     */
    public function partnerBalance (Request $request)
    {
        return view('quicarbd.admin.accounts.partner-balance');
    }

    /**
     * show withdraw
     */
    public function withdraw (Request $request)
    {
        return view('quicarbd.admin.accounts.withdraw');
    }
}
