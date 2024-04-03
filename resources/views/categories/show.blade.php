@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Information note about respect and kindness --}}
    <div style="background-color: #fff3cd; border-left: 4px solid #ffeeba; padding: 20px; margin-bottom: 20px; border-radius: 5px;">
        <strong>Note:</strong> Let's treat each other with respect and kindness. This is a community where everyone's voice is valued. Please engage thoughtfully and refrain from any behavior that could be harmful or disrespectful to others.
    </div>

    <h1 style="color: #3490dc;">{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>
    
    {{-- Discussions list --}}
    @foreach ($discussions as $discussion)
        <div class="discussion-item" style="margin-bottom: 20px; padding: 10px; border: 1px solid #dee2e6; border-radius: 5px;">
            <a href="{{ route('discussions.detail', ['category' => $category->id, 'id' => $discussion->id]) }}" style="font-size: 18px; color: #007bff; text-decoration: none; display: block;">
                {{ $discussion->post_title }}
            </a>
            <small style="display: block; margin-top: 5px;">Posted on: {{ $discussion->created_at->format('m/d/Y') }}</small>
            {{-- Display other discussion details as needed --}}
        </div>
    @endforeach

    {{-- Pagination links --}}
    <div style="margin-top: 20px;">
        {{ $discussions->links() }}
    </div>

    {{-- Form for adding a new discussion --}}
    <div style="background-color: #f8fafc; padding: 20px; border-radius: 5px; margin-top: 40px;">
        <form method="POST" action="{{ route('discussions.store', ['category' => $category->id]) }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="post_title" style="display: block; margin-bottom: 5px;">Title</label>
                <input type="text" name="post_title" id="post_title" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="description" style="display: block; margin-bottom: 5px;">Description</label>
                <textarea name="description" id="description" required style="width: 100%; padding: 8px; height: 100px;"></textarea>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="brief" style="display: block; margin-bottom: 5px;">Brief</label>
                <textarea name="brief" id="brief" required style="width: 100%; padding: 8px; height: 100px;"></textarea>
            </div>
            <button type="submit" style="background-color: #38c172; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Add Discussion</button>
        </form>
    </div>
</div>
@endsection
