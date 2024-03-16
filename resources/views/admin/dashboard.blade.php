@extends('layouts.app')

@section('content')
<div class="container mt-5 admin-dashboard"> <!-- Added admin-dashboard class for scoped styling -->
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-12"> <!-- Adjusted for full width -->
            <h2>Flagged Comments</h2>
            @foreach($flaggedComments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p>{{ $comment->body }}</p>
                    <p>Flagged by: {{ $comment->user_name }}</p>
                    
                    @php
                        $categories = json_decode($comment->flagged_categories, true);
                    @endphp

                    @if(is_array($categories) && !empty($categories))
                        <p>Flagged Categories:</p>
                        <div class="list-group mb-3"> <!-- Enhanced list group -->
                            @foreach($categories as $category => $status)
                                @if($status)
                                    <div class="list-group-item">{{ ucfirst($category) }}</div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p>No flagged categories.</p>
                    @endif

                    <div class="d-flex justify-content-start"> <!-- Button spacing -->
                        <form method="POST" action="{{ route('admin.comment.approve', $comment->id) }}" class="me-2">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comment.delete', $comment->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12"> <!-- Full width for email section -->
            <h2>Send Mental Health Support Email</h2>
            <form method="POST" action="{{ route('admin.sendSupportEmail') }}" class="mb-3">
                @csrf
                <div class="form-group">
                    <label for="userSelect">Select User:</label>
                    <select id="userSelect" name="user_id" class="form-control">
                        @foreach($users as $user) <!-- Assuming $users is passed to the view -->
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">Send Support Email</button>
            </form>
        </div>
    </div>
    <!-- Assuming this is another row or part of the dashboard -->
    <div class="row mt-4">
        <div class="col-md-6"> <!-- Adjusted for narrower form -->
            <h2>Add New Category</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="create-category-form"> <!-- Added class for form -->
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
                </div>
                <div class="form-group">
                    <label for="description">Category Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter category description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Category</button>
            </form>
        </div>
    </div>
</div>
@endsection
