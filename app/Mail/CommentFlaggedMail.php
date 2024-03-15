<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class CommentFlaggedMail extends Mailable
{
    protected $comment;
    protected $categories;

public function __construct(Comment $comment, array $categories)
{
    $this->comment = $comment;
    $this->categories = $categories;
}

public function build()
{
    return $this->view('emails.commentFlagged')
                ->with([
                    'commentText' => $this->comment->body,
                    'categories' => $this->categories,
                ]);
}

}
