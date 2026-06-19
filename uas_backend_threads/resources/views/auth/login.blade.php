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

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Threads</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="h-full bg-white dark:bg-black flex flex-col items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <div class="flex flex-col items-center mb-10">
            <svg class="w-12 h-12 text-zinc-900 dark:text-white" viewBox="0 0 192 192" fill="currentColor">
                <path d="M141.537 88.988a66.667 66.667 0 0 0-2.518-1.143c-1.482-27.307-16.403-42.94-41.457-43.1h-.34c-14.986 0-27.449 6.396-35.12 18.036l13.779 9.452c5.73-8.695 14.724-10.548 21.348-10.548h.229c8.249.053 14.474 2.452 18.503 7.129 2.932 3.405 4.893 8.111 5.864 14.05-7.314-1.243-15.224-1.626-23.68-1.14-23.82 1.371-39.134 15.264-38.105 34.568.522 9.792 5.4 18.216 13.735 23.719 7.047 4.652 16.124 6.927 25.557 6.412 12.458-.683 22.231-5.436 29.049-14.127 5.178-6.6 8.453-15.153 9.899-25.93 5.937 3.583 10.337 8.298 12.767 13.966 4.132 9.635 4.373 25.468-8.546 38.376-11.319 11.308-24.925 16.2-45.488 16.351-22.809-.169-40.06-7.484-51.275-21.742C35.236 139.966 29.808 120.682 29.605 96c.203-24.682 5.63-43.966 16.133-57.317C56.954 24.425 74.204 17.11 97.013 16.94c22.975.17 40.526 7.52 52.171 21.847 5.71 7.026 10.015 15.86 12.853 26.162l16.147-4.308c-3.44-12.68-8.853-23.606-16.219-32.668C147.036 9.607 125.202.195 97.07 0h-.113C68.882.195 47.292 9.643 32.788 28.054 19.882 44.511 13.223 67.715 13 96.003L13 96l.002.003c.22 28.28 6.88 51.476 19.784 67.925C47.292 182.358 68.882 191.806 96.957 192h.113c24.96-.173 42.554-6.708 57.048-21.19 19.07-19.053 18.491-42.94 12.219-57.602-4.516-10.528-13.131-19.038-24.8-24.22zM97.9 135.442c-10.426.588-21.258-4.098-27.105-11.97-3.949-5.228-5.537-11.52-4.517-17.767C68.005 95.9 79.538 89.79 94.09 88.974c2.276-.13 4.512-.193 6.71-.193 6.177 0 11.928.6 17.122 1.76-1.955 24.305-10.6 44.171-19.022 44.901z"/>
            </svg>
            <h1 class="mt-6 text-2xl font-semibold text-zinc-900 dark:text-white tracking-tight">Masuk ke Threads</h1>
            <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">Gunakan akun kamu untuk melanjutkan</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-100 dark:border-red-900/50 px-4 py-3">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-3">
            @csrf

            <div class="relative">
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email atau nama pengguna"
                    autocomplete="email"
                    class="w-full h-12 bg-zinc-100 dark:bg-zinc-900 border border-transparent focus:border-zinc-300 dark:focus:border-zinc-700 rounded-xl px-4 text-sm text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition-colors"
                />
            </div>

            <div class="relative" x-data="{ show: false }">
                <input
                    type="password"
                    name="password"
                    id="passInput"
                    placeholder="Kata sandi"
                    autocomplete="current-password"
                    class="w-full h-12 bg-zinc-100 dark:bg-zinc-900 border border-transparent focus:border-zinc-300 dark:focus:border-zinc-700 rounded-xl px-4 pr-12 text-sm text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition-colors"
                />
                <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                    <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>

            <button
                type="submit"
                class="w-full h-12 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl text-sm font-semibold tracking-tight hover:bg-zinc-700 dark:hover:bg-zinc-100 active:scale-[0.98] transition-all"
            >
                Masuk
            </button>
        </form>

        <div class="mt-4 flex items-center gap-3">
            <div class="flex-1 h-px bg-zinc-100 dark:bg-zinc-800"></div>
            <span class="text-xs text-zinc-400">atau</span>
            <div class="flex-1 h-px bg-zinc-100 dark:bg-zinc-800"></div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-zinc-900 dark:text-white hover:underline underline-offset-2">Daftar sekarang</a>
            </p>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passInput');
            const open = document.getElementById('eyeOpen');
            const closed = document.getElementById('eyeClosed');
            if (input.type === 'password') {
                input.type = 'text';
                open.classList.add('hidden');
                closed.classList.remove('hidden');
            } else {
                input.type = 'password';
                open.classList.remove('hidden');
                closed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>