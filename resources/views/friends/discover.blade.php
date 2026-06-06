<!DOCTYPE html>
<html>
<head>
    <title>Discover Friends</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        button {
            padding: 9px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: #2563eb;
            color: white;
        }

        .empty {
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="card">
        <div class="nav">
            <a href="/">Home</a>
            <a href="/friends">Friends</a>
            <a href="/friends/followers">Followers</a>
            <a href="/friends/following">Following</a>
            <a href="/friends/discover">Discover</a>
        </div>

        <h1>Discover Friends</h1>
        <p>Find new users through people you already follow.</p>
    </div>

    @forelse($discoverUsers as $user)

        <div class="card">
            <h3>{{ $user->name }}</h3>
            <p>{{ $user->email }}</p>
            <p>{{ $user->mutual_count }} mutual connection(s)</p>

            <form action="{{ route('friends.follow', $user->id) }}" method="POST">
                @csrf

                <button type="submit">
                    Follow
                </button>
            </form>
        </div>

    @empty

        <div class="card">
            <p class="empty">No mutual friend recommendations available yet.</p>
        </div>

    @endforelse

</div>

</body>
</html>