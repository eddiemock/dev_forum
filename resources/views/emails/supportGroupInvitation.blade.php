<h1>Invitation to Join Support Group</h1>

<p>Dear {{ $user->name }},</p>

<p>You are invited to join the "{{ $supportGroup->name }}" support group.</p>

<p>Details:</p>
<ul>
    <li>Topic: {{ $supportGroup->topic }}</li>
    <li>Description: {{ $supportGroup->description }}</li>
    Scheduled for: {{ \Carbon\Carbon::parse($supportGroup->scheduled_at)->format('F d, Y h:i A') }}
    <li>Location: {{ $supportGroup->location }}</li>
</ul>

<p>We hope to see you there!</p>
