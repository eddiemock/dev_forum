@extends('layouts.app')

@section('content')

<p>Details page</p>
<div class="container">
    <p><strong>Post Title:</strong> {{ $discussion->post_title }}</p> <hr>
    <p><strong>Description:</strong> {{ $discussion->description }}</p> <hr>
    <p><strong>Brief:</strong> {{ $discussion->brief }}</p> <hr>
    <p><strong>Written by:</strong> {{ $discussion->user->name }}</p>

    {{-- Display tags --}}
    <div class="tags">
        Tags:
        <ul>
            @foreach ($discussion->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    </div>
    {{-- Display session flash messages for like actions --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="tags">
            {{-- Your existing tags display --}}
        </div>

        <div class="comments">
            {{-- Start of comments display --}}
            @foreach ($discussion->comments as $comment)
                {{-- Existing comment display code --}}
            @endforeach
        </div>


    <div class="comments">
        <ul class="list-group">
            @foreach ($discussion->comments as $comment)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $comment->created_at->diffForHumans() }} 

                        by 
                        @if($comment->user->isAdmin())
                            <i class="fas fa-crown" title="Administrator"></i>
                        @else
                            <i class="fas fa-user" title="User"></i>
                        @endif
                        {{ $comment->user->name }}
                    
                        </strong> {{-- Show the comment author --}}
                            {{ $comment->body }}
                            <p>Likes: {{ $comment->likers_count }}</p>
                    </div>
                    {{-- "Delete" button visible only to admins and moderators --}}
                         @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isModerator()))
                         <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    <div class="d-flex align-items-center">
                        {{-- Like Button --}}
                        <form action="{{ route('comment.like', ['comment' => $comment->id]) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-thumbs-up"></i> Like
                            </button>
                        </form>
                        {{-- Unlike Button --}}
                        <form action="{{ route('comment.unlike', ['comment' => $comment->id]) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-thumbs-down"></i> Unlike
                            </button>
                        </form>
                        {{-- Report Comment Modal for each comment --}}
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $comment->id }}">
                            Report
                        </button>
                        <div class="modal fade" id="reportModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="reportModalLabel-{{ $comment->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reportModalLabel-{{ $comment->id }}">Report Comment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('report.comment', ['comment' => $comment->id]) }}"> 
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="reason-{{ $comment->id }}">Reason for Reporting:</label>
                                                <textarea class="form-control" id="reason-{{ $comment->id }}" name="reason" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach      
        </ul>
    </div>

    {{-- Comment Form --}}
    <div class="card">
        <div class="card-block">
            <form method="POST" action="{{ route('discussions.comments.store', ['discussion' => $discussion->id]) }}">
                @csrf
                <div class="form-group">
                    <textarea name="body" placeholder="Your comment here." class="form-control"></textarea>
                </div>

                {{-- Display errors or messages --}}
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Start of Report Comment Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="reportForm"> 
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason">Reason for Reporting:</label>
                        <textarea class="form-control" id="reason" name="reason" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Report Comment Modal -->



@push('scripts')
<!-- Include Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Example: Show modal automatically - you can remove this if not needed
        $('#reportModal').modal('show');

        // Handle the form submission
        $('#reportForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            // Perform your validation or adjustments here
            
            // When ready, submit the form
            this.submit(); // or $(this).submit(); if you prefer jQuery
        });
    });
</script>

@endpush

<style>
    /* Container and General Styles */
    .container {
        font-family: 'Nunito', sans-serif;
        max-width: 1200px;
        margin: auto;
    }

    h1, h2, h3, h4, h5, p {
        color: #333;
    }

    /* Comment and Discussion Styles */
    .discussion-item, .comment-item {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .tags ul {
        padding: 0;
    }

    .tags li {
        display: inline-block;
        background: #eff;
        border-radius: 5px;
        padding: 5px 10px;
        margin-right: 5px;
        font-size: 14px;
    }

    /* Button Styles */
    .btn {
        margin-right: 10px;
        border-radius: 20px;
    }

    .btn-sm {
        padding: 5px 10px;
    }

    .btn-outline-success, .btn-outline-danger, .btn-outline-secondary {
        border-color: transparent;
    }

    /* Form Styles */
    textarea {
        border-radius: 5px;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    /* Modal Customization */
    .modal-content {
        border-radius: 10px;
    }

    .modal-header, .modal-footer {
        border-bottom: none;
        border-top: none;
    }

    .modal-body {
        padding: 20px;
    }
    /* Add your custom CSS here */
    .modal-header {
            background-color: #f8f9fa;
        }
        .modal-title {
            color: #007bff;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            background-color: #f8f9fa;
        }
</style>

@endsection
