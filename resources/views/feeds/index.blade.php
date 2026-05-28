<h1>Feeds</h1>
<hr>

@if($posts->isEmpty())
    <p>Sedang tidak ada postingan</p>
@else
    @foreach($posts as $index => $post)
        <p>Post {{ $index + 1 }} : {{ $post->user->name }}</p>
        <p>Caption : {{ $post->caption }}</p>
        <hr>

        @forelse($post->comments as $i => $comment)
            <p>Komen {{ $i + 1 }} : {{ $comment->user->name }} - {{ $comment->content }}</p>
        @empty
            <p>Belum ada komentar</p>
        @endforelse

        <form action="{{ route('feeds.comment', $post) }}" method="POST">
            @csrf
            <input type="text" name="content" placeholder="Tulis komentar..." required>
            <button type="submit">Kirim</button>
        </form>
        <hr>
    @endforeach
@endif