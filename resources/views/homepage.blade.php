<!DOCTYPE html>
<html>
<head>
    <title>Postify</title>
</head>
<body>
    <img src="{{ asset('images/Postify.png') }}" width="400">
    <a href="/notifications">
        @if (\App\Models\Notification::where('user_id', session('current_user_id'))->whereNull('read_at')->exists())
            <img src="{{ asset('images/notif after.png') }}" width="50">
        @else
            <img src="{{ asset('images/notif.png') }}" width="50">
        @endif
    </a>
    <br>
    <h1>Welcome to Postify</h1>
    <a href="/logout">
        <img src="{{ asset('images/logout.png') }}" width="70">
    </a>
    <hr>
    <a href="/account">
        <img src="{{ asset('images/settings.png') }}" width="50">
    <hr>
    <a href="{{ route('posts.index') }}">
    <img src="{{ asset('images/post.png') }}" width="50">
    </a>
    <hr>
    <a href="/friends">
        <img src="{{ asset('images/friends.png') }}" width="50">
    </a>
    <hr>
    <a href="/messages">
        <img src="{{ asset('images/messages.png') }}" width="50">
    </a>
    <hr>
    <a href="/comments">
        <img src="{{ asset('images/comment.png') }}" width="50">
    </a>
    <hr>
    <a href="/feeds">
        <img src="{{ asset('images/feeds.png') }}" width="70">
    </a>
    
</body>
</html>