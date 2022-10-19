<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to_email;
    public $subject;
    public $view;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to_email, $subject, $view, $data)
    {
        $this->to_email = $to_email;
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd("order mail job");
        Mail::to($this->to_email)->send(new SendEmail($this->subject, $this->view, $this->data));
    }
}
