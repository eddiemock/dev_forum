@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Scheduled Support Groups Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Scheduled Support Groups</div>
                <div class="card-body">
                    @forelse ($supportGroups as $group)
                        <div class="support-group">
                            <h3>{{ $group->name }}</h3>
                            <p>Topic: {{ $group->topic }}</p>
                            <small>Scheduled for: {{ $group->scheduled_at }}</small>
                            <a href="#" class="btn btn-secondary btn-sm mt-2">View Group</a>
                        </div>
                        <hr>
                    @empty
                        <p>No scheduled support groups.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Dashboard</h1>
                </div>

                <div class="card-body">
                    <h2 class="mb-4">Categories</h2>

                    @forelse ($categories as $category)
                        <div class="category">
                            <h3>{{ $category->name }}</h3>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary">View Category</a>
                        </div>
                        <hr class="mt-3 mb-3">
                    @empty
                        <p>No categories available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
