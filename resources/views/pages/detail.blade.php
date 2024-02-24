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
                <li class="list-group-item">
                    <strong>{{ $comment->created_at->diffForHumans() }}  &nbsp;</strong>
                    {{ $comment->body }}
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
