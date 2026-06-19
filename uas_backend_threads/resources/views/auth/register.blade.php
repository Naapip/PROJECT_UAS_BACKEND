<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>

    <h2>Register</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <p>
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </p>

        <p>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </p>

        <p>
            <label>Password</label><br>
            <input type="password" name="password">
        </p>

        <p>
            <label>Konfirmasi Password</label><br>
            <input type="password" name="password_confirmation">
        </p>

        <p>
            <button type="submit">Register</button>
        </p>

    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>

</body>
</html>