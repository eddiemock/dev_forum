<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile($id)
    {
        $user = User::with(['discussions', 'comments', 'comments.discussion'])->findOrFail($id);
        
        return view('pages.profile', compact('user'));
    }
}