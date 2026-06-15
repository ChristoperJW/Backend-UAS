<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>My Posts</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<a href="{{ route('posts.create') }}">Buat Post Baru</a>
<br>
<a href="{{ route('posts.index') }}">Lihat Semua Post</a>
<br>
<a href="/">Kembali ke Homepage</a>

<br><br>

@if ($posts->count() > 0)
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th style="width: 250px">Caption</th>
                <th style="width: 220px">Media</th>
                <th style="width: 100px">Like</th>
                <th style="width: 120px">Komentar</th>
                <th style="width: 180px">Hashtags</th>
                <th style="width: 180px">Tagged Users</th>
                <th style="width: 220px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>

                    <td>{{ $post->caption }}</td>

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

                    <td style="text-align: center">{{ $post->likes->count() }}</td>

                    <td style="text-align: center">{{ $post->comments->count() }}</td>

                    <td>
                        @forelse ($post->tags as $tag)
                            #{{ $tag->name }}
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

                    <td style="text-align: center">
                        <a href="{{ route('posts.show', $post) }}">Detail</a>
                        |
                        <a href="{{ route('posts.edit', $post) }}">Ubah</a>
                        |
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Kamu belum membuat postingan.</p>
@endif