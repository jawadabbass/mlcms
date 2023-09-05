<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssessmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $link;
    public $subject;
  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $link,$subject)
    {
        $this->name = $name;
        $this->link = $link;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->name;
        $link = $this->link;
        $subject = $this->subject;
        return $this->subject($subject)->view('mail.assessment_email',compact('name','link','subject'));
    }
}
