<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable;
    use SerializesModels;
    public $data;
    private $ip;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $ip)
    {
        $this->data = $data;
        $this->ip = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $ip = $this->ip;

        return $this->subject(config('Constants.SITE_NAME').' | Contact Us Form Submitted')
        ->from($data['email'], $data['name'])
        ->replyTo($data['email'], $data['name'])
        ->view('mail.contact', compact('data', 'ip'));
    }
}
