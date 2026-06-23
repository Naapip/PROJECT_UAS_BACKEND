<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Threads Clone</title>
</head>

<body>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px; display: flex; gap: 20px; font-family: sans-serif;">

        <div style="width: 35%; border-right: 1px solid #eee; padding-right: 20px;">
            <div style="margin-bottom: 20px;">
                <a href="{{ route('threads.index') }}" style="text-decoration: none; color: #555; font-size: 14px;">← Back
                    to Feed</a>
                <h2 style="margin: 10px 0 0 0;">Direct Messages</h2>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach ($users as $user)
                    <a href="{{ route('messages.show', $user->id) }}"
                        style="text-decoration: none; color: inherit; display: block; padding: 12px; border: 1px solid #eee; border-radius: 6px; background: #fafafa; transition: 0.2s;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="font-size: 20px;">👤</div>
                            <div>
                                <strong style="display: block; font-size: 14px;">{{ $user->name }}</strong>
                                <small style="color: #777; font-size: 12px;">Click to chat</small>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div
            style="width: 65%; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #fafafa; border-radius: 8px; min-height: 400px; color: #999;">
            <div style="font-size: 48px; margin-bottom: 10px;">💬</div>
            <h3>Your Messages</h3>
            <p style="margin: 0; font-size: 14px;">Select a user from the left panel to start chatting.</p>
        </div>

    </div>
</body>

</html>
