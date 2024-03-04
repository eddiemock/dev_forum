@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>
    
    {{-- Discussions list --}}
    @foreach ($discussions as $discussion)
        <div>{{ $discussion->post_title }}</div>
        {{-- Display other discussion details as needed --}}
    @endforeach

    {{-- Pagination links --}}
    {{ $discussions->links() }}

    {{-- Form for adding a new discussion --}}
    <form method="POST" action="{{ route('discussions.store', ['category' => $category->id]) }}">
        @csrf
        <div>
            <label for="post_title">Title</label>
            <input type="text" name="post_title" id="post_title" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div>
            <label for="brief">Brief</label>
            <textarea name="brief" id="brief" required></textarea>
        </div>
        <button type="submit">Add Discussion</button>
    </form>
</div>
@endsection
