<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="250">
</a>

<h1>Daftar Post</h1>

<a href="{{ route('posts.my') }}">My Posts</a>
<br><br>
<a href="/">Kembali ke Homepage</a>
<br><br>

<a href="{{ route('posts.create') }}">
    <button>Buat Post Baru</button>
</a>

<br><br>

<form method="GET" action="{{ route('posts.index') }}">
    Cari Caption:
    <br>
    <input type="text" name="search" value="{{ $search ?? '' }}">

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

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error')}}</p>
@endif

@if ($posts->isEmpty())
    <p>Belum ada post yang tersimpan.</p>
@else
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th style="width: 50px">No</th>
            <th style="width: 250px">Caption</th>
            <th style="width: 200px">Media</th>
            <th style="width: 150px">Posted By</th>
            <th style="width: 80px">Like</th>
            <th style="width: 100px">Komentar</th>
            <th style="width: 220px">Aksi</th>
            <th style="width: 200px">Hashtags</th>
            <th style="width: 200px">Tagged Users</th>
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
            <td><img src="{{ asset('images/' . $post->media) }}" width="200"></td>
            <td>
                @if ($post->user)
                    {{ $post->user->name ?? $post->user->fullName ?? $post->user->email }}
                @else
                    User ID: {{ $post->user_id }}
                @endif
                
            </td>
            <td style="text-align: center">{{ $post->likes->count() }}</td>
            <td style="text-align: center">{{ $post->comments->count()}}</td>
            <td style="text-align: center">
                <a href="{{ route('posts.show', $post) }}">Detail</a>
                |
                <a href="{{ route('posts.edit', $post) }}">Ubah</a>
                |
                <form action="{{ route('posts.destroy', $post) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
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
                @foreach ($post->taggedUsers as $user)
                 {{ '@' . $user->name }}
                <br>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif