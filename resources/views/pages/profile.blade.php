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
@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>
    <hr>

    <h2>Comments on Discussions</h2>
    @php
    $commentsByDiscussion = $user->comments->groupBy('discussion.post_title');
    @endphp

    @forelse ($commentsByDiscussion as $discussionTitle => $comments)
    <div>
        <a href="#discussionComments{{ $comments[0]->discussion_id }}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="discussionComments{{ $comments[0]->discussion_id }}">
            {{ $discussionTitle }}
        </a>
        <div class="collapse" id="discussionComments{{ $comments[0]->discussion_id }}">
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

<div class="container">
    <h2>My Support Groups</h2>
    @forelse ($user->supportGroups as $group)
        <div class="discussion">
            <h4>{{ $group->name }}</h4>
            <p>Topic: {{ $group->topic }}</p>
            <p>Scheduled for: {{ $group->scheduled_at->format('m/d/Y g:i A') }}</p>
            <!-- Leave Group Form -->
            <form action="{{ route('support_groups.leave', $group->id) }}" method="POST">
                @csrf
                @method('DELETE') <!-- Assuming a DELETE request is appropriate for leaving a group -->
                <button type="submit" class="btn btn-danger btn-sm">Leave Group</button>
            </form>
        </div>
    @empty
        <p class="no-content">You haven't joined any support groups yet.</p>
    @endforelse
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteProfileModal">
        Delete My Profile
    </button>
</div>

    <!-- Modal -->  
    <div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteProfileModalLabel">Confirm Profile Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete your profile and all associated data? This action cannot be undone.
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form method="POST" action="{{ route('user.delete', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Profile</button>
            </form>
        </div>
        </div>
    </div>
    </div>
@endsection

