<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>User</th>
            <th>Post</th>
            <th>Komentar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $post->user->name ?? '-' }}</td>
            <td>{{ $post->caption }}</td>
            <td>
                @if ($post->comments->count() > 0)
                    <a href="{{ route('comments.show', $post->comments->first()) }}">lihat komen</a>
                @else
                    <a href="{{ route('comments.create', ['post_id' => $post->id]) }}">unggah</a>
                @endif
            </td>
        </tr>
        @endforeach
        <br>
    </tbody>
</table>
<a href="/">Kembali ke Homepage</a>