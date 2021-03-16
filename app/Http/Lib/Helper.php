<?php
namespace App\Http\Lib;
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
        $client->request("GET", "https://quicarbd.com//mobileapi/notification/partnerNotification.php?notification=single&id=1&title=".$title ."&body=".$body."&type=1&type=1&token=".$id);
                                
    }

    /**
     * sms send
     */
    public function smsSend($phone, $msg) {
        $client = new Client();            
        $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $phone ."&message=".$msg);
    }
}