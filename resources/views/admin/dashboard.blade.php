<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Comments</h2>
            <div class="list-group">
                @forelse($comments as $comment)
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Comment by {{ $comment->$user }}</h5>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $comment->body }}</p>
                    </a>
                @empty
                    <p>No comments available.</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <h2>Users</h2>
            <ul class="list-group">
                @forelse($users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $user->name }}
                        <span class="badge badge-primary badge-pill">{{ $user->email }}</span>
                    </li>
                @empty
                    <p>No users found.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
