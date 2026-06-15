<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="300">
</a>

<h1>Detail Post</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<p>
    <strong>Caption:</strong>
    <br>
    {{ $post->caption }}
</p>

<p>
    <strong>Media:</strong>
    <br>

    @if ($post->media && file_exists(public_path('uploads/posts/' . $post->media)))
        @php
            $extension = strtolower(pathinfo($post->media, PATHINFO_EXTENSION));
        @endphp

        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
            <img src="{{ asset('uploads/posts/' . $post->media) }}" width="300">
        @elseif (in_array($extension, ['mp4']))
            <video width="400" controls preload = "metadata">
                <source src="{{ asset('uploads/posts/' . $post->media) }}" type="video/mp4">
                Browser tidak mendukung video.
            </video>
        @endif
    @else
        Tidak ada media
    @endif
</p>

<p>
    <strong>Posted By:</strong>
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

<p>
    <strong>Jumlah Komentar:</strong>
    {{ $post->comments->count() }}
</p>

<p>
    <strong>Jumlah Repost:</strong>
    {{ $post->reposts->count() }}
</p>

<p>
    <strong>Jumlah Favorit:</strong>
    {{ $post->favorites->count() }}
</p>

<p>
    <strong>Hashtags:</strong> 
    <br>
    @foreach ($post->tags as $tag)
        #{{ $tag->name }}
    @endforeach
</p>

@php
    $alreadyLiked = $post->likes->where('user_id', session('current_user_id'))->count() > 0;
    $alreadyFavorited = $post->favorites->where('user_id', session('current_user_id'))->count() > 0;
@endphp

@if (!$alreadyLiked)
    <form method="POST" action="{{ route('posts.like', $post) }}" style="display:inline;">
        @csrf
        <button type="submit">Like</button>
    </form>
@else
    <form method="POST" action="{{ route('posts.unlike', $post) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Unlike</button>
    </form>
@endif

@if ($post->user_id != session('current_user_id'))
    <form method="GET" action="{{ route('posts.repost.create', $post) }}" style="display:inline;">
        <button type="submit">Repost</button>
    </form>
@endif

@if (!$alreadyFavorited)
    <form method="POST" action="{{ route('posts.favorite', $post) }}" style="display:inline;">
        @csrf
        <button type="submit">Simpan ke Favorit</button>
    </form>
@else
    <form method="POST" action="{{ route('posts.unfavorite', $post) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus dari Favorit</button>
    </form>
@endif

<br><br>

<a href="{{ route('posts.edit', $post) }}">Ubah Post</a>
<br>
<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>
<br>
<a href="/">Kembali ke Homepage</a>