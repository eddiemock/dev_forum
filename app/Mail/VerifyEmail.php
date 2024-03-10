<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        // Generate verification URL
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', 
            now()->addMinutes(60), 
            ['id' => $this->user->getKey(), 'hash' => sha1($this->user->getEmailForVerification())]
        );

        return $this->subject('Verify Your Email Address')
                    ->view('emails.verify')
                    ->with([
                        'name' => $this->user->name,
                        'verificationUrl' => $verificationUrl,
                    ]);
    }
}
