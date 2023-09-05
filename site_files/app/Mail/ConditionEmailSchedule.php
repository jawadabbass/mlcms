<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConditionEmailSchedule extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $con_id;
    public $client_id;
    public $pin;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client_id,$name,$con_id,$pin,$title)
    {
        $this->name = $name;
        $this->con_id = $con_id;
        $this->client_id=$client_id;
        $this->pin=$pin;
        $this->title = $title;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $name = $this->name;
        $con_id = $this->con_id;
        $client_id=$this->client_id;
        $pin=$this->pin;
        $title = $this->title;
        return $this->subject('Condition Email From Real Friend')->view('mail.condition_email_Schedule',compact('name','con_id','client_id','pin','title'));
    }
}
