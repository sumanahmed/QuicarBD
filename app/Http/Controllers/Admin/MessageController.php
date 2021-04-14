<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MessageController extends Controller
{
    // show all partner message
    public function partnerMessage (Request $request) 
    {
        $query = DB::table('owner_message_list')->orderBy('id','DESC');

        if ($request->name) {
            $query = $query->where('owners.name', 'like', "{$request->name}%");
        }
        
        if ($request->phone) {
            $query = $query->where('owners.phone', $request->phone);
        }
        
        $partners = $query->paginate(12);
        
        return view('quicarbd.admin.message.partner', compact('partners'));
    }
}
