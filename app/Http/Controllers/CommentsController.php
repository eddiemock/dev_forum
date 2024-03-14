<?php

namespace App\Http\Controllers;
use App\Services\OpenAiModerationService;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

        // Moderates the text and checks if it needs to be flagged.
        $needsReview = $this->needsReview($commentText);

        $comment = new Comment();
        $comment->body = $commentText;
        $comment->discussion_id = $discussion->id;
        $comment->user_id = $userId;
        $comment->flagged = $needsReview ? 1 : 0; // If needsReview is true, set flagged to 1, else 0.

        $comment->save();

        if ($needsReview) {
            // Inform the user their comment is under review if it's flagged.
            return back()->withErrors(['message' => 'Your comment is under review.']);
        } else {
            // Confirm comment posting success.
            return back()->with('message', 'Your comment has been posted successfully.');
        }
    }

    private function needsReview($text)
    {
        $moderationResult = $this->moderationService->moderateText($text);
        // Assumes the moderation result has a 'flagged' key that's true if the comment needs review.
        return !empty($moderationResult['flagged']);
    }
}