<?php

namespace App\Services;

use Mail;

class SendEmailService
{
    /**
     * $emailPage  string   寄件內容檔名(resources\views\emails\xxx.blade.php -> emails.xxx) (必填)
     * $emailTitle string   寄件標題 (必填)
     * $sendTo     array    收件人(必填, 不可為空)
     * $pageData   keyValue 需要帶過去的寄件內容參數 (選填)
     * $cc         array    副本 (選填, 可為空)
     * $bcc        array    密件副本 (選填, 可為空)
     */
    public function sendEmail($emailPage, $emailTitle, $sendTo, $pageData = [], $cc = [], $bcc = []){
        $checkMail = $this->checkMail($sendTo);
        if(!$checkMail['res']){
            return ['email format error'];
        }

        /**
         *  .env 參數
         * MAIL_SEND_FROM      寄件信箱 (必填)
         * MAIL_SEND_FROM_NAME 寄件著 (必填)
         */
        $send = [
            // 'address' => env("MAIL_SEND_FROM", ''),
            // 'name'    => env("MAIL_SEND_FROM_NAME", '')
        ];

        // if($send['address'] && $send['name']){
            Mail::send($emailPage, $pageData, function ($message) use ($send, $emailTitle, $sendTo, $cc, $bcc) {
                $message->to($sendTo)
                        ->subject($emailTitle);
                // $message->from($send['address'], $send['name']);

                if( count($cc) > 0 ){
                    $message->cc($cc);
                }
                if( count($bcc) > 0 ){
                    $message->bcc($bcc);
                }
            });

            return Mail::failures();
        // } else {
        //     return ['missing sender information'];
        // }
    }

    // 檢查信箱格式
    public function checkMail($emails = []){
        foreach($emails as $email){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return ['res' => false, 'email' => $email];
            }
        }
        return ['res' => true];
    }
}