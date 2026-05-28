<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
    </head>
    <body>
        <h1>
            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif
            <h2>
                <form action="/login" method="POST">
                @csrf
                
                <label>Email Address</label>
                <br><input type="email" name="email" required placeholder="Enter your email"><br>
                <label>Password</label>
                <br><input type="password" name="password" required placeholder="Enter your password"><br>
                <br><button type="submit">Log In</button><br>
                <button type="button" onclick="window.location.href='/register'">Register</button>
                </form>
            </h2>
        </h1>    
    </body>
</html>