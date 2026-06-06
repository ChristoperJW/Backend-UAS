<h1>Feeds</h1>
<hr>

@if($posts->isEmpty())
    <p>Sedang tidak ada postingan</p>
@else
    @foreach($posts as $index => $post)
        <p>Post {{ $index + 1 }} : {{ $post->user->name }}</p>
        <img src="{{ asset('images/' . $post->media) }}" width="400">
        <p>Caption : {{ $post->caption }}</p>
        <hr>

        @forelse($post->comments as $i => $comment)
            <p>Komen {{ $i + 1 }} : {{ $comment->user->name }} - {{ $comment->content }}</p>

            @if ($comment->user_id == session('current_user_id'))
            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
                    <img src="{{ asset('images/Trash.png') }}" width="50">
                </button>
            </form>
            @endif
        @empty
            <p>Belum ada komentar</p>
        @endforelse

        <form action="{{ route('feeds.comment', $post) }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="text" name="komentar" placeholder="Tulis komentar..." required>
            <button type="submit">Kirim</button>
        </form>
        <hr>
    @endforeach
@endif
<br>
<a href="/">Kembali ke Homepage</a>