<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update Account</title>
    </head>
    <body>
        <h1>
            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif
            <h2>
                <form action="/account/update" method="POST">
                @csrf
                
                <label>Name</label>
                <br><input type="text" name="name" required placeholder="Enter your name"><br>
                <label>Email Address</label>
                <br><input type="email" name="email" required placeholder="Enter your email"><br>
                <label>Current Password</label>
                <br><input type="password" name="old_password" required placeholder="Enter your current password"><br>
                <label>New Password</label>
                <br><input type="password" name="new_password" required placeholder="Enter your new password"><br>
                <br><button type="submit">Update Account</button><br>
                <button type="button" onclick="window.location.href='/login'">Back to Login</button>
                </form>
            </h2>
        </h1>
    </body>
</html>