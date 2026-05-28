<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#101010] text-white font-sans">

    <div class="max-w-xl mx-auto p-4">
        <div class="flex justify-between items-center py-4 border-b border-gray-800">
            <h1 class="text-2xl font-bold">Threads</h1>
            <button id="openModalBtn"
                class="bg-white text-black px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition">
                + New Thread
            </button>
        </div>

        <div class="mt-6 space-y-4">
            @foreach ($threads as $thread)
                <div class="p-4 bg-[#181818] rounded-xl border border-gray-800">
                    <div class="flex items-center space-x-2 text-gray-400 text-sm mb-1">
                        <span class="font-bold text-white">{{ $thread->user->name ?? 'User' }}</span>
                        @if ($thread->community_or_topic)
                            <span>•</span>
                            <span class="text-blue-400">{{ $thread->community_or_topic }}</span>
                        @endif
                    </div>
                    <p class="text-gray-200">{{ $thread->content }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div id="threadModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-[#181818] w-full max-w-lg rounded-2xl border border-gray-800 overflow-hidden shadow-2xl mx-4">

            <div class="flex justify-between items-center px-4 py-3 border-b border-gray-800">
                <button id="closeModalBtn" class="text-gray-400 hover:text-white text-sm">Cancel</button>
                <h2 class="font-bold text-base">New thread</h2>
                <div class="flex space-x-3 text-gray-400">
                    <span class="cursor-pointer hover:text-white">📄</span>
                    <span class="cursor-pointer hover:text-white">⋯</span>
                </div>
            </div>

            <form action="{{ route('threads.store') }}" method="POST" class="p-4">
                @csrf
                <div class="flex items-start space-x-3">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-600 flex-shrink-0 flex items-center justify-center text-xs">
                        👤
                    </div>

                    <div class="flex-1">
                        <div class="mb-1">
                            <input type="text" name="community_or_topic" placeholder="Community or topic >"
                                class="bg-transparent text-sm text-gray-500 focus:outline-none w-full placeholder-gray-600">
                        </div>

                        <textarea name="content" rows="3" placeholder="What's new?" required
                            class="bg-transparent text-white placeholder-gray-600 w-full resize-none focus:outline-none text-sm"></textarea>

                    </div>
                </div>

                <div class="flex justify-between items-center mt-6 pt-3 border-t border-gray-800">
                    <span class="text-xs text-gray-500">Post Options</span>
                    <button type="submit"
                        class="bg-white/10 text-white px-5 py-1.5 rounded-full text-sm font-semibold hover:bg-white hover:text-black transition">
                        Post
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const modal = document.getElementById('threadModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
