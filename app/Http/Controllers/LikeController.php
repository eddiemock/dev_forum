<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\User;

class LikeController extends Controller
{
    public function like(Discussion $discussion)
{
    $liker = auth()->user();

    $liker->likes()->attach($discussion->id);

    return redirect()->route('dashboard')->with('success', 'Liked Successfully!');


}


public function unlike(Discussion $discussion)
{
    $liker = auth()->user();
    
    
    $liker->likes()->attach($discussion->id);

    return redirect()->route('dashboard')->with('success', 'Liked Successfully!');


}

public function __construct()
{
    $this->middleware('auth');
}


}
