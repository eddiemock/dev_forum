@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <h2>Categories</h2>

    @forelse ($categories as $category)
        <div>
            <h3>{{ $category->name }}</h3>
            {{-- Assuming you have a route named 'categories.show' that expects a category's ID --}}
            <a href="{{ route('categories.show', $category->id) }}">View Category</a>
        </div>
        <hr>
    @empty
        <p>No categories available.</p>
    @endforelse
</div>
@endsection
