<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $comments = Comment::all(); // Or apply any filtering/sorting you need
        $users = User::all(); // Or apply any filtering/sorting you need

        return view('admin.dashboard', compact('comments', 'users'));
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

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
}
