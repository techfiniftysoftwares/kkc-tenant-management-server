<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $otpCode
     */
    public function __construct($otpCode, $user)
    {
        $this->otpCode = $otpCode;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('OTP Verification')
            ->view('emails.otp')
            ->with([
                'otpCode' => $this->otpCode,
                'user' => $this->user,
            ]);
    }
}
