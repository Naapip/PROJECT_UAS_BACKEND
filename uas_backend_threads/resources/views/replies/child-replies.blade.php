<ul style="list-style-type: circle;">
    @foreach($childReplies as $child)
        <li>
            <strong>@user_{{ $child->user_id }}:</strong> {{ $child->content }}
            <br><a href="{{ route('reply.edit', $reply->id) }}" style="font-size: 12px; color: blue;">[Edit Komentar]</a>
            
            <form action="{{ route('reply.store') }}" method="POST" style="margin-top: 5px; margin-bottom: 10px;">
                @csrf
                <input type="hidden" name="thread_id" value="1">
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