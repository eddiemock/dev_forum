<?php

namespace App\Http\Controllers;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MentalHealthSupportMail;
use App\Models\Role;
use App\Models\SupportGroup;
use App\Mail\SupportGroupInvitationMail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    
    public function dashboard()
{
    $usersWithFlaggedComments = User::whereHas('comments', function ($query) {
        // The comment is either flagged or has depressive_classification = 1
        $query->where('flagged', '=', true)
              ->orWhere('depressive_classification', '=', 1);
    })->with(['comments' => function ($query) {
        // Apply the same conditions for the eager-loaded comments
        $query->where(function ($query) {
            $query->where('flagged', '=', true)
                  ->orWhere('depressive_classification', '=', 1);
        });
    }])->get();

    // This retrieves all users, which might be used for other purposes in the dashboard
    $users = User::all();

    $reportedComments = Comment::whereHas('reports')->with('user', 'reports')->get();
    $roles = Role::all();
    $supportGroups = SupportGroup::with('users')->orderBy('scheduled_at', 'desc')->get();

    return view('admin.dashboard', compact('usersWithFlaggedComments', 'users', 'roles', 'reportedComments', 'supportGroups'));
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

public function showAssignRoleForm()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.assign-role', compact('users', 'roles'));
    }

    // Method to handle the role assignment
    public function assignRole(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'role_id' => 'required|exists:roles,id',
    ]);

    $user = User::find($request->user_id);

    // Check if the user already has the selected role
    if ($user->role_id != $request->role_id) {
        $user->role_id = $request->role_id; // Assuming a user can have only one role
        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Role assigned successfully.');
    } else {
        return redirect()->back()->with('error', 'User already has the selected role.');
    }
}
public function sendInvitationEmail(Request $request)
{
    // Retrieve user_id and support_group_id from the request
    $userId = $request->input('user_id');
    $supportGroupId = $request->input('support_group_id');

    // Correctly find the user and support group based on the provided IDs
    $user = User::findOrFail($userId);
    $supportGroup = SupportGroup::findOrFail($supportGroupId);
    Log::info('User Object', [$user->toArray()]);
    Log::info('Support Group Object', [$supportGroup->toArray()]);
    
    // Ensure the order of parameters matches the constructor of SupportGroupInvitationMail
    // First parameter should be User, second should be SupportGroup
    Mail::to($user->email)->send(new SupportGroupInvitationMail($user, $supportGroup));
    
    // Redirect back with a success message
    return back()->with('message', 'Invitation sent successfully.');
}

}


