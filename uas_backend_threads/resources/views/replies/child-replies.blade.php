<ul style="list-style-type: circle;">
    @foreach($childReplies as $child)
    <li>
        <strong>@if($child->user){{ $child->user->username }}@else user_anonim @endif:</strong> {{ $child->content }}
        <br>
        
        @if($child->content !== '[Komentar ini telah dihapus]')
            <a href="{{ route('reply.edit', $child->id) }}" style="font-size: 12px; color: blue;">[Edit Komentar]</a>

            @if($child->user_id === auth()->id())
                <form action="{{ route('reply.destroy', $child->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="font-size: 11px; color: red; background: none; border: none; padding: 0; cursor: pointer; margin-left: 5px;">[Hapus]</button>
                </form>
            @endif
        @endif

            <form action="{{ route('reply.store') }}" method="POST" style="margin-top: 5px; margin-bottom: 10px;">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $child->thread_id }}">
                <input type="hidden" name="parent_reply_id" value="{{ $child->id }}">
                
                <input type="text" name="content" placeholder="Balas balasan ini..." required>
                <button type="submit">Reply</button>
            </form>

            @if($child->childReplies->count() > 0)
                @include('replies.child-replies', ['childReplies' => $child->childReplies])
            @endif
        </li>
    @endforeach
</ul>