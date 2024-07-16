<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TemplateMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $_subject;
    private $data;
    private $name;
    private $admin;
    private $com_email;
    private $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_subject, $data, $name, $admin, $com_email, $title)
    {
        $this->_subject = $_subject;
        $this->data = $data;
        $this->name = $name;
        $this->admin = $admin;
        $this->com_email = $com_email;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $_subject = $this->_subject;
        $data = $this->data;
        $name = $this->name;
        $admin = $this->admin;
        $com_email = $this->com_email;
        $title = $this->title;

        return $this->subject($_subject)
            ->from(FindInsettingArr('email'), FindInsettingArr('business_name'))
            ->replyTo(FindInsettingArr('email'), FindInsettingArr('business_name'))
            ->bcc(FindInsettingArr('email'), FindInsettingArr('business_name'))
            ->view('mail.template', compact('data', 'name', 'admin', 'com_email', 'title'));
    }
}
