<!DOCTYPE html>
<html>
<head>
    <title>Postify</title>
</head>
<body>
    <img src="{{ asset('images/Postify.png') }}" width="400">
    <br>
    <h1>Welcome to Postify</h1>
    <a href="/logout">
        <img src="{{ asset('images/logout.png') }}" width="70">
    </a>
    <hr>
    <a href="{{ route('posts.index') }}">
    <img src="{{ asset('images/post.png') }}" width="45">
    </a>
    <hr>
    <a href="/friends">
        <img src="{{ asset('images/friends.png') }}" width="50">
    </a>
    <hr>
    <a href="/comments">
        <img src="{{ asset('images/comment.png') }}" width="45">
    </a>
    <hr>
    <a href="/feeds">
        <img src="{{ asset('images/feeds.png') }}" width="70">
    </a>
    
</body>
</html>