@if(session('success'))
    <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
@endif

<form action="{{ route('reply.store') }}" method="POST">
    @csrf
    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
    <input type="hidden" name="parent_reply_id" value="">
    <textarea name="content" placeholder="Tulis balasan untuk thread utama di sini..." rows="3" required style="width: 100%;"></textarea><br>
    <button type="submit" style="margin-top: 5px;">Kirim Balasan Utama</button>
</form>

<hr>

<ul>
    @foreach($replies as $reply)
    <li>
        <strong>@if($reply->user){{ $reply->user->username }}@else user_anonim @endif:</strong> {{ $reply->content }}
        <br>
        
        @if($reply->content !== '[Komentar ini telah dihapus]')
            <a href="{{ route('reply.edit', $reply->id) }}" style="font-size: 12px; color: blue;">[Edit Komentar]</a>

            @if($reply->user_id === auth()->id())
                <form action="{{ route('reply.destroy', $reply->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="font-size: 11px; color: red; background: none; border: none; padding: 0; cursor: pointer; margin-left: 5px;">[Hapus]</button>
                </form>
            @endif
        @endif

            <form action="{{ route('reply.store') }}" method="POST" style="margin-top: 5px; margin-bottom: 15px;">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
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