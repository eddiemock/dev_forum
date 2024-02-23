<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{

    protected $moderationService;

    public function __construct(\App\Services\OpenAiModerationService $moderationService)
    {
    $this->moderationService = $moderationService;
    }


    public function store(Request $request, Discussion $discussion)
{
    if (!$discussion) {
        return back()->withErrors(['message' => 'Discussion not found.']);
    }

    $commentText = $request->input('body');
    $moderationResponse = $this->moderationService->moderateText($commentText);

    $isApproved = true; // Default to true, adjusted based on moderation response

    if ($moderationResponse && $moderationResponse['results'][0]['flagged']) {
        $isApproved = false;
    }

    // Save the comment with the is_approved flag
    $comment = Comment::create([
        'body' => $commentText,
        'discussion_id' => $discussion->id,
        'is_approved' => $isApproved,
    ]);

    Log::info('Comment saved', ['id' => $comment->id, 'is_approved' => $comment->is_approved]);

    return back()->with('message', 'Your comment has been posted successfully.');
}



}
