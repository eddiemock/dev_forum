@extends('layouts.app')

@section('content')

<h1>{{__('profile.Home')}}</h1>


@forelse ($discussions as $discussion)

<p>Title: {{ $discussion->post_title }}</p>
<p>Description: {{ $discussion->description }}</p>
<p>Written by: {{ $discussion->user->name }}</p>
<a href="/detail/{{$discussion->id}}">Read more</a>

<hr>
@empty
<p>No posts for this user</p>
@endforelse

{{ $discussions->links() }}
    
@endsection
