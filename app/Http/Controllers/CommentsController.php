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

    Log::info('User Authenticated: ' . auth()->check());
    Log::info('User ID: ' . auth()->id());

    // Ensure a discussion is found, otherwise return back with an error
    if (!$discussion) {
        return back()->withErrors(['message' => 'Discussion not found.']);
    }

    // Get the comment text from the request
    $commentText = $request->input('body');

    // Perform the moderation check (assuming this part works as intended)
    $moderationResponse = $this->moderationService->moderateText($commentText);
    $isApproved = true; // Default to true, adjusted based on moderation response
    if ($moderationResponse && $moderationResponse['results'][0]['flagged']) {
        $isApproved = false;
    }

    // Retrieve the currently authenticated user's ID
    $userId = auth()->id();

    // Save the comment with the is_approved flag and user_id
    $comment = Comment::create([
        'body' => $commentText,
        'discussion_id' => $discussion->id,
        'user_id' => $userId, // Set the user_id field to the ID of the currently authenticated user
        'is_approved' => $isApproved,
    ]);

    Log::info('Comment saved', ['id' => $comment->id, 'is_approved' => $comment->is_approved]);

    return back()->with('message', 'Your comment has been posted successfully.');
}





}
