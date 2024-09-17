<?php

namespace App\Traits;

use App\Models\Back\Client;
use App\Models\Back\ContactUs;
use App\Models\Back\Subscribers;
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
                if ($mailObj->client_id > 0) {
                    $clientObj = Client::find($mailObj->client_id);
                    /**************************** */
                    $to_name = $clientObj->name . ' ' . $clientObj->last_name;
                    $to_email = $clientObj->email;
                    /**************************** */
                    $subject = str_replace('{EMAIL}', $clientObj->email, $mailTemplateObj->subject);
                    $subject = str_replace('{PHONE}', $clientObj->phone, $subject);
                    $subject = str_replace('{NAME}', $clientObj->name . ' ' . $clientObj->last_name, $subject);
                    /**************************** */
                    $body = str_replace('{EMAIL}', $clientObj->email, $mailTemplateObj->email_template);
                    $body = str_replace('{PHONE}', $clientObj->phone, $body);
                    $body = str_replace('{NAME}', $clientObj->name . ' ' . $clientObj->last_name, $body);
                } elseif ($mailObj->contact_id > 0) {
                    $contactObj = ContactUs::find($mailObj->contact_id);
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
                } elseif ($mailObj->subscriber_id > 0) {
                    $subscriberObj = Subscribers::find($mailObj->subscriber_id);
                    /**************************** */
                    $to_name = '';
                    $to_email = $subscriberObj->email;
                    /**************************** */
                    $subject = str_replace('{EMAIL}', $subscriberObj->email, $mailTemplateObj->subject);
                    $subject = str_replace('{PHONE}', '', $subject);
                    $subject = str_replace('{NAME}', '', $subject);
                    /**************************** */
                    $body = str_replace('{EMAIL}', $subscriberObj->email, $mailTemplateObj->email_template);
                    $body = str_replace('{PHONE}', '', $body);
                    $body = str_replace('{NAME}', '', $body);
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
