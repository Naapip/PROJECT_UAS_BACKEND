<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail - bakwanrimac</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#101010] text-white font-sans">

    <div class="max-w-xl mx-auto p-4">
        <div class="py-4 border-b border-gray-800 mb-6">
            <a href="{{ route('threads.index') }}"
                class="text-gray-400 hover:text-white text-sm flex items-center space-x-1">
                <span>←</span> <span>Back to Threads</span>
            </a>
        </div>

        <div class="p-6 bg-[#181818] rounded-2xl border border-gray-800">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">👤</div>
                <div>
                    <h3 class="font-bold text-white">bakwanrimac</h3>
                    @if ($thread->community_or_topic)
                        <p class="text-xs text-gray-500">{{ $thread->community_or_topic }}</p>
                    @endif
                </div>
            </div>

            <p class="text-lg text-gray-100 leading-relaxed mb-4">{{ $thread->content }}</p>

            @if ($thread->image_path)
                <div class="rounded-xl overflow-hidden border border-gray-800 bg-black mb-4">
                    <img src="{{ asset($thread->image_path) }}" class="w-full h-auto object-contain">
                </div>
            @endif

            <div class="text-xs text-gray-500 pt-2 border-t border-gray-900">
                Posted on {{ $thread->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>

</body>

</html>
