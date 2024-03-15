<?php

namespace App\Http\Controllers;
use App\Services\OpenAiModerationService;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentFlaggedMail;

class CommentsController extends Controller
{
    protected $moderationService;

    public function __construct(OpenAiModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function store(Request $request, Discussion $discussion)
{
    if (!$discussion) {
        return back()->withErrors(['message' => 'Discussion not found.']);
    }

    $userId = Auth::id();
    $commentText = $request->input('body');

    $moderationResult = $this->needsReview($commentText);
    $needsReview = $moderationResult['flagged'];

    $comment = new Comment();
    $comment->body = $commentText;
    $comment->discussion_id = $discussion->id;
    $comment->user_id = $userId;
    $comment->flagged_categories = $needsReview ? json_encode($moderationResult['categories']) : null;
    $comment->flagged = $needsReview ? 1 : 0;
    $comment->save();

    // If the comment is flagged, notify admins
    if ($needsReview) {
        $flaggedCategories = $moderationResult['categories']; // Get flagged categories
        Mail::to('admin@example.com')->send(new CommentFlaggedMail($comment, $flaggedCategories));
        return back()->withErrors(['message' => 'Your comment is under review.']);
    }

    // For both flagged and non-flagged comments, redirect back with a success message
    return back()->with('message', 'Your comment has been posted successfully.');
}

private function needsReview($text)
{
    // Corrected to call the moderation service once
    return $this->moderationService->moderateText($text);
}

}
