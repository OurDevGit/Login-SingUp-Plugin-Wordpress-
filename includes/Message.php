<?php 


namespace Cf;
use Twilio\Rest\Client;

class Message{
    private function get_details(){
      return array(
        'id' => 'AC4270d6169a8d7b34a36f49ce26fe94fe',
        'token' => 'd1a7ec09e74f5fdfe2c58908dc9fb282'
      );
    }
    function send_message($mobile, $message){
      $creds = $this->get_details();
      // print_r($creds);
      // die();
      $client = new Client($creds['id'], $creds['token']);
      $response = $client->messages->create(
        // the number you'd like to send the message to
        $mobile,
        array(
            'from' => '+12052933209',
            'body' => $message
        )
      );


      return $response;
      die(123);

    }
}


