<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Threads Clone</title>
</head>

<body>
    <div style="max-width: 400px; margin: 80px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">

        <h2>Login</h2>
        <p>Welcome back to Threads Clone</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Username or Email</label>
                <input type="text" name="login" style="width: 100%; padding: 8px;"
                    placeholder="Enter your username or email" required value="{{ old('login') }}">
                @error('login')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" name="password" style="width: 100%; padding: 8px;" placeholder="Enter password"
                    required>
                @error('password')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>

            <button type="submit" style="width: 100%; padding: 10px; cursor: pointer;">Login</button>
        </form>

        <hr style="margin: 20px 0;">
        <p style="text-align: center; font-size: 14px;">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </p>

    </div>
</body>

</html>
