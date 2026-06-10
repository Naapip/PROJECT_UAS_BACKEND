<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Bookmarks</title>
</head>

<body>
    <div>
        <div>
            <a href="/threads"><- Back</a>
                    <h1>Saved Bookmarks</h1>
        </div>

        <div>
            @if ($bookmarks->isEmpty())
                <p>Belum ada postingan yang disimpan.</p>
            @else
                @foreach ($bookmarks as $bookmark)
                    <div>
                        <div>
                            <span>bakwanrimac</span>
                            <span>• Saved At {{ $bookmark->created_at->format('d M Y') }}</span>
                        </div>

                        <p>{{ $bookmark->thread->content }}</p>

                        @if ($bookmark->thread->image_path)
                            <div>
                                <img
                                    src="{{ str_starts_with($bookmark->thread->image_path, 'http') ? $bookmark->thread->image_path : asset($bookmark->thread->image_path) }}">
                            </div>
                        @endif
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
</body>

</html>
