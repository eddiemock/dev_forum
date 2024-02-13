<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function like(Discussion $discussion)
{
    $liker = auth()->user();

    $liker->likes()->attach($discussion->id);

    return redirect()->route('dashboard')->with('success', 'Liked Successfully!');

    \Illuminate\Support\Facades\Log::debug('Liker:', ['id' => $liker->id]);
    \Illuminate\Support\Facades\Log::debug('Discussion:', ['id' => $discussion->id]);

}


public function unlike(Discussion $discussion)
{
    $liker = auth()->user();
    
    
    $liker->likes()->detach($discussion->id);

    return redirect()->route('dashboard')->with('success', 'Liked Successfully!');

    \Illuminate\Support\Facades\Log::debug('Liker:', ['id' => $liker->id]);
    \Illuminate\Support\Facades\Log::debug('Discussion:', ['id' => $discussion->id]);

    

}




}
