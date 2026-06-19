<ul style="list-style-type: none; padding-left: 20px;">
    @foreach($childReplies as $child)
        <li style="margin-bottom: 15px; border-left: 2px dashed #ddd; padding-left: 10px;">
            <div>
                <strong>@if($child->user){{ $child->user->username }}@else user_anonim @endif</strong> 
                <span style="font-size: 11px; color: #888; margin-left: 8px;">
                    {{ \Carbon\Carbon::parse($child->created_at)->translatedFormat('H:i - d M Y') }}
                </span>
            </div>
            
            <p style="margin: 4px 0; font-size: 13px;">{{ $child->content }}</p>

            @if($child->image)
                <div style="margin: 5px 0;">
                    <img src="{{ asset('storage/' . $child->image) }}" alt="Media Balasan" style="max-width: 200px; max-height: 200px; border-radius: 6px; display: block;">
                </div>
            @endif

            <div>
                @if($child->content !== '[Komentar ini telah dihapus]' && $child->user_id === auth()->id())
                    <a href="{{ route('reply.edit', $child->id) }}" style="font-size: 11px; color: blue; text-decoration: none; margin-right: 8px;">[Edit]</a>
                    <form action="{{ route('reply.destroy', $child->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="font-size: 11px; color: red; background: none; border: none; padding: 0; cursor: pointer;">[Hapus]</button>
                    </form>
                @endif
            </div>
            
            <details style="margin-top: 5px;">
                <summary style="font-size: 11px; color: #777; cursor: pointer; max-width: max-content;">💬 Reply</summary>
                <div style="border: 1px solid #ddd; padding: 8px; border-radius: 6px; max-width: 450px; margin-top: 3px; background: #fafafa;">
                    <form action="{{ route('reply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $child->thread_id }}">
                        <input type="hidden" name="parent_reply_id" value="{{ $child->id }}">
                        
                        <textarea id="reply-text-{{ $child->id }}" name="content" placeholder="Reply to this thread..." rows="2" required style="width: 100%; border: none; outline: none; resize: none; font-size: 12px; background: transparent PapayaWhip;"></textarea>
                        <hr style="border: 0; border-top: 1px solid #ddd; margin: 6px 0;">
                        
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 4px;">
                                    <label style="cursor: pointer; border: 1px solid #ccc; padding: 1px 5px; border-radius: 4px; font-size: 10px; background: #fff;">
                                        🖼️ Photo/GIF
                                        <input type="file" name="image" accept="image/*" style="display: none;">
                                    </label>
                                    
                                    <button type="button" class="emoji-trigger-btn" data-target="reply-text-{{ $child->id }}" data-container="emoji-picker-{{ $child->id }}" style="cursor: pointer; border: 1px solid #ccc; padding: 1px 5px; border-radius: 4px; font-size: 10px; background: #fff;">
                                        😊 Emote
                                    </button>
                                </div>
                                <button type="submit" style="background: #333; color: #fff; border: none; padding: 3px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Reply</button>
                            </div>
                            
                            <div id="emoji-picker-{{ $child->id }}" style="display: none; margin-top: 5px; max-width: 100%;"></div>
                        </div>
                    </form>
                </div>
            </details>

            @if($child->childReplies->count() > 0)
                @include('replies.child-replies', ['childReplies' => $child->childReplies])
            @endif
        </li>
    @endforeach
</ul>