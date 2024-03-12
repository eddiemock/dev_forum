<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function reportComment(Request $request, $commentId)
    {
        try {
            // Find the comment by its ID
            $comment = Comment::findOrFail($commentId);

            // Log the found comment
            Log::info('Comment found:', ['comment' => $comment]);

            // Validate the request data
            $request->validate([
                'reason' => 'required|string|max:255',
            ]);

            // Create a new report
            Report::create([
                'user_id' => auth()->id(),
                'reason' => $request->reason,
                'reportable_id' => $comment->id,
                'reportable_type' => get_class($comment),
            ]);

            // Redirect back with success message
            return back()->with('success', 'Report submitted successfully.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error reporting comment:', ['exception' => $e]);

            // Redirect back with error message
            return back()->with('error', 'An error occurred while reporting the comment.');
        }
    }
}
