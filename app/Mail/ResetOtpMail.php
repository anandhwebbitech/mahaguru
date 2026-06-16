<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    // ✅ PASS OTP
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    // ✅ BUILD MAIL
    public function build()
    {
        return $this->subject('Password Reset OTP')
                    ->view('pages.reset-otp')
                    ->with([
                        'otp' => $this->otp
                    ]);
    }
}
