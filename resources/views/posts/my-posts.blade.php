<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="300">
</a>

<h1>My Posts</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<a href="{{ route('posts.create') }}">Buat Post Baru</a>
<br><br>
<a href="{{ route('posts.index') }}">Lihat Semua Post</a>
<br><br>
<a href="/">Kembali ke Homepage</a>

<br><br>

@if ($posts->count() > 0)
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Caption</th>
            <th>Media</th>
            <th>Jumlah Like</th>
            <th>Hashtags</th>
            <th>Tagged Users</th>
            <th>Aksi</th>
        </tr>

        @foreach ($posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $post->caption }}</td>

                <td>{{ $post->media }}</td>

                <td>{{ $post->likes->count() }}</td>

                <td>
                    @forelse ($post->tags as $tag)
                        #{{ $tag->name }}<br>
                    @empty
                        Tidak ada hashtag
                    @endforelse
                </td>

                <td>
                    @forelse ($post->taggedUsers as $user)
                        {{ '@' . $user->name }}<br>
                    @empty
                        Tidak ada user yang ditandai
                    @endforelse
                </td>

                <td>
                    <a href="{{ route('posts.show', $post) }}">Detail</a>
                    <br>
                    <a href="{{ route('posts.edit', $post) }}">Ubah</a>
                    <br>

                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>Kamu belum membuat postingan.</p>
@endif