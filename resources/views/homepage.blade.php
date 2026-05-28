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
        <button>
            Logout
        </button>
    </a>
    <a href="{{ route('posts.index') }}">
    <button>Posts</button>
    </a>
    <hr>
    <a href="/friends">
        <button>
            Friends
        </button>
    </a>
    <hr>
    <a href="/comments">
        <button>
            Comment's here!
        </button>
    </a>
    
</body>
</html>