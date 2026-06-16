<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>Detail Post</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th style="width: 150px">Caption</th>
        <td style="width: 500px">{{ $post->caption }}</td>
    </tr>

    <tr>
        <th>Media</th>
        <td>
            @if ($post->media)
                @php
                    $extension = strtolower(pathinfo($post->media, PATHINFO_EXTENSION));
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('uploads/posts/' . $post->media) }}" width="300">
                @elseif (in_array($extension, ['mp4']))
                    <video width="400" controls>
                        <source src="{{ asset('uploads/posts/' . $post->media) }}" type="video/mp4">
                        Browser tidak mendukung video.
                    </video>
                @endif
            @else
                Tidak ada media
            @endif
        </td>
    </tr>

    <tr>
        <th>Posted By</th>
        <td>
            @if ($post->user)
                {{ $post->user->name ?? $post->user->fullName ?? $post->user->email }}
            @else
                User ID: {{ $post->user_id }}
            @endif
        </td>
    </tr>

    <tr>
        <th>Jumlah Like</th>
        <td>{{ $post->likes->count() }}</td>
    </tr>

    <tr>
        <th>Jumlah Komentar</th>
        <td>{{ $post->comments->count() }}</td>
    </tr>

    <tr>
        <th>Jumlah Repost</th>
        <td>{{ $post->reposts->count() }}</td>
    </tr>

    <tr>
        <th>Jumlah Favorit</th>
        <td>{{ $post->favorites->count() }}</td>
    </tr>

    <tr>
        <th>Hashtags</th>
        <td>
            @forelse ($post->tags as $tag)
                #{{ $tag->name }}
                <br>
            @empty
                Tidak ada hashtag
            @endforelse
        </td>
    </tr>

    <tr>
        <th>Tagged Users</th>
        <td>
            @forelse ($post->taggedUsers as $user)
                {{ '@' . $user->name }}
                <br>
            @empty
                Tidak ada user yang ditandai
            @endforelse
        </td>
    </tr>
</table>

<br>

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