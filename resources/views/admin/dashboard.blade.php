@extends('layouts.app')

@section('content')
<div class="container mt-5 admin-dashboard">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div id="usersAccordion">
    @foreach($usersWithFlaggedComments as $user)
        @if($user->comments->isNotEmpty())
            <div class="user-section mb-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton-{{ $user->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $user->name }} - {{ $user->comments->count() }} Flagged Comments
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                        @foreach($user->comments as $comment)
                            <a class="dropdown-item" href="#">
                                {{ $comment->body }}
                                <ul>
                                    @php
                                        $flaggedCategories = json_decode($comment->flagged_categories, true);
                                    @endphp
                                    @if(!empty($flaggedCategories) && is_array($flaggedCategories))
                                        @foreach($flaggedCategories as $category => $flagged)
                                            @if($flagged)
                                                <li>{{ ucfirst($category) }}</li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <!-- Check depressive_classification and display 'Possibly Depressive' -->
                                    @if($comment->depressive_classification)
                                        <li><strong>Possibly Depressive</strong></li>
                                    @endif
                                </ul>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

</div>

<div class="row mt-4">
        <div class="col-md-4 mb-4"> <!-- Half width for email section -->
            <h2>Send Mental Health Support Email</h2>
            <form method="POST" action="{{ route('admin.sendSupportEmail') }}" class="mb-3">
                @csrf
                <div class="form-group">
                    <label for="userSelect">Select User:</label>
                    <select id="userSelect" name="user_id" class="form-control">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">Send Support Email</button>
            </form>
        </div>
        <div class="col-md-4 mb-4">
            <h2>Add New Category</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="create-category-form">
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
        <div class="col-md-4 mb-4">
            <h2>Create New Support Group</h2>
            <form method="POST" action="{{ route('support_groups.store') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="groupName">Group Name</label>
                    <input type="text" class="form-control" id="groupName" name="name" placeholder="Enter group name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="topicSelect">Topic:</label>
                    <select id="topicSelect" name="topic" class="form-control">
                        <option value="Depression">Depression</option>
                        <option value="PTSD">PTSD</option>
                        <option value="Stress">Stress</option>
                        <option value="Autism">Autism</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="scheduledAt">Scheduled At</label>
                    <input type="datetime-local" class="form-control" id="scheduledAt" name="scheduled_at" required>
                </div>
                <div class="form-group mb-3">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location (e.g., online link or physical address)">
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description (Optional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter a brief description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Create Support Group</button>
            </form>
        </div>    
</div>            

<div class="row">
        <div class="col-md-6 mb-4">
            <h2>Assign Role to User</h2>
            <form method="POST" action="{{ route('admin.users.assign-role') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="user_id">Select User:</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="role_id">Assign Role:</label>
                    <select id="role_id" name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Assign Role</button>
            </form>
        </div>
        <div class="col-md-6 mb-4">
         <div class="reported-comments-container mt-5">
                <h2>Reported Comments</h2>
                @forelse($reportedComments as $reportedComment)
                    <div class="card mb-3">
                        <div class="card-header">
                            Comment by {{ $reportedComment->user->name }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Reported Comment</h5>
                            <p class="card-text">{{ $reportedComment->body }}</p>
                            <p class="mb-0">Reports: {{ $reportedComment->reports->count() }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($reportedComment->reports as $report)
                                <li class="list-group-item">Reason: {{ $report->reason }}</li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p>No reported comments.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
@endsection
