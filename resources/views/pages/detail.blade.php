@extends('layouts.app')

@section('content')

<p>Details page</p>
<div class="container">
    <p>{{ $discussion->post_title }}</p> <hr>
    <p>{{ $discussion->description }}</p> <hr>
    <p>{{ $discussion->brief }}</p> <hr>
    <p>Written by: {{ $discussion->user->name }}</p>


    <div class="comments">

        <ul class="list-group">

        @foreach ($discussion->comments as $comment)
        
                <li class="list-group-item">
                        <strong>

                             {{ $comment->created_at->diffForHumans() }}  &nbsp; 


                        </strong>
                       
                        
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


                                <textarea name="body" placeholder="Your comment here." class="form-control">  </textarea>
                        </div>
        
        
                        <div class="form-group">


                                <button type="submit" class="btn btn-primary">Add Comment</button>


                        </div>
                </form>
</div>


</div>




@endsection