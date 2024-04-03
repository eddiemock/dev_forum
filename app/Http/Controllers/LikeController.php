<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Controllers\CommentsController;


class LikeController extends Controller
{
    public function like($commentId)
{
    $comment = Comment::findOrFail($commentId);
    $userId = auth()->id();

    // Check if the user has already liked the comment
    if ($comment->likers()->where('user_id', $userId)->exists()) {
        // User has already liked the comment
        return back()->with('info', 'You have already liked this comment.');
    }

    // If not already liked, proceed to like the comment
    $comment->likers()->syncWithoutDetaching($userId);

    return back();
}


    public function unlike($commentId)
{
    $userId = auth()->id(); // Or use $user = auth()->user(); then $user->id;
    $comment = Comment::findOrFail($commentId);

    // Detach the user from the comment's likers
    $comment->likers()->detach($userId);

    return back();
}

}
