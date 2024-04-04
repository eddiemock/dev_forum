<?php
namespace App\Mail;

use App\Models\User;
use App\Models\SupportGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SupportGroupInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $supportGroup;

    public function __construct(User $user, SupportGroup $supportGroup)
    {
        $this->user = $user;
        $this->supportGroup = $supportGroup;
    }

    public function build()
{
    return $this->view('emails.supportGroupInvitation')
                ->with([
                    'user' => $this->user,
                    'supportGroup' => $this->supportGroup,
                ]);
}

}

