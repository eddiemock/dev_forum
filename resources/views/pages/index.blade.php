@extends('layouts.app')

@section('content')

<h1>{{__('profile.Home')}}</h1>


@forelse ($discussions as $discussion)



        <a href="/detail/{{$discussion->id}}">
            {{ $discussion->post_title }}
        </a>


<p>Description: {{ $discussion->description }}</p>
<p>Written by: {{ $discussion->user->name }}</p>
<a href="/detail/{{$discussion->id}}">Read more</a>

<hr>

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

<hr>

<div class="card">

        <div class="card-block">

                <form method="POST" action="/detail/{{ $discussion->id }}/comments/">

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
<hr>
@empty
<p>No posts for this user</p>
@endforelse

{{ $discussions->links() }}
    
@endsection
