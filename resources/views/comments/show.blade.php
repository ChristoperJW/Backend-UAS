<h1>Komentar untuk post: {{ $comment->post->caption }}</h1>
<hr>
@foreach ($comment->post->comments as $index => $item)
<p>komen {{ $index + 1 }} : {{ $item->content }}</p>
<form action="{{ route('comments.destroy', $item) }}" method="post">
    @csrf @method('DELETE')
    <button type="submit">Delete</button>
</form>
<hr>
@endforeach

<a href="{{ route('comments.create', ['post_id' => $comment->post_id]) }}">
    <button>Tambah Comment Baru</button>
</a>
<br>

<a href="{{ route('comments.index') }}">Kembali</a>