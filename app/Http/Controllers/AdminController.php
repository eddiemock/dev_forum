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
        // Fetch flagged comments with the name of the user who posted each comment
        $flaggedComments = Comment::where('flagged', true)
                            ->join('users', 'comments.user_id', '=', 'users.id')
                            ->select('comments.*', 'users.name as user_name')
                            ->get();
    
        $discussions = Discussion::all(); // Fetch all discussions
        $categories = Category::all(); // Fetch all categories
        $users = User::all(); // Fetch all users for the email sending section
    
        // Pass all the fetched data to the view
        return view('admin.dashboard', compact('discussions', 'flaggedComments', 'categories', 'users'));
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
}
