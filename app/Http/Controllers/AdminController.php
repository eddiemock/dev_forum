<?php

namespace App\Http\Controllers;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MentalHealthSupportMail;

class AdminController extends Controller
{

    
    public function dashboard()
{
    $usersWithFlaggedComments = User::with(['comments' => function ($query) {
        $query->where('flagged', true);
    }])->get();

    $users = User::all(); // Ensure this line is correctly added

    return view('admin.dashboard', compact('usersWithFlaggedComments', 'users'));
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

    public function sendSupportEmail(Request $request)
{
    $user = User::findOrFail($request->user_id);
    
    Mail::to($user->email)->send(new MentalHealthSupportMail());

    return back()->with('success', 'Support email sent successfully to ' . $user->email);
}

public function getUserComments($userId)
{
    $user = User::findOrFail($userId);
    $comments = $user->comments;
    return view('admin.user_comments', compact('comments'));
}


}
