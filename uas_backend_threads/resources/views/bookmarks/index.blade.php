<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Bookmarks</title>
</head>

<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        <div style="margin-bottom: 20px;">
            <a href="{{ route('threads.index') }}"><- Back to Threads</a>
                    <h1>Saved Bookmarks</h1>
        </div>

        <div>
            @if ($bookmarks->isEmpty())
                <p style="text-align: center; color: #777; margin-top: 40px;">Belum ada postingan yang disimpan.</p>
            @else
                @foreach ($bookmarks as $bookmark)
                    <div style="padding: 15px 0;">
                        <div style="margin-bottom: 10px;">
                            <strong>{{ $bookmark->thread->user->name }}</strong>
                            <span style="color: #555; font-size: 14px;"></span>
                            <span style="color: #777; font-size: 12px;"> • Saved At
                                {{ $bookmark->created_at->format('d M Y') }}</span>
                        </div>

                        <p style="line-height: 1.4;">{{ $bookmark->thread->content }}</p>

                        @if ($bookmark->thread->image_path)
                            <div style="margin-top: 10px; text-align: center;">
                                <img style="max-width: 100%; border-radius: 6px;"
                                    src="{{ str_starts_with($bookmark->thread->image_path, 'http') ? $bookmark->thread->image_path : asset($bookmark->thread->image_path) }}">
                            </div>
                        @endif
                    </div>
                    <hr style="border: 0; border-top: 1px solid #eee;">
                @endforeach
            @endif
        </div>

    </div>
</body>

</html>
