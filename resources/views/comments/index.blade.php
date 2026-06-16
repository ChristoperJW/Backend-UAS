@foreach ($posts as $post)

    <div style="display: flex; align-items: center; gap: 10px;">
    <img src="{{ asset('images/profile.png') }}" width="40">
    <strong>{{ $post->user->name }}</strong>
    </div>

    <img src="{{ asset('uploads/posts/' . $post->media) }}" width="400">
    <p>Caption : {{ $post->caption }}</p>
    <hr>

    @forelse($post->comments as $i => $comment)
        <p>Komen {{ $i + 1 }} : {{ $comment->user?->name ?? 'Pengguna Dihapus' }} - {{ $comment->content }}</p>

        @if ($comment->user_id == session('current_user_id'))
            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
                    <img src="{{ asset('images/Trash.png') }}" width="50">
                </button>
                <hr>
            </form>
        @endif
    @empty
        <p>Belum ada komentar</p>
    @endforelse

    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="text" name="komentar" placeholder="Tulis komentar..." required>
        <button type="submit">Send</button>
    </form>
    <hr>
@endforeach

<a href="{{ route('posts.index') }}">Back To Posts</a>
<br>
<a href="/">Back To Homepage</a>