<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Discussion;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function like(Discussion $discussion)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            Log::debug('Liker:', ['id' => $user->id]);
            $user->likes()->attach($discussion->id);
            return redirect()->route('dashboard')->with('success', 'Liked Successfully!');
        } else {
            // Redirect the user to the login page with an error message
            return redirect()->route('login')->with('error', 'Please log in to like discussions.');
        }
    }

    public function unlike(Discussion $discussion)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $user->likes()->detach($discussion->id);
            return redirect()->route('dashboard')->with('success', 'Unliked Successfully!');
        } else {
            // Redirect the user to the login page with an error message
            return redirect()->route('login')->with('error', 'Please log in to unlike discussions.');
        }
    }
}
