@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <h5>Tags</h5>
            <ul class="list-group">
                @foreach ($tags as $tag)
                    <li class="list-group-item">
                        <a href="?tag={{ $tag->id }}" class="{{ $selectedTag == $tag->id ? 'active' : '' }}">{{ $tag->name }}</a>
                    </li>
                @endforeach
                @if($selectedTag)
                    <li class="list-group-item">
                        <form action="{{ url()->current() }}" method="GET">
                            <input type="hidden" name="reset" value="true">
                            <button type="submit" class="btn btn-danger mt-3">Reset</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('profile.Home') }}</h1>

            @forelse ($discussions as $discussion)
                <div class="card mb-3">
                    <div class="card-header">
                        <a href="/detail/{{$discussion->id}}" class="text-decoration-none">
                            <h5 class="mb-0">{{ $discussion->post_title }}</h5>
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Description: {{ $discussion->description }}</p>
                        <p class="card-text"><small class="text-muted">Written by: {{ $discussion->user->name }}</small></p>
                        <a href="/detail/{{$discussion->id}}" class="btn btn-primary">Read more</a>
                    </div>
                </div>

                @if ($discussion->comments->count() > 0)
                    <h5 class="mt-3">Comments</h5>
                    <ul class="list-group mb-3">
                    @foreach ($discussion->comments as $comment)
                        <li class="list-group-item">
                            <strong>{{ $comment->created_at->diffForHumans() }} by {{ $comment->user->name ?? 'Anonymous' }}</strong>
                             <p>{{ $comment->body }}</p>
                        </li>
                    @endforeach
                    </ul>
                @else
                    <p>No comments yet.</p>
                @endif

                <div class="card mt-4 mb-5">
                    <div class="card-body">
                        <form method="POST" action="/detail/{{ $discussion->id }}/comments/">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" placeholder="Your comment here." class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Add Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <p>No posts found.</p>
            @endforelse

            {{ $discussions->links() }}
        </div>
    </div>
</div>

@endsection
