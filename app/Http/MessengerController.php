<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function webhook(Request $request)
    {
        // $verifyToken = 'jiahe-bear';
      
        // $hub_challenge = $request->hub_challenge;
        // $verify_token = $request->hub_verify_token;

        // if ($verifyToken == $verify_token) {
        //     echo $hub_challenge;
        // }
        // return;

        $file = '/home/xjxqpogs/public_html/public/message.txt';

        file_put_contents($file, file_get_contents("php://input"));

        $fb_message = file_get_contents($file);
        $fb_message = json_decode($fb_message);

        // return;
        
        $rec_id = $fb_message->entry[0]->messaging[0]->sender->id; //Sender's ID
        $rec_msg= $fb_message->entry[0]->messaging[0]->message->text; //Sender's Message

        $data_to_send = array(
            'recipient'=> array('id' => $rec_id), //ID to reply
            'message' => array('text'=>"Hi I am Test Bot") //Message to reply
        );

        $options_header = array ( //Necessary Headers
            'http' => array(
            'method' => 'POST',
            'content' => json_encode($data_to_send),
            'header' => "Content-Type: application/json\n"
            )
        );

        $token = 'EAA9qVGJJ7m0BAIe36HREzRz5CmEojNyhWj38MAcBpYOTiAsa9IwEZA7QnVi6ckexprD5vr4lFKzHgifm0WzoGOxCAC9O6wZC8sS7GwfaXG4PogSZA8ZACqmPB6Ns9IQmBTV7zJO79BocCjYGVQKQagQhK3OEV3hsjJTf3vKV8wWb8MryDhvZC';

        $context = stream_context_create($options_header);
        file_get_contents("https://graph.facebook.com/v11.0/me/messages?access_token=$token", false, $context);
    }

    function sendMessage()
    {
        // curl -X POST -H "Content-Type: application/json" -d '{
        //     "messaging_type": "<MESSAGING_TYPE>",
        //     "recipient": {
        //       "id": "<PSID>"
        //     },
        //     "message": {
        //       "text": "hello, world!"
        //     }
        //   }' "https://graph.facebook.com/v11.0/me/messages?access_token=<PAGE_ACCESS_TOKEN>"

        $token = 'EAA9qVGJJ7m0BAIe36HREzRz5CmEojNyhWj38MAcBpYOTiAsa9IwEZA7QnVi6ckexprD5vr4lFKzHgifm0WzoGOxCAC9O6wZC8sS7GwfaXG4PogSZA8ZACqmPB6Ns9IQmBTV7zJO79BocCjYGVQKQagQhK3OEV3hsjJTf3vKV8wWb8MryDhvZC';

        $url = "https://graph.facebook.com/v11.0/me/messages?access_token=$token";

        // $curlOption = [ CURLOPT_HTTPHEADER => ["Content-Type: application/json"] ];

        $postData = [
            "messaging_type" => "",
            // 'sender_action' => 'typing_on',
            'recipient' => [
                'id' => '3490650304355022', //ID to reply
            ],
            'message' => [
                'text' => "hello, jiahe!" //Message to reply
            ], 
        ];

        $res = $this->curlPost($url, $postData);
        var_dump($res);
    }

    function loginTest()
    {
        return view('front.loginTest');
    }

    function curlPost($url, $postData, $curlOption = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        foreach ($curlOption as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);

        // if (!empty($err)) {
            \Log::alert('curl error: ' . '1');
        // }
        curl_close($ch);

        return $result;
    }
}