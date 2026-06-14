<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="250">
</a>

<h1>Repost Saya</h1>

<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>
<br><br>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

@if ($reposts->isEmpty())
    <p>Kamu belum pernah melakukan repost.</p>
@else
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th style="width: 250px">Caption Repost</th>
                <th style="width: 250px">Post Asli</th>
                <th style="width: 150px">Posted By</th>
                <th style="width: 80px">Like</th>
                <th style="width: 100px">Comment</th>
                <th style="width: 100px">Favorite</th>
                <th style="width: 100px">Repost</th>
                <th style="width: 180px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($reposts as $repost)
                @if ($repost->post)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>

                        <td>
                            @if ($repost->caption)
                                {{ $repost->caption }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('posts.show', $repost->post) }}">
                                {{ $repost->post->caption }}
                            </a>
                        </td>

                        <td>
                            @if ($repost->post->user)
                                {{ $repost->post->user->name }}
                            @else
                                User ID: {{ $repost->post->user_id }}
                            @endif
                        </td>

                        <td style="text-align: center">
                            {{ $repost->post->likes->count() }}
                        </td>

                        <td style="text-align: center">
                            {{ $repost->post->comments->count() }}
                        </td>

                        <td style="text-align: center">
                            {{ $repost->post->favorites->count() }}
                        </td>

                        <td style="text-align: center">
                            {{ $repost->post->reposts->count() }}
                        </td>

                        <td style="text-align: center">
                            <a href="{{ route('posts.show', $repost->post) }}">Detail</a>
                            |
                            <form action="{{ route('reposts.destroy', $repost) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus Repost</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif