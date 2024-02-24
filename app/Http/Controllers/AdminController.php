<?php

namespace App\Http\Controllers;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $discussions = Discussion::all();
        $unapprovedComments = Comment::where('is_approved', 0)->get();
        return view('admin.dashboard', compact('discussions', 'unapprovedComments'));
    }

    public function comments()
    {
        $comments = Comment::where('is_approved', false)->get(); // Assuming 'is_approved' column exists
        return view('admin.comments', compact('comments'));
    }

    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = true;
        $comment->save();

        return back()->with('success', 'Comment approved successfully.');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
