@extends('layouts.app')

@section('content')

<h1>{{__('profile.Home')}}</h1>


@forelse ($discussions as $discussion)

<p>Title: {{ $discussion->post_title }}</p>
<p>Description: {{ $discussion->description }}</p>
<p>Written by: {{ $discussion->user->name }}</p>
<a href="/detail/{{$discussion->id}}">Read more</a>


<div class="card">

        <div class="card-block">

            <form method="POST" action="/dicussions/{{ $discussion->id }}/comments/">

                <div class="form-group">

                    

                        <textarea name="body" placeholder="Your comment here.". class="form-control">
                        
                        </textarea>

                    </div>
            </form>

        
                <div class="form-group">

                        <button type="submit" class="btn btn-primary">Submit</button>


                </div>

        </div>
</div>
<hr>
@empty
<p>No posts for this user</p>
@endforelse

{{ $discussions->links() }}
    
@endsection
