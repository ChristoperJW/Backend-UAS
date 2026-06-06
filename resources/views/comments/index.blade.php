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
            <td><img src="{{ asset('images/' . $post->media) }}" width="150"></td>
            <td>
                @if ($post->comments->count() > 0)
                    <a href="{{ route('comments.show', $post->comments->first()) }}">
                    <img src="{{ asset('images/comment.png') }}" width="45">
                    </a>
                @else
                    <a href="{{ route('comments.create', ['post_id' => $post->id]) }}">
                    <img src="{{ asset('images/comment.png') }}" width="45">
                    </a>
                @endif
            </td>
        </tr>
        @endforeach
        <br>
    </tbody>
</table>
<a href="/">Back to Homepage</a>