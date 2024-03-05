<div>
<form action="{{ route('comment.like', ['comment' => $comment->id]) }}" method="POST" class="mr-2">
    @csrf
    <button type="submit" class="btn btn-outline-success btn-sm">
        <i class="fas fa-thumbs-up"></i> Like
    </button>
</form>

<form action="{{ route('comment.unlike', ['comment' => $comment->id]) }}" method="POST" class="mr-2">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">
        <i class="fas fa-thumbs-down"></i> Unlike
    </button>
</form>
</div>
