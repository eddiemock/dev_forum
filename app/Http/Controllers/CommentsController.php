<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    protected $nluService;

    public function __construct(\App\Services\IBMWatsonNLUService $nluService)
    {
        $this->nluService = $nluService;
    }

    public function store(Request $request, Discussion $discussion)
{
    Log::info('User Authenticated: ' . auth()->check());
    Log::info('User ID: ' . auth()->id());

    // Ensure a discussion is found, otherwise return back with an error
    if (!$discussion) {
        return back()->withErrors(['message' => 'Discussion not found.']);
    }
    $userId = Auth::id();

    // Get the comment text from the request
    $commentText = $request->input('body');

    // Perform sentiment analysis using IBM Watson NLU
    $analysisResults = $this->nluService->analyzeText($commentText);
    $isApproved = true; // Default to true, adjust based on analysis results

    // Example moderation logic based on sentiment score (customize as needed)
    if (isset($analysisResults['sentiment']['document']['score']) &&
        $analysisResults['sentiment']['document']['score'] < -0.5) {
        // Assuming a negative sentiment score below -0.5 requires moderation
        $isApproved = false;
    }

    // Save the comment with the is_approved flag
    $comment = Comment::create([
        'body' => $commentText,
        'discussion_id' => $discussion->id,
        'is_approved' => $isApproved,
        'user_id' => $userId, // Assign the authenticated user's ID
    ]);

    // Notify the user if the comment hasn't been approved
    if (!$isApproved) {
        return back()->withErrors(['message' => 'Your comment has not been approved and is deemed inappropriate.']);
    }

    Log::info('Comment saved', ['id' => $comment->id, 'is_approved' => $comment->is_approved]);

    return back()->with('message', 'Your comment has been posted successfully.');
}

}
