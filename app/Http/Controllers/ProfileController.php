<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showUserProfile($userId)
{
    $user = User::with(['comments.discussion' => function($query) {
        $query->distinct()->with('comments'); // Ensure distinct discussions and load comments
    }])->findOrFail($userId);

    return view('pages.profile', compact('user'));
}
}