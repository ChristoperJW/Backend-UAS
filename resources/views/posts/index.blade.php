<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>Daftar Post</h1>

<a href="{{ route('posts.my') }}">My Posts</a>
<br>
<a href="{{ route('favorites.index') }}">Favorite Posts</a>
<br>
<a href="{{ route('reposts.index') }}">My Repost</a>
<br>
<a href="/">Kembali ke Homepage</a>

<br><br>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<h2>Stories</h2>

<a href="{{ route('stories.create') }}">
    <button>Buat Story</button>
</a>

<br><br>

@if(isset($stories) && $stories->isEmpty())
    <p>Belum ada story.</p>
@elseif(isset($stories))
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th style="width: 150px">Posted By</th>
                <th style="width: 250px">Caption</th>
                <th style="width: 220px">Media</th>
                <th style="width: 180px">Dibuat</th>
                <th style="width: 120px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($stories as $story)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>

                    <td>
                        @if($story->user)
                            {{ $story->user->name }}
                        @else
                            User ID: {{ $story->user_id }}
                        @endif
                    </td>

                    <td>
                        @if($story->caption)
                            {{ $story->caption }}
                        @else
                            -
                        @endif
                    </td>

                    <td style="text-align: center">
                        @php
                            $extension = strtolower(pathinfo($story->media, PATHINFO_EXTENSION));
                        @endphp

                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('uploads/stories/' . $story->media) }}" width="180">
                        @elseif(in_array($extension, ['mp4']))
                            <video width="180" controls>
                                <source src="{{ asset('uploads/stories/' . $story->media) }}" type="video/mp4">
                                Browser tidak mendukung video.
                            </video>
                        @endif
                    </td>

                    <td>
                        {{ $story->created_at }}
                    </td>

                    <td style="text-align: center">
                        @if($story->user_id == session('current_user_id'))
                            <form method="POST" action="{{ route('stories.destroy', $story) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<br>
<hr>

<h2>Posts</h2>

<a href="{{ route('posts.create') }}">
    <button>Buat Post Baru</button>
</a>

<br><br>

<form method="GET" action="{{ route('posts.index') }}">
    Cari Caption:
    <br>
    <input type="text" name="search" value="{{ $search ?? '' }}" style="width: 300px;">

    <br><br>

    Cari Hashtag:
    <br>
    <select name="tag">
        <option value="">Semua Hashtag</option>

        @foreach ($tags as $item)
            <option value="{{ $item->id }}" {{ ($tag ?? '') == $item->id ? 'selected' : '' }}>
                #{{ $item->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Cari</button>
</form>

<br>

<a href="{{ route('posts.index') }}">Reset Filter</a>

<br><br>

@if ($posts->isEmpty())
    <p>Belum ada post yang tersimpan.</p>
@else
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th style="width: 250px">Caption</th>
                <th style="width: 220px">Media</th>
                <th style="width: 150px">Posted By</th>
                <th style="width: 80px">Like</th>
                <th style="width: 100px">Comment</th>
                <th style="width: 100px">Repost</th>
                <th style="width: 100px">Favorite</th>
                <th style="width: 220px">Aksi</th>
                <th style="width: 180px">Hashtags</th>
                <th style="width: 180px">Tagged Users</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>

                    <td>
                        <a href="{{ route('posts.show', $post) }}">
                            {{ $post->caption }}
                        </a>
                    </td>

                    <td style="text-align: center">
                        @if ($post->media)
                            @php
                                $extension = strtolower(pathinfo($post->media, PATHINFO_EXTENSION));
                            @endphp

                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('uploads/posts/' . $post->media) }}" width="180">
                            @elseif (in_array($extension, ['mp4']))
                                <video width="180" controls>
                                    <source src="{{ asset('uploads/posts/' . $post->media) }}" type="video/mp4">
                                    Browser tidak mendukung video.
                                </video>
                            @endif
                        @else
                            Tidak ada media
                        @endif
                    </td>

                    <td>
                        @if ($post->user)
                            {{ $post->user->name ?? $post->user->fullName ?? $post->user->email }}
                        @else
                            User ID: {{ $post->user_id }}
                        @endif
                    </td>

                    <td style="text-align: center">
                        <img src="{{ asset('images/like.png') }}" width="25"> <br>
                        {{ $post->likes->count() }}</td>
                    <td style="text-align: center">
                        <img src="{{ asset('images/comment.png') }}" width="25"> <br>
                        {{ $post->comments->count() }}</td>
                    <td style="text-align: center">
                        <img src="{{ asset('images/repost.png') }}" width="25"> <br>
                        {{ $post->reposts->count() }}</td>
                    <td style="text-align: center">
                        <img src="{{ asset('images/fav.png') }}" width="25"> <br>
                        {{ $post->favorites->count() }}</td>

                    <td style="text-align: center">
                        <a href="{{ route('posts.show', $post) }}">Detail</a>
                        |
                        <a href="{{ route('posts.edit', $post) }}">Ubah</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; cursor:pointer; padding:0;">
                                <img src="{{ asset('images/Trash.png') }}" width="25">
                            </button>
                        </form>
                    </td>

                    <td>
                        @forelse ($post->tags as $tagItem)
                            <a href="{{ route('posts.index', ['tag' => $tagItem->id]) }}">
                                #{{ $tagItem->name }}
                            </a>
                            <br>
                        @empty
                            Tidak ada hashtag
                        @endforelse
                    </td>

                    <td>
                        @forelse ($post->taggedUsers as $user)
                            {{ '@' . $user->name }}
                            <br>
                        @empty
                            Tidak ada user
                        @endforelse
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif