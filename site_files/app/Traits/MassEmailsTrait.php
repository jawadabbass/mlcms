<?php

namespace App\Traits;

use App\Models\Back\MassMailQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Back\GeneralEmailTemplate;

trait MassEmailsTrait
{

    public function sendMassMailFromQueue()
    {
        /*
        * Laravel Schedular everyMinute is being used with paginate(1), thats why 1 Email will be sent in every minute
        * If want more change Laravel Schedular or paginate(1) to paginate(n)
        */
        $massMailQueueQuery = MassMailQueue::whereDate('date', '<=', date('Y-m-d'))->whereTime('time', '<=', date('H:i:s'))->where('is_sent', 0);
        $massMailQueue = $massMailQueueQuery->paginate(1);
        if ($massMailQueue->count() > 0) {
            foreach ($massMailQueue as $mailObj) {
                $mailTemplateObj = GeneralEmailTemplate::find($mailObj->template_id);
                $data = [];
                if ($mailObj->professional_id > 0) {
                    $professionalObj = DB::table('wp_specialist')->where('id', $mailObj->professional_id)->first();
                    /**************************** */
                    $to_name = $professionalObj->name_of_specialists;
                    $to_email = $professionalObj->email;
                    /**************************** */
                    $subject = str_replace('{EMAIL}', $professionalObj->email, $mailTemplateObj->subject);
                    $subject = str_replace('{PHONE}', $professionalObj->phone, $subject);
                    $subject = str_replace('{NAME}', $professionalObj->name_of_specialists, $subject);
                    /**************************** */
                    $body = str_replace('{EMAIL}', $professionalObj->email, $mailTemplateObj->email_template);
                    $body = str_replace('{PHONE}', $professionalObj->phone, $body);
                    $body = str_replace('{NAME}', $professionalObj->name_of_specialists, $body);
                } elseif ($mailObj->contact_id > 0) {
                    $contactObj = DB::table('contact_us_requests')->where('id', $mailObj->contact_id)->first();
                    /**************************** */
                    $to_name = $contactObj->name;
                    $to_email = $contactObj->email;
                    /**************************** */
                    $subject = str_replace('{EMAIL}', $contactObj->email, $mailTemplateObj->subject);
                    $subject = str_replace('{PHONE}', $contactObj->phone, $subject);
                    $subject = str_replace('{NAME}', $contactObj->name, $subject);
                    /**************************** */
                    $body = str_replace('{EMAIL}', $contactObj->email, $mailTemplateObj->email_template);
                    $body = str_replace('{PHONE}', $contactObj->phone, $body);
                    $body = str_replace('{NAME}', $contactObj->name, $body);
                }

                $data['body'] =  $body;
                if (
                    !empty($body) &&
                    null !== $mailTemplateObj &&
                    !empty($subject) &&
                    !empty($to_email) &&
                    !empty($to_name)
                ) {
                    try {
                        Mail::send('mail.mass_mail', $data, function ($message) use ($mailTemplateObj, $subject, $to_email, $to_name) {
                            $message->subject($subject);
                            $message->to($to_email, $to_name);
                            $message->from($mailTemplateObj->from_email, $mailTemplateObj->from_name);
                            $message->replyTo($mailTemplateObj->reply_to_email, $mailTemplateObj->reply_to_name);
                        });
                    } catch (\Exception $e) {
                        report($e);
                    }
                }
                $mailObj->is_sent = 1;
                $mailObj->update();
            }
        }
    }
}
