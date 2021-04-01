<?php

namespace App\Jobs;

use App\Http\Lib\Helper;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $helper = new Helper(); 

        $request['for'] = $this->details['for'];
        $request['status'] = $this->details['status'];
        $request['title'] = $this->details['title'];
        $request['message'] = $this->details['message'];
        $request['notification'] = $this->details['notification'];

        if($request['for'] == 1){
            $users = User::where('account_status', $request['status'])->get();                             
            foreach($users as $user){
                if($request['notification'] == 0){
                    $helper->sendSinglePartnerNotification($user->n_key, $request['title'], $request['message']); //push notification send
                }else if($request['notification'] == 1){
                    $helper->sendSinglePartnerNotification($user->n_key, $request['title'], $request['message']); //push notification send
                    $helper->smsNotification($type = 1, $user->id, $title, $msg);//bell notification
                }else{ 
                    $helper->sendSinglePartnerNotification($user->n_key, $request['title'], $request['message']); //push notification send
                    $helper->smsSend($user->phone, $request['message']); // sms send
                }
            }
        }else{ 
            $owners = Owner::where('account_status', $request['status'])->get();
            foreach($owners as $owner){
                if($request['notification'] == 0){
                    $helper->sendSinglePartnerNotification($owner->n_key, $request['title'], $request['message']); //push notification send
                }else if($request['notification'] == 1){          
                    $helper->sendSinglePartnerNotification($owner->n_key, $request['title'], $request['message']);
                    $helper->smsNotification($type = 12, $owner->id, $title, $msg); //bell notification
                }else{
                    $helper->sendSinglePartnerNotification($owner->n_key, $request['title'], $request['message']); //push notification send
                    $helper->smsSend($owner->phone, $request['message']); // sms send                   
                }                
            }
        }   
    }
}
