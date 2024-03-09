@extends('layouts.app')

@section('content')

<p>Details page</p>
<div class="container">
    <p><strong>Post Title:</strong> {{ $discussion->post_title }}</p> <hr>
    <p><strong>Description:</strong> {{ $discussion->description }}</p> <hr>
    <p><strong>Brief:</strong> {{ $discussion->brief }}</p> <hr>
    <p><strong>Written by:</strong> {{ $discussion->user->name }}</p>

    {{-- Display tags --}}
    <div class="tags">
        Tags:
        <ul>
            @foreach ($discussion->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    </div>

    <div class="comments">
        <ul class="list-group">
            @foreach ($discussion->comments as $comment)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                    <strong>{{ $comment->created_at->diffForHumans() }} 

                    by 
                    @if($comment->user->isAdmin())
                        <i class="fas fa-crown" title="Administrator"></i>
                    @else
                        <i class="fas fa-user" title="User"></i>
                    @endif
                    {{ $comment->user->name }}
                  
                    </strong> {{-- Show the comment author --}}
                        {{ $comment->body }}
                        <p>Likes: {{ $comment->likers_count }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- Like Button --}}
                        <form action="{{ route('comment.like', ['comment' => $comment->id]) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-thumbs-up"></i> Like
                            </button>
                        </form>
                        {{-- Unlike Button --}}
                        <form action="{{ route('comment.unlike', ['comment' => $comment->id]) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-thumbs-down"></i> Unlike
                            </button>
                        </form>
                        {{-- Report Dropdown --}}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $comment->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-flag" aria-hidden="true"></i> Report
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                <a class="dropdown-item" href="#">Spam</a>
                                <a class="dropdown-item" href="#">Inappropriate</a>
                                <a class="dropdown-item" href="#">Other</a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach      
        </ul>
    </div>

    {{-- Comment Form --}}
    <div class="card">
        <div class="card-block">
            <form method="POST" action="{{ route('discussions.comments.store', ['discussion' => $discussion->id]) }}">
                @csrf
                <div class="form-group">
                    <textarea name="body" placeholder="Your comment here." class="form-control"></textarea>
                </div>

                {{-- Display errors or messages --}}
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
