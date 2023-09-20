<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConditionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $description;
    public $title;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$description,$title)
    {
        $this->name = $name;
        $this->description = $description;
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
        $description = $this->description;
        $title = $this->title;
        return $this->subject('Condition Email From Real Friend')->view('mail.condition_email',compact('name','description','title'));
    }
}
