@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f7f6;
        color: #333;
        font-family: 'Nunito', sans-serif;
        margin-top: 20px;
    }

    .container {
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    h1, h2 {
        color: #1176e1;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    h2 {
        border-bottom: 2px solid #1176e1;
        font-size: 20px;
        margin-top: 30px;
        padding-bottom: 5px;
    }

    .discussion, .comment {
        background-color: #f9f9f9;
        border-left: 4px solid #1176e1;
        margin-top: 15px;
        padding: 10px 15px;
        border-radius: 3px;
    }

    .discussion h4, .comment p {
        margin: 0 0 10px 0;
    }

    a {
        color: #1176e1;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    p {
        line-height: 1.5;
    }

    .no-content {
        text-align: center;
        color: #888;
        margin: 20px 0;
    }
</style>
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>
    <hr>

    <h2>Comments on Discussions</h2>
    @php
    $commentsByDiscussion = $user->comments->groupBy('discussion_id');
    @endphp

    @forelse ($commentsByDiscussion as $discussionId => $comments)
        @php
        $discussion = $comments->first()->discussion; // Assuming the relationship is loaded
        @endphp
        <div>
            <a href="#discussionComments{{ $discussionId }}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="discussionComments{{ $discussionId }}">
                {{ $discussion->post_title }}
            </a>
            <div class="collapse" id="discussionComments{{ $discussionId }}">
                <div class="card card-body">
                    @foreach ($comments as $comment)
                        <p>{{ $comment->body }} - <small>Commented on: {{ $comment->created_at->format('m/d/Y') }}</small></p>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <p>No comments posted yet.</p>
    @endforelse
</div>
@endsection

