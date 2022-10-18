<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssessmentAnswer extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $data;
    public $subject;
  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $data,$subject)
    {
        $this->name = $name;
        $this->data = $data;
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
        $data = $this->data;
        $subject = $this->subject;
        return $this->subject($subject)->view('mail.assessment_answer',compact('name','data','subject'));
    }
}
