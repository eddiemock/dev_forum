<?php

namespace App\Http\Controllers;

use App\Tag;
use App\discussionController;
use App\ThreadFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{


    public function addThreatComment(Request $request, Thread $thread)
    {
        $this->validate($request, [
            'body'=>'required'
        ]);

        $comment->new Comment();
        $comment->body=$request->body;
        $comment->user_id=auth()->user()->id;
        $thread->comments()->save($comment);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
//        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }

    public function markAsSolution()
    {
        

    }
    public function search()
    {
       


    }
}