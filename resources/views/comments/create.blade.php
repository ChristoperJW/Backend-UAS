<h1>Type your comment here :D</h1>
<form method="POST" action="{{ route('comments.store') }}">
    @csrf
    
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <br>
    <input type="text" name="komentar" placeholder="Type Your Comment~" required>
    <br>
    <button type="submit">Send</button>
</form>