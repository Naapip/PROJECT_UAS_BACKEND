<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail - {{ $thread->user->name }}</title>
</head>

<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        <div style="margin-bottom: 20px;">
            <a href="{{ route('threads.index') }}">
                <span>←</span> <span>Back to Threads</span>
            </a>
        </div>

        <div style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                <div style="font-size: 24px;">👤</div>
                <div>
                    <h3 style="margin: 0;">{{ $thread->user->name }}</h3>
                    <small style="color: #555;"></small>

                    @if ($thread->community_or_topic)
                        <p style="margin: 5px 0 0 0; font-size: 14px; color: blue;">#{{ $thread->community_or_topic }}
                        </p>
                    @endif
                </div>
            </div>

            <p style="font-size: 18px; line-height: 1.5;">{{ $thread->content }}</p>

            @if ($thread->image_path)
                <div style="margin-top: 15px; text-align: center;">
                    <img style="max-width: 100%; border-radius: 8px;"
                        src="{{ str_starts_with($thread->image_path, 'http') ? $thread->image_path : asset($thread->image_path) }}">
                </div>
            @endif

            <div style="margin-top: 15px; color: #777; font-size: 12px;">
                Posted on {{ $thread->created_at->format('d M Y, H:i') }}
            </div>

            <div style="margin-top: 10px;">
                <form action="{{ route('like.toggle') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="likeable_id" value="{{ $thread->id }}">
                    <input type="hidden" name="likeable_type" value="App\Models\Thread">
                    
                    <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 1.2em; padding: 0;">
                        @if($thread->isLikedByAuth())
                            ❤️ <span style="color: red; font-weight: bold;">{{ $thread->likes()->count() }}</span>
                        @else
                            🤍 <span style="color: gray;">{{ $thread->likes()->count() }}</span>
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <h3>Komentar & Balasan</h3>
            @include('replies.thread-detail', ['replies' => $thread->replies->where('parent_reply_id', null)])
        </div>

    </div>
</body>

</html>