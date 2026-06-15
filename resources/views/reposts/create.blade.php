<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>Repost</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<h2>Post Asli</h2>

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
                {{ $post->user->name }}
            @else
                User ID: {{ $post->user_id }}
            @endif
        </td>
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
</table>

<br>

<h2>Caption Repost</h2>

<form method="POST" action="{{ route('posts.repost', $post) }}">
    @csrf

    Caption Repost (opsional):
    <br>
    <textarea name="caption" rows="4" cols="60" placeholder="Tambahkan komentar untuk repost ini...">{{ old('caption') }}</textarea>

    <br><br>

    <button type="submit">Repost</button>
</form>

<br>

<a href="{{ route('posts.show', $post) }}">Kembali ke Detail Post</a>
<br>
<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>