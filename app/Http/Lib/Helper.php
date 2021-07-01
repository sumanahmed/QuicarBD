<?php
namespace App\Http\Lib;

use App\Models\CarType;
use App\Models\City;
use App\Models\District;
use App\Models\OwnerNotification;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\BidCancelList;
use GuzzleHttp\Client;

class Helper
{
    /**
     * send single partner push notification
     */
    public function sendSinglePartnerNotification($id, $title, $message) {
        $id     = $id;
        $title  = $title;
        $body   = $message;
        $client = new Client();
        //https://quicarbd.com/mobileapi/notification/partnerNotification.php?notification=single&title=Title here&body=body here&id=0&image=https://dyl80ryjxr1ke.cloudfront.net/external_assets/hero_examples/hair_beach_v1785392215/original.jpeg&type=1&token=dFEPwUvKRYCicAqiIuVnrz:APA91bErVnBTRnmA7_9W3MEuZB8k0AjwgTKPpTDjbS_WB8ZhI0HbAuQ78wfPV-CBWHoaQfKfYxiAATjAfEI2LF2u5JBT-N214Yn-HoksFigXJ5xbUu6ackwi6cUnD-GXdumzMXPfLK-s
        //$client->request("GET", "https://quicarbd.com//mobileapi/notification/partnerNotification.php?notification=single&id=".$id."&title=".$title ."&body=".$body."&image=https://dyl80ryjxr1ke.cloudfront.net/external_assets/hero_examples/hair_beach_v1785392215/original.jpeg&type=1&token=dFEPwUvKRYCicAqiIuVnrz:APA91bErVnBTRnmA7_9W3MEuZB8k0AjwgTKPpTDjbS_WB8ZhI0HbAuQ78wfPV-CBWHoaQfKfYxiAATjAfEI2LF2u5JBT-N214Yn-HoksFigXJ5xbUu6ackwi6cUnD-GXdumzMXPfLK-s");
        //$client->request("GET", "https://quicarbd.com//mobileapi/notification/partnerNotification.php?notification=single&id=1&title=".$title ."&body=".$body."&type=1&image=https://dyl80ryjxr1ke.cloudfront.net/external_assets/hero_examples/hair_beach_v1785392215/original.jpeg&type=1&token=".$id);
        $client->request("GET", "https://quicarbd.com//mobileapi/notification/partnerNotification.php?notification=single&id=1&title=".$title ."&body=".$body."&type=1&token=".$id);
                                
    }

    /**
     * sms send
     */
    public function smsSend($phone, $msg) {
        $client = new Client();            
        $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $phone ."&message=".$msg);
    }

    /**
     * send notification
     */
    public function smsNotification($type, $id, $title, $msg) {
        if($type == 1) {

            $userNotification            = new UserNotification();
            $userNotification->user_id   = $id; 
            $userNotification->title     = $title; 
            $userNotification->description = $msg; 
            $userNotification->save(); 

        } else {
            $partnerNofification            = new OwnerNotification();
            $partnerNofification->owner_id  = $id; 
            $partnerNofification->title     = $title; 
            $partnerNofification->description = $msg; 
            $partnerNofification->save(); 
        }
    }
    
    
    /**
     * send bell & notification
     */
    public function sendBellAndPushNotification($tokenList) 
    {
        define('API_ACCESS_KEY','AAAAASeLFFk:APA91bH1mQPDwxElZ5PIV_0_6_mjZr9XkoX7zIkWPPlMeMWDfg9cs13OoC4kHgNqXmHst1qWsR80gJVuvN0mHKkLh68WSaU8sCqBMptAr8NaiB4tXh_mnyuLlFrH0sBshhrIyvzjqyH1');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        
        // $token='dFEPwUvKRYCicAqiIuVnrz:APA91bErVnBTRnmA7_9W3MEuZB8k0AjwgTKPpTDjbS_WB8ZhI0HbAuQ78wfPV-CBWHoaQfKfYxiAATjAfEI2LF2u5JBT-N214Yn-HoksFigXJ5xbUu6ackwi6cUnD-GXdumzMXPfLK-s';
        
        // https://www.mail-signatures.com/wp-content/uploads/2019/02/How-to-find-direct-link-to-image_Fb-Picture.png
        
        // $topic="c3HESaduRPS_CfuGZb3DPt:APA91bEbKcI1CnDvoDwj21htpaj9OqASKJq5DYR3G6BPWs_Dhx2ad-a8A1d1JcxwgT1kxmV6e5Q-5nsqoj3knEbstLo8eU81Uzaiz7YNr-Z68ztLtOTJzWqnrE7d3A0oMi2ytd0Nff_Y";
         $token="c0M4EShIThGsILM_nBQXss:APA91bFXlKNLfaIhcxSIWCduB3eryC7gJGrb6qExuMKcbozU-kUHQqL5560yi2Y6kbmESS3AnId8ANLFFHZxcKC7kRDnwItYniXH48OjRZYXvlJni5K1Q7MXKTgZusyOFV3cXPpGflY-";
        //  $token = "funrZkJpTumO1M4V0-v4sj:APA91bFKZEx4K1s3beuhG00DY5XJRTt4XI3mAAyjEAxOoQud6zviJAqCT3Jym4RhJ9YBgVMSvot_E0476uij0jltw3vrGkAmgRh31Kd-3GZgb-ED0AdIkTI_sQqc7Im9Fd7ElfY2nQxT";
        $notification = [
        'title' =>'Title ',
        'body' => 'Message body',
        'id' => '0',
        'image'=>'https://dyl80ryjxr1ke.cloudfront.net/external_assets/hero_examples/hair_beach_v1785392215/original.jpeg',
        'type'=>'ride',
        'location'=>'Dhaka',
        'location_id'=>'18'
        ];
        // $extraNotificationData = ["message" => $notification];
        
        $fcmNotification = [
        'registration_ids' => $tokenList, //multple token array
        //'to' => $token, //single token
        // 'to' => '/topics/'.$topic, //single token
        'data' => $notification
        ];
        
        $headers = [
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
        ];
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        
        
        echo $result;
    }

    /**
     * get district
    */
    public function getDistrict($id) 
    {
        return District::find($id)->value;
    }

    /**
     * get city
    */
    public function getCity($id) 
    {
        return City::find($id)->name;
    }

    /**
     * get city
    */
    public function getCarType($id) 
    {
        return CarType::find($id)->name;
    }

    /**
     * get user name
    */
    public function getUser($id) 
    {
        return User::find($id)->name;
    }
    
    /**
     * get user phone
    */
    public function getUserPhone($id) 
    {
        return User::find($id)->phone;
    }  
    
    /**
     * get user phone
    */
    public function getCancelReason($id) 
    {
        return BidCancelList::find($id)->name;
    }
}