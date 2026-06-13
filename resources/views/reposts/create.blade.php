<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="250">
</a>

<h1>Repost</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<h3>Post Asli</h3>

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
    <strong>Posted By:</strong>
    <br>
    @if ($post->user)
        {{ $post->user->name }}
    @else
        User ID: {{ $post->user_id }}
    @endif
</p>

<p>
    <strong>Hashtags:</strong>
    <br>
    @forelse ($post->tags as $tag)
        #{{ $tag->name }}<br>
    @empty
        -
    @endforelse
</p>

<hr>

<form method="POST" action="{{ route('posts.repost', $post) }}">
    @csrf

    Caption Repost (opsional):
    <br>
    <textarea name="caption" rows="4" cols="50" placeholder="Tambahkan komentar untuk repost ini..."></textarea>

    <br><br>

    <button type="submit">Repost</button>
</form>

<br>

<a href="{{ route('posts.show', $post) }}">Kembali ke Detail Post</a>
<br>
<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>