<h1>Comment</h1>
<img src="{{ asset('images/' . $comment->post->media) }}" width="400">
<p>Caption : {{ $comment->post->caption }}</p>
<hr>
@foreach ($comment->post->comments as $index => $item)
<p>komen {{ $index + 1 }} : {{ $item->user->name }} - {{ $item->content }}</p>

@if ($item->user_id == session('current_user_id'))
<form action="{{ route('comments.destroy', $item) }}" method="post">
    @csrf @method('DELETE')
    <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
        <img src="{{ asset('images/Trash.png') }}" width="50">
    </button>
</form>
@endif
<hr>
@endforeach

<a href="{{ route('comments.create', ['post_id' => $comment->post_id]) }}">
    <button>Tambah Comment Baru</button>
</a>
<br>

<a href="{{ route('comments.index') }}">Back</a>