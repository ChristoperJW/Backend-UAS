<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Account Settings</title>
    </head>
    <body>
        <h1>Account Settings</h1>
        <form action="/account/update" method="GET">
            @csrf
            <button type="submit">
                Update Account
            </button>
        </form>
        <hr>
        <form action="/account/delete" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This cannot be undone!');">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 10px; border-radius: 5px; cursor: pointer;">
                Delete My Account
            </button>
        </form>
        <a href="/">Back</a>
    </body>
</html>
