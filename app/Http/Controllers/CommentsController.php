<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function store(Discussion $discussion)
    {

        if(!$discussion) {
            // Handle the case where the discussion is not found
            return back()->withErrors(['message' => 'Discussion not found.']);
        }
    


        Comment::create([
            'body' => request('body'),
            'discussion_id' => $discussion->id
        ]);
        
        return back();

    }
}
