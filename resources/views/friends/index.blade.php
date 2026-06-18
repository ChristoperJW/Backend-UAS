<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>

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

        .header, .card {
            background: white;
            padding: 20px;
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
        }

        .stat-box {
            flex: 1;
            background: #eef2ff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            color: #111;
        }

        .user-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: #fafafa;
        }

        input {
            padding: 10px;
            width: 70%;
            border: 1px solid #ccc;
            border-radius: 6px;
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

        .empty {
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <div class="nav">
            <a href="/">Home</a>
            <a href="/friends">Friends</a>
            <a href="/friends/followers">Followers</a>
            <a href="/friends/following">Following</a>
            <a href="/friends/discover">Discover</a>
            <a href="/friends/requests">Requests</a>
            <a href="/friends/close-friends">Close Friends</a>
        </div>

        <h1>Friends</h1>

        <p>
            Logged in as:
            <strong>{{ $currentUser->name }}</strong>
        </p>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <h3>Social Statistics</h3>

        <div class="stats">
            <a href="/friends/followers" class="stat-box">
                <h2>{{ $followersCount }}</h2>
                <p>Followers</p>
            </a>

            <a href="/friends/following" class="stat-box">
                <h2>{{ $followingCount }}</h2>
                <p>Following</p>
            </a>
        </div>
    </div>

    <div class="card">
        <h3>Search Users</h3>

        <form action="/friends" method="GET">
            <input
                type="text"
                name="search"
                placeholder="Search user by name or email"
                value="{{ request('search') }}"
            >

            <button type="submit">
                Search
            </button>
        </form>

        @if(request('search'))
            <hr>

            <h4>Search Results</h4>

            @forelse($searchResults as $user)
                <div class="user-card">
                    <strong>{{ $user->name }}</strong>
                    <p>{{ $user->email }}</p>

                    <a href="{{ route('users.profile', $user->id) }}">
                        View Profile
                    </a>

                    <br><br>

                    @if($followedUsers->contains($user->id))
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
                </div>
            @empty
                <p class="empty">No users found.</p>
            @endforelse
        @endif
    </div>

    <div class="card">
        <h3>Suggested Friends</h3>

        @forelse($suggestions as $user)
            <div class="user-card">
                <strong>{{ $user->name }}</strong>
                <br><br>

                <a href="{{ route('users.profile', $user->id) }}">
                    View profile
                </a>

                <form action="{{ route('friends.follow', $user->id) }}" method="POST" style="margin-top: 10px;">
                    @csrf

                    <button type="submit">
                        Follow
                    </button>
                </form>
            </div>
        @empty
            <p class="empty">No suggestions available.</p>
        @endforelse
    </div>

</div>

</body>
</html>