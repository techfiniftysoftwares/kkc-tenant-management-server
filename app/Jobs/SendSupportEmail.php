<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSupportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $message;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public function handle()
    {
        $emailData = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];

        Mail::send('emails.support', $emailData, function ($message) {
            $message->to('support@kusoya.com')
                ->subject('New Support Request')
                ->replyTo($this->email);
        });
    }
}