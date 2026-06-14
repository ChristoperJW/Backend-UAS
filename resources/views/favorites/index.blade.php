<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="250">
</a>

<h1>Post Favorit Saya</h1>

<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>
<br><br>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

@if ($favorites->isEmpty())
    <p>Belum ada post yang disimpan ke favorit.</p>
@else
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th style="width: 250px">Caption</th>
                <th style="width: 150px">Posted By</th>
                <th style="width: 80px">Like</th>
                <th style="width: 100px">Comment</th>
                <th style="width: 200px">Hashtags</th>
                <th style="width: 180px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($favorites as $favorite)
                @if ($favorite->post)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>

                        <td>
                            <a href="{{ route('posts.show', $favorite->post) }}">
                                {{ $favorite->post->caption }}
                            </a>
                        </td>

                        <td>
                            @if ($favorite->post->user)
                                {{ $favorite->post->user->name }}
                            @else
                                User ID: {{ $favorite->post->user_id }}
                            @endif
                        </td>

                        <td style="text-align: center">
                            {{ $favorite->post->likes->count() }}
                        </td>

                        <td style="text-align: center">
                            {{ $favorite->post->comments->count() }}
                        </td>

                        <td>
                            @forelse ($favorite->post->tags as $tag)
                                #{{ $tag->name }}<br>
                            @empty
                                -
                            @endforelse
                        </td>

                        <td style="text-align: center">
                            <a href="{{ route('posts.show', $favorite->post) }}">Detail</a>

                            <form action="{{ route('posts.unfavorite', $favorite->post) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus Favorit</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif