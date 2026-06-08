<!DOCTYPE html>
<html>
<head>
    <title>Follow Requests</title>

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
            color: white;
        }

        .accept {
            background: #16a34a;
        }

        .reject {
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

    <div class="card">
        <div class="nav">
            <a href="/">Home</a>
            <a href="/friends">Friends</a>
            <a href="/friends/followers">Followers</a>
            <a href="/friends/following">Following</a>
            <a href="/friends/discover">Discover</a>
            <a href="/friends/requests">Requests</a>
        </div>

        <h1>Follow Requests</h1>
        <p>Manage users who requested to follow you.</p>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @forelse($followRequests as $request)

        <div class="card">
            <h3>{{ $request->sender->name }}</h3>
            <p>{{ $request->sender->email }}</p>

            <form action="{{ route('friends.requests.accept', $request->id) }}"
                  method="POST"
                  style="display:inline;">
                @csrf

                <button type="submit" class="accept">
                    Accept
                </button>
            </form>

            <form action="{{ route('friends.requests.reject', $request->id) }}"
                  method="POST"
                  style="display:inline;">
                @csrf

                <button type="submit" class="reject">
                    Reject
                </button>
            </form>
        </div>

    @empty

        <div class="card">
            <p class="empty">No pending follow requests.</p>
        </div>

    @endforelse

</div>

</body>
</html>