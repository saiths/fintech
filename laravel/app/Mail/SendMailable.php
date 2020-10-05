<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public  $sub;
    public  $mes;

    public function __construct($subject,$messages)
    {
        $this->sub = $subject;
        $this->mes = $messages;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_subject = $this->sub;
        $e_message = $this->mes;
        return $this->view('mail.sendmail',compact('e_message'))->subject($e_subject);
    }

}
