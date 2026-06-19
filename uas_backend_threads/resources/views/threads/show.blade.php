<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail - bakwanrimac</title>
</head>

<body>

    <div>
        <div>
            <a href="{{ route('threads.index') }}">
                <span>←</span> <span>Back to Threads</span>
            </a>
        </div>

        <div>
            <div>
                <div>👤</div>
                <div>
                    <h3>bakwanrimac</h3>
                    @if ($thread->community_or_topic)
                        <p>{{ $thread->community_or_topic }}</p>
                    @endif
                </div>
            </div>

            <p>{{ $thread->content }}</p>

            @if ($thread->image_path)
                <div>
                    <img
                        src="{{ str_starts_with($thread->image_path, 'http') ? $thread->image_path : asset($thread->image_path) }}">
                </div>
            @endif

            <div>
                Posted on {{ $thread->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>

</body>

</html>
