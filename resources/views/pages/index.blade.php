@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Side Column for Support Groups and Appointments -->
        <div class="col-md-4"> <!-- Smaller column size for side column -->
    <!-- Scheduled Support Groups Card -->
    <div class="card mb-4">
        <div class="card-header">Scheduled Support Groups</div>
        <div class="card-body">
            @forelse ($supportGroups as $group)
                <div class="support-group">
                    <h3>{{ $group->name }}</h3>
                    <p>Topic: {{ $group->topic }}</p>
                    <small>Scheduled for: {{ $group->scheduled_at->format('F d, Y h:i A') }}</small>
                    <!-- Trigger/Button for the Modal -->
                    <button type="button" class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#supportGroupModal{{ $group->id }}">
                        View Group
                    </button>
                </div>
                <hr>
                <!-- Modal Structure -->
                <div class="modal fade" id="supportGroupModal{{ $group->id }}" tabindex="-1" aria-labelledby="supportGroupModalLabel{{ $group->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="supportGroupModalLabel{{ $group->id }}">{{ $group->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Topic: {{ $group->topic }}</p>
                                <p>Scheduled for: {{ $group->scheduled_at->format('F d, Y h:i A') }}</p>
                                @if($group->location)
                                    <p>Location: {{ $group->location }}</p>
                                @endif
                                <p>{{ $group->description }}</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('support_groups.register', $group->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Join Group</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Structure -->
            @empty
                <p>No scheduled support groups.</p>
            @endforelse
        </div>
    </div>
    
    <!-- My Appointments Card -->
    <div class="card">
        <div class="card-header">My Appointments</div>
        <div class="card-body">
            @forelse ($appointments as $appointment)
                <div class="appointment">
                    <h4>Appointment with {{ $appointment->professional->name }}</h4>
                    <p>Date and Time: {{ $appointment->appointment_time->format('F d, Y h:i A') }}</p>
                    <p>Location: {{ $appointment->professional->location }}</p>
                    <p>Notes: {{ $appointment->notes ?? 'N/A' }}</p>


                    <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                        Cancel Appointment
                    </button>
                </form>
                </div>
                <hr>
            @empty
                <p>You have no upcoming appointments.</p>
            @endforelse
        </div>
    </div>
</div>


        <!-- Main Column for Categories -->
        <div class="col-md-8"> <!-- Larger column size for main content -->
            <!-- Categories Card -->
            <div class="card">
                <div class="card-header"><h1 class="card-title">Categories</h1></div>
                <div class="card-body">
                    @forelse ($categories as $category)
                        <div class="category mb-3"> <!-- mb-3 adds some spacing between categories -->
                            <h3>{{ $category->name }}</h3>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary">View Category</a>
                        </div>
                        <hr>
                    @empty
                        <p>No categories available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
@endsection
