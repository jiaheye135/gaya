<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function webhook()
    {
        $file = '/home/xjxqpogs/public_html/public/message.txt';

        file_put_contents($file,file_get_contents("php://input"));

        $fb_message = file_get_contents($file);
        $fb_message = json_decode($fb_message);

        return;
        
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

        $token = 'EAADoPpPW50IBAAYBLpKsC2xWm3cZC3bajuUbQRIu5ZBcC4IhJZA6LUEZCPukJEJiyWRa1cvwDltxfq6x5XCYZB80Ix9WmXZBC66tk0fpze4MraAItRfkz4QXKqIYqwvlebvkAMNJKZB9OqdcqQdiZBfqk57EhP2EmVC5GH6XYHmnLwZDZD';

        $context = stream_context_create($options_header);
        file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);
    }
}