<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Techchain';
    public $view = "welcome";
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $view, $data = [])
    {
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('techchain@techchains-ecommerce.store','Techchain')
        ->subject($this->subject)
        ->view('mail.'.$this->view);
    }
}
