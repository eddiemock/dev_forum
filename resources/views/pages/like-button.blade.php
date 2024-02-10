<div>
<form action="{{ route('discussion.like', ['discussion' => $discussion]) }}" method="POST">
    @csrf
    <button type="submit">Like</button>
</form>


<form action="{{ route('discussion.unlike', ['discussion' => $discussion]) }}" method="POST">
    @csrf
    <button type="submit">Unlike</button>
</form>


</div>