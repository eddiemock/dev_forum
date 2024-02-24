@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Unapproved Comments</h2>
            @foreach($unapprovedComments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p>{{ $comment->body }}</p>
                        <form method="POST" action="{{ route('admin.comment.approve', $comment->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comment.delete', $comment->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <h2>Discussions and Comments</h2>
            @forelse($discussions as $discussion)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">{{ $discussion->post_title }}</h5>
                        <small>Written by: {{ $discussion->user->name }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $discussion->description }}</p>
                        <h6>Comments:</h6>
                        <ul class="list-group">
                            @forelse($discussion->comments as $comment)
                                <li class="list-group-item">
                                    <strong>Comment by {{ optional($comment->user)->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    <p>{{ $comment->body }}</p>
                                    <form method="POST" action="{{ route('admin.comment.delete', $comment->id) }}" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </li>
                            @empty
                                <li class="list-group-item">No comments available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @empty
                <p>No discussions available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
