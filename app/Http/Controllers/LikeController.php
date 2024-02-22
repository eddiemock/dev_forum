<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Discussion;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function like(Discussion $discussion)
{
    if (!Auth::check()) {
        Log::debug('User not authenticated');
        return redirect()->route('login')->with('error', 'Please log in to like discussions.');
    }

    $user = Auth::user();
    Log::debug('Liker:', ['id' => $user->id]);
    $user->likes()->attach($discussion->id);
    return redirect()->route('dashboard')->with('success', 'Liked Successfully!');
}



public function unlike(Discussion $discussion)
{
    $user = Auth::user();
    
    
    $user->likes()->detach($discussion->id);

    return redirect()->route('dashboard')->with('success', 'Liked Successfully!');

    \Illuminate\Support\Facades\Log::debug('Liker:', ['id' => $user->id]);
    \Illuminate\Support\Facades\Log::debug('Discussion:', ['id' => $discussion->id]);

    

}




}
