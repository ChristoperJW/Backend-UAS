<h1>Detail Post</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<p>
    <strong>Caption:</strong>
    <br>
    {{ $post->caption }}
</p>

<p>
    <strong>Media:</strong>
    <br>
    {{ $post->media }}
</p>

<p>
    <strong>User:</strong>
    <br>
    @if ($post->user)
        {{ $post->user->name ?? $post->user->fullName ?? $post->user->email }}
    @else
        User ID: {{ $post->user_id }}
    @endif
</p>

<p>
    <strong>Jumlah Like:</strong>
    {{ $post->likes->count() }}
</p>

<form method="POST" action="{{ route('posts.like', $post) }}" style="display:inline;">
    @csrf
    <button type="submit">Like</button>
</form>

<form method="POST" action="{{ route('posts.unlike', $post) }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit">Unlike</button>
</form>

<br><br>

<a href="{{ route('posts.edit', $post) }}">Ubah Post</a>
<br>
<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>
<br>
<a href="/">Kembali ke Homepage</a>