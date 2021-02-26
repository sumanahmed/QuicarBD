<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    // admin login page
    public function login(){
        return view('quicarbd.admin.auth.login');
    }

    // log the admin in
    public function signin(Request $request){
        $admin = Admin::select('type')->where('email', $request->email)->first();
        if($admin != null && $admin['type'] == 1){
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('dashboard')->with('message','Successfully loggedin !');
            }else{
                return redirect()->route('admin.login')->with('error_message','Email/Password is wrong !');;
            }
        }else{
            return redirect()->route('admin.login')->with('error_message','You are not admin');;
        }
    }

    // backend admin log out
    public function logout(Request $request){
        if(Auth::guard('admin')->check()){
            return 'logged innn';
            Auth::guard('admin')->logout();
        }
        return redirect()->route('admin.login');
    }
}
