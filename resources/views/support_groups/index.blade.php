{{-- resources/views/support_groups/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Support Groups</h1>
    <a href="{{ route('support_groups.create') }}" class="btn btn-primary mb-3">Create New Group</a>
    <div class="list-group">
        @forelse ($supportGroups as $group)
            <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">{{ $group->name }}</h5>
                <p class="mb-1">Topic: {{ $group->topic }}</p>
                <small>Scheduled for: {{ $group->scheduled_at->toDayDateTimeString() }}</small>
                @if($group->description)
                    <p class="mb-0">Description: {{ $group->description }}</p>
                @endif
            </a>
        @empty
            <p>No support groups found.</p>
        @endforelse
    </div>
</div>
@endsection
