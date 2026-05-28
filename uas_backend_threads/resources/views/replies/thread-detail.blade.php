<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo Progress - Nested Reply</title>
</head>
<body>

    <h2>POSTINGAN THREAD UTAMA (ID: 1)</h2>
    <p><strong>@oscar:</strong> Halo guys, ini project UAS Threads kelompok kita!</p>
    <hr>

    <h3>Komentar & Balasan (Bagian Progres Naufal):</h3>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('reply.store') }}" method="POST">
        @csrf
        <input type="hidden" name="thread_id" value="1">
        <input type="hidden" name="parent_reply_id" value="">
        <textarea name="content" placeholder="Tulis balasan untuk thread utama di sini..." rows="3" required></textarea><br>
        <button type="submit">Kirim Balasan Utama</button>
    </form>

    <hr>

    <ul>
        @foreach($replies as $reply)
            <li>
                <strong>@user_{{ $reply->user_id }}:</strong> {{ $reply->content }}
                
                <form action="{{ route('reply.store') }}" method="POST" style="margin-top: 5px; margin-bottom: 15px;">
                    @csrf
                    <input type="hidden" name="thread_id" value="1">
                    <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}">
                    <input type="text" name="content" placeholder="Balas komentar ini..." required>
                    <button type="submit">Reply</button>
                </form>

                @if($reply->childReplies->count() > 0)
                    @include('replies.child-replies', ['childReplies' => $reply->childReplies])
                @endif
            </li>
        @endforeach
    </ul>

</body>
</html>