@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <h2>this is dashboard</h2>

    <div class="container">
        @forelse ($discussions as $discussion)
            <p><strong>Title:</strong> {{ $discussion->post_title }}</p> 
            <p><strong>Description:</strong> {{ $discussion->description }}</p>
            <!-- Assuming 'brief' is another field you want to display -->
            <p><strong>Brief:</strong> {{ $discussion->brief }}</p> 
            <hr>
        @empty
            <p>No posts for this user</p>
        @endforelse
    </div>
</div>
@endsection
