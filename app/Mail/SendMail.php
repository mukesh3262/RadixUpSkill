<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Config;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $subject, $view = "")
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->view = $view ? $view : 'emails.demoMail';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $checkMail = Config::get('constant.mail_status');
        if($checkMail == "ON"){
            return $this->subject($this->subject)
            ->view($this->view);
        }
    }
}
