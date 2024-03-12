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
                        <p>Flagged by: {{ $comment->user_name }}</p>
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
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#comments{{ $discussion->id }}" aria-expanded="false" aria-controls="comments{{ $discussion->id }}">
                            Toggle Comments
                        </button>
                    </div>
                    <div class="card-body collapse" id="comments{{ $discussion->id }}">
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

<div class="row mt-4">
    <div class="col-md-12">
        <h2>Add New Category</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
            </div>
            <div class="form-group">
                <label for="description">Category Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter category description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
    </div>
</div>

@endsection
