@extends('layouts.app')

@section('content')

<p>Details page</p>
<div class="container">
    <p>{{ $discussion->post_title }}</p> <hr>
    <p>{{ $discussion->description }}</p> <hr>
    <p>{{ $discussion->brief }}</p> <hr>
    <p>Written by: {{ $discussion->user->name }}</p>


</div>




@endsection