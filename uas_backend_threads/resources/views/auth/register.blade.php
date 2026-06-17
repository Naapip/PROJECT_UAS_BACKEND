<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Threads Clone</title>
</head>

<body>
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">

        <h2>Create Account</h2>
        <p>Join Threads Clone today</p>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Full Name</label>
                <input type="text" name="name" style="width: 100%; padding: 8px;"
                    placeholder="Enter your full name" required value="{{ old('name') }}">
                @error('name')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Username</label>
                <input type="text" name="username" style="width: 100%; padding: 8px;" placeholder="Choose a username"
                    required value="{{ old('username') }}">
                @error('username')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Email Address</label>
                <input type="email" name="email" style="width: 100%; padding: 8px;" placeholder="name@example.com"
                    required value="{{ old('email') }}">
                @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" name="password" style="width: 100%; padding: 8px;" placeholder="Create password"
                    required>
                @error('password')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Confirm Password</label>
                <input type="password" name="password_confirmation" style="width: 100%; padding: 8px;"
                    placeholder="Repeat password" required>
            </div>

            <button type="submit" style="width: 100%; padding: 10px; cursor: pointer;">Register</button>
        </form>

        <hr style="margin: 20px 0;">
        <p style="text-align: center; font-size: 14px;">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </p>

    </div>
</body>

</html>
