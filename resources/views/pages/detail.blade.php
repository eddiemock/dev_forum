@extends('layouts.app')

@section('content')

<p>Details page</p>
<div class="container">
    <p>{{ $discussion->post_title }}</p> <hr>
    <p>{{ $discussion->description }}</p> <hr>
    <p>{{ $discussion->brief }}</p> <hr>
    <p>Written by: {{ $discussion->user->name }}</p>

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
                @include('pages.like-button')
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $comment->created_at->diffForHumans() }}  &nbsp;</strong>
                        {{ $comment->body }}
                    </div>
                    <div>
                        {{-- Report button and dropdown menu --}}
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

    <div class="card">
        <div class="card-block">
            <form method="POST" action="/detail/{{ $discussion->id }}/comments">
                {{ csrf_field() }}
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
