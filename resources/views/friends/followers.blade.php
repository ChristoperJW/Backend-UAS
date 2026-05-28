<!DOCTYPE html>
<html>
<head>
    <title>Followers</title>
</head>
<body>

    <h1>Followers</h1>

    <a href="/friends">
        Back to Friends
    </a>

    <hr>

    @forelse($followers as $user)

        <div style="margin-bottom: 15px;">

            <strong>{{ $user->name }}</strong>

            <p>{{ $user->email }}</p>

        </div>

    @empty

        <p>No followers yet.</p>

    @endforelse

</body>
</html>