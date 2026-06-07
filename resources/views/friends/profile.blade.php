<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 70%;
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stat-box {
            flex: 1;
            background: #eef2ff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        button {
            padding: 9px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: #2563eb;
            color: white;
        }

        .unfollow {
            background: #dc2626;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
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
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>

        <div class="stats">
            <div class="stat-box">
                <h2>{{ $followersCount }}</h2>
                <p>Followers</p>
            </div>

            <div class="stat-box">
                <h2>{{ $followingCount }}</h2>
                <p>Following</p>
            </div>
        </div>

        <br>

        @if($currentUserId != $user->id)

            @if($isFollowing)
                <form action="{{ route('friends.unfollow', $user->id) }}" method="POST">
                    @csrf

                    <button type="submit" class="unfollow">
                        Unfollow
                    </button>
                </form>
            @else
                <form action="{{ route('friends.follow', $user->id) }}" method="POST">
                    @csrf

                    <button type="submit">
                        Follow
                    </button>
                </form>
            @endif

        @else
            <p>This is your profile.</p>
        @endif
    </div>

    <a href="/friends">
    <button>Back to Friends</button>
    </a>

</div>



</body>
</html>