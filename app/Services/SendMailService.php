<?php
namespace App\Common\Services;

use Illuminate\Support\Facades\Mail;

class SendMailService
{
    public function send_mail($arr_template_data)
    {
        try {   
                /* Mail Content */
                $content    = isset($arr_template_data['content']) ? $arr_template_data['content'] : '';
                /* From Mail */
                $from_mail  = isset($arr_template_data['from_mail']) ? $arr_template_data['from_mail'] : config('app.mail_username');
                /* From Name */
                $from_mail_name  = isset($arr_template_data['from_mail_name']) ? $arr_template_data['from_mail_name'] : config('app.mail_from_name');
                /* To Mail */
                $to_mail    = isset($arr_template_data['to_mail']) ? $arr_template_data['to_mail'] : '';
                /* Mail Subject */
                $mail_subject    = isset($arr_template_data['mail_subject']) ? $arr_template_data['mail_subject'] : '';
                /* Send mail */
                $send_mail = Mail::send(array(),array(), function($message) use($content,$from_mail,$to_mail,$mail_subject,$from_mail_name)
                {
                    $message->from(trim($from_mail),trim($from_mail_name));
                    
                    $message->to(trim($to_mail))
                            ->subject($mail_subject)
                            ->setBody($content, 'text/html');    
                });
                /* check mail send status */
                if(!$send_mail)
                {
                    $response['status']  = 'success';
                    $response['message']  = 'Email send successfully.';
                }
                else
                {
                    $response['status']  = 'failed';
                    $response['message'] = 'Something went wrong';
                }
                return $response;
        } catch (\Throwable $th) {
            $response['status']          = 'failed';
            $response['message']         = 'Something went wrong, Please try again';
            $response['error_message']   = $th->getMessage();
            $response['data']            = [];    
            return $response;
        }
    }
}