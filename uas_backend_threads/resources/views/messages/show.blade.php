<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan {{ $receiver->name }}</title>
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
                        style="text-decoration: none; color: inherit; display: block; padding: 12px; border: 1px solid {{ $user->id == $receiver->id ? '#007bff' : '#eee' }}; border-radius: 6px; background: {{ $user->id == $receiver->id ? '#e7f3ff' : '#fafafa' }}; font-weight: {{ $user->id == $receiver->id ? 'bold' : 'normal' }};">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="font-size: 20px;">👤</div>
                            <div>
                                <strong style="display: block; font-size: 14px;">{{ $user->name }}</strong>
                                <small
                                    style="color: {{ $user->id == $receiver->id ? '#007bff' : '#777' }}; font-size: 12px;">
                                    {{ $user->id == $receiver->id ? 'Active Chat' : 'Click to chat' }}
                                </small>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div
            style="width: 65%; display: flex; flex-direction: column; border: 1px solid #eee; border-radius: 8px; height: 500px; background: #fff;">

            <div
                style="padding: 15px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; background: #fafafa; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <div style="font-size: 24px;">👤</div>
                <div>
                    <h4 style="margin: 0;">{{ $receiver->name }}</h4>
                    <small style="color: gray;">{{ $receiver->email }}</small>
                </div>
            </div>

            <div id="chatBox"
                style="flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; background: #fdfdfd;">
                @if ($chats->isEmpty())
                    <p style="text-align: center; color: #aaa; font-style: italic; margin-top: 30px;">Belum ada riwayat
                        pesan. Mulai obrolan sekarang!</p>
                @else
                    @foreach ($chats as $chat)
                        @if ($chat->sender_id === Auth::id())
                            <div
                                style="align-self: flex-end; background-color: #007bff; color: white; padding: 10px 14px; border-radius: 14px 14px 0 14px; max-width: 70%; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                <p style="margin: 0; font-size: 14px; line-height: 1.4;">{{ $chat->message }}</p>
                                <small
                                    style="display: block; text-align: right; font-size: 10px; color: #e0e0e0; margin-top: 4px;">{{ $chat->created_at->format('H:i') }}</small>
                            </div>
                        @else
                            <div
                                style="align-self: flex-start; background-color: #f1f0f0; color: #333; padding: 10px 14px; border-radius: 14px 14px 14px 0; max-width: 70%; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <p style="margin: 0; font-size: 14px; line-height: 1.4;">{{ $chat->message }}</p>
                                <small
                                    style="display: block; font-size: 10px; color: #888; margin-top: 4px;">{{ $chat->created_at->format('H:i') }}</small>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

            <div
                style="padding: 15px; border-top: 1px solid #eee; background: #fafafa; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                <form action="{{ route('messages.store', $receiver->id) }}" method="POST"
                    style="display: flex; gap: 10px;">
                    @csrf
                    <input type="text" name="message" placeholder="Type a message..." required autocomplete="off"
                        style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 20px; outline: none; font-size: 14px;">
                    <button type="submit"
                        style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 14px;">
                        Send
                    </button>
                </form>
            </div>

        </div>

    </div>

    <script>
        window.onload = function() {
            const chatBox = document.getElementById('chatBox');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }
    </script>
</body>

</html>
