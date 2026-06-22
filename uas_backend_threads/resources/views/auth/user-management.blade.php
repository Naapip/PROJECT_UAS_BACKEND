<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Threads')</title>
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
    <style>
        body { -webkit-tap-highlight-color: transparent; }
        .nav-icon svg { transition: transform 0.15s ease; }
        .nav-item:active .nav-icon svg { transform: scale(0.88); }
        .nav-item.active .nav-icon svg { stroke-width: 2.25; }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-white dark:bg-black">

    <div class="max-w-lg mx-auto h-full flex flex-col">

        <header class="sticky top-0 z-20 bg-white/90 dark:bg-black/90 backdrop-blur-md border-b border-zinc-100 dark:border-zinc-900">
            <div class="flex items-center justify-center px-4 py-3.5 relative">
                <svg class="w-8 h-8 text-zinc-900 dark:text-white" viewBox="0 0 192 192" fill="currentColor">
                    <path d="M141.537 88.988a66.667 66.667 0 0 0-2.518-1.143c-1.482-27.307-16.403-42.94-41.457-43.1h-.34c-14.986 0-27.449 6.396-35.12 18.036l13.779 9.452c5.73-8.695 14.724-10.548 21.348-10.548h.229c8.249.053 14.474 2.452 18.503 7.129 2.932 3.405 4.893 8.111 5.864 14.05-7.314-1.243-15.224-1.626-23.68-1.14-23.82 1.371-39.134 15.264-38.105 34.568.522 9.792 5.4 18.216 13.735 23.719 7.047 4.652 16.124 6.927 25.557 6.412 12.458-.683 22.231-5.436 29.049-14.127 5.178-6.6 8.453-15.153 9.899-25.93 5.937 3.583 10.337 8.298 12.767 13.966 4.132 9.635 4.373 25.468-8.546 38.376-11.319 11.308-24.925 16.2-45.488 16.351-22.809-.169-40.06-7.484-51.275-21.742C35.236 139.966 29.808 120.682 29.605 96c.203-24.682 5.63-43.966 16.133-57.317C56.954 24.425 74.204 17.11 97.013 16.94c22.975.17 40.526 7.52 52.171 21.847 5.71 7.026 10.015 15.86 12.853 26.162l16.147-4.308c-3.44-12.68-8.853-23.606-16.219-32.668C147.036 9.607 125.202.195 97.07 0h-.113C68.882.195 47.292 9.643 32.788 28.054 19.882 44.511 13.223 67.715 13 96.003L13 96l.002.003c.22 28.28 6.88 51.476 19.784 67.925C47.292 182.358 68.882 191.806 96.957 192h.113c24.96-.173 42.554-6.708 57.048-21.19 19.07-19.053 18.491-42.94 12.219-57.602-4.516-10.528-13.131-19.038-24.8-24.22zM97.9 135.442c-10.426.588-21.258-4.098-27.105-11.97-3.949-5.228-5.537-11.52-4.517-17.767C68.005 95.9 79.538 89.79 94.09 88.974c2.276-.13 4.512-.193 6.71-.193 6.177 0 11.928.6 17.122 1.76-1.955 24.305-10.6 44.171-19.022 44.901z"/>
                </svg>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto pb-20">
            @yield('content')
        </main>

        <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-lg z-30 bg-white/90 dark:bg-black/90 backdrop-blur-md border-t border-zinc-100 dark:border-zinc-900">
            <div class="flex items-center justify-around px-2 pt-2 pb-safe">

                <a href="{{ route('threads.index') }}" class="nav-item flex flex-col items-center gap-0.5 px-5 py-2 rounded-2xl {{ request()->routeIs('threads.index') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-7 h-7 text-zinc-900 dark:text-white" style="{{ request()->routeIs('threads.index') ? 'stroke-width:2.25' : 'stroke-width:1.75' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>
                </a>

                <a href="{{ route('search') }}" class="nav-item flex flex-col items-center gap-0.5 px-5 py-2 rounded-2xl {{ request()->routeIs('search') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-7 h-7 text-zinc-900 dark:text-white" style="{{ request()->routeIs('search') ? 'stroke-width:2.25' : 'stroke-width:1.75' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                </a>

                <button onclick="openNewThread()" class="nav-item flex flex-col items-center gap-0.5 px-4 py-2 rounded-2xl">
                    <span class="nav-icon">
                        <svg class="w-7 h-7 text-zinc-900 dark:text-white" style="stroke-width:1.75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </span>
                </button>

                <a href="{{ route('bookmarks.index') }}" class="nav-item flex flex-col items-center gap-0.5 px-5 py-2 rounded-2xl {{ request()->routeIs('bookmarks.index') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-7 h-7 text-zinc-900 dark:text-white" style="{{ request()->routeIs('bookmarks.index') ? 'stroke-width:2.25' : 'stroke-width:1.75' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </span>
                </a>

                <a href="{{ route('updatethreads.edit', auth()->id()) }}" class="nav-item flex flex-col items-center gap-0.5 px-5 py-2 rounded-2xl {{ request()->routeIs('updatethreads.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        @if (auth()->user()->profile_photo ?? false)
                            <img src="{{ auth()->user()->profile_photo }}" class="w-7 h-7 rounded-full object-cover {{ request()->routeIs('updatethreads.*') ? 'ring-2 ring-zinc-900 dark:ring-white ring-offset-1' : '' }}" alt="">
                        @else
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-amber-400 via-orange-400 to-red-500 flex items-center justify-center text-white text-xs font-semibold {{ request()->routeIs('updatethreads.*') ? 'ring-2 ring-zinc-900 dark:ring-white ring-offset-1' : '' }}">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </span>
                </a>

            </div>
        </nav>

        <div id="newThreadModal" class="fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeNewThread()"></div>
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-lg bg-white dark:bg-zinc-900 rounded-t-3xl pb-safe">
                <div class="flex items-center justify-between px-4 py-4 border-b border-zinc-100 dark:border-zinc-800">
                    <button onclick="closeNewThread()" class="text-sm text-zinc-500 dark:text-zinc-400">Batal</button>
                    <span class="text-[15px] font-semibold text-zinc-900 dark:text-white">Thread baru</span>
                    <button form="newThreadForm" type="submit" class="text-sm font-semibold text-zinc-900 dark:text-white">Posting</button>
                </div>
                <div class="flex gap-3 px-4 py-4">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 via-orange-400 to-red-500 flex items-center justify-center text-white text-sm font-semibold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-[14px] font-semibold text-zinc-900 dark:text-white mb-1">{{ auth()->user()->name }}</p>
                        <form id="newThreadForm" action="{{ route('threads.store') }}" method="POST">
                            @csrf
                            <textarea
                                name="content"
                                placeholder="Apa yang ada di pikiranmu?"
                                rows="4"
                                class="w-full text-[15px] bg-transparent outline-none resize-none text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-600 leading-relaxed"
                                style="scrollbar-width:none"
                            ></textarea>
                        </form>
                    </div>
                </div>
                <div class="px-4 pb-6 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                    <p class="text-[13px] text-zinc-400">Semua orang dapat membalas</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="hidden">
            @csrf
        </form>

    </div>

    <script>
        function openNewThread() {
            document.getElementById('newThreadModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeNewThread() {
            document.getElementById('newThreadModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeNewThread();
        });
    </script>

    @stack('scripts')
</body>
</html>