<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register</title>
    </head>
    <body>
        <h1>
            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif
            <h2>
                <form action="/register" method="POST">
                @csrf
                
                <label>Name</label>
                <br><input type="text" name="name" required placeholder="Enter your name"><br>
                <label>Email Address</label>
                <br><input type="email" name="email" required placeholder="Enter your email"><br>
                <label>Password</label>
                <br><input type="password" name="password" required placeholder="Enter your password"><br>
                <br><button type="submit">Register</button><br>
                <button type="button" onclick="window.location.href='/login'">Back to Login</button>
                </form>
            </h2>
        </h1>
    </body>
</html>