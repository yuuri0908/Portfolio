<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $registerUrl;

    public function __construct($verificationCode,$registerUrl)
    {
        $this->verificationCode = $verificationCode;
        $this->registerUrl = $registerUrl;
    }

    public function build()
    {
        return $this->view('emails.verification_code')
                    ->with([
                        'verificationCode' => $this->verificationCode,
                        'registerUrl' => $this->registerUrl,
                    ]);
    }
}
