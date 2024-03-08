<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Controllers\CommentsController;


class LikeController extends Controller
{
    public function like(Request $request, $commentId)
{
    $comment = Comment::findOrFail($commentId);
    $userId = auth()->id();
    
    // Attach the user to the comment's likers
    // Make sure there's a relationship method `likers` in Comment model
    $comment->likers()->attach($userId);

    return back()->with('success', 'Comment liked successfully!');
}

    public function unlike(Request $request, $commentId)
{
    $user = auth()->user();
    $comment = Comment::findOrFail($commentId);

    // Detach the user from the comment's likers
    $comment->likers()->detach($user->id);

    return back()->with('success', 'Comment unliked successfully!');
}
}
