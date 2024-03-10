<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL; // Make sure to import the URL facade

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl; // Add a property for the verification URL

    /**
     * Create a new message instance.
     *
     * @param User $user User instance to be used within the mailable.
     */
    public function __construct(User $user)
{
    $this->user = $user;

    // Generate the verification URL based on a simple token-based system
    $this->verificationUrl = route('verification.verify', ['token' => $user->verification_token]);
}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address')
                    ->view('emails.verify')
                    ->with([
                        'user' => $this->user,
                        'verificationUrl' => $this->verificationUrl, // Pass the URL to the view
                    ]);
    }
}
