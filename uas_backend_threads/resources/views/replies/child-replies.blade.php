<ul style="list-style-type: none; padding-left: 20px;">
    @foreach($childReplies as $child)
        <li style="margin-bottom: 15px; border-left: 2px dashed #ddd; padding-left: 10px; position: relative;">
            
            <!-- Dropdown Titik Tiga Hanya Muncul JIKA Konten Belum Dihapus -->
            @if($child->content !== '[Komentar ini telah dihapus]')
                <div style="position: absolute; right: 10px; top: 0; display: inline-block;">
                    <details style="cursor: pointer;">
                        <!-- Memakai &vellip; agar menjadi simbol titik tiga vertikal asli -->
                        <summary style="list-style: none; font-size: 16px; color: #666; font-weight: bold; padding: 0 5px;">&vellip;</summary>
                        <div style="position: absolute; right: 0; background: #fff; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); width: 110px; z-index: 10; padding: 5px 0;">
                            
                            <!-- Opsi Edit & Hapus Child (Hanya Muncul jika Milik Akun Sendiri) -->
                            @if($child->user_id === auth()->id())
                                <a href="{{ route('reply.edit', $child->id) }}" style="display: block; padding: 6px 10px; font-size: 11px; color: #333; text-decoration: none; background: #fff;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">✏️ Edit</a>
                                
                                <form action="{{ route('reply.destroy', $child->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="display: block; width: 100%; text-align: left; background: #fff; border: none; padding: 6px 10px; font-size: 11px; color: red; cursor: pointer;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">🗑️ Hapus</button>
                                </form>
                            @endif

                            <!-- Opsi Report Child (Hanya Muncul jika Milik Akun Orang Lain) -->
                            @if($child->user_id !== auth()->id())
                                <button type="button" class="report-trigger-btn" data-id="{{ $child->id }}" style="display: block; width: 100%; text-align: left; background: #fff; border: none; padding: 6px 10px; font-size: 11px; color: orange; cursor: pointer;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">🚨 Laporkan</button>
                            @endif
                        </div>
                    </details>
                </div>
            @endif

            <div>
                <strong>@if($child->user){{ $child->user->username }}@else user_anonim @endif</strong> 
                <span style="font-size: 11px; color: #888; margin-left: 8px;">
                    {{ \Carbon\Carbon::parse($child->created_at)->translatedFormat('H:i - d M Y') }}
                </span>
            </div>
            
            <p style="margin: 4px 0; font-size: 13px; padding-right: 25px;">{{ $child->content }}</p>

            @if($child->image)
                <div style="margin: 5px 0;">
                    <img src="{{ asset('storage/' . $child->image) }}" alt="Media Balasan" style="max-width: 200px; max-height: 200px; border-radius: 6px; display: block;">
                </div>
            @endif

            <!-- Tombol Like Komentar Anak -->
            <div style="margin: 5px 0; display: flex; align-items: center; gap: 8px;">
                <button type="button" class="like-btn" data-id="{{ $child->id }}" style="background: none; border: none; cursor: pointer; font-size: 13px; padding: 0; display: flex; align-items: center; gap: 4px;">
                    <span class="heart-icon">{{ $child->isLikedByAuthUser() ? '❤️' : '🤍' }}</span>
                    <span class="like-count" style="font-size: 12px; color: #555;">{{ $child->likes()->count() }}</span>
                </button>
            </div>
            
            <details style="margin-top: 5px;">
                <summary style="font-size: 11px; color: #777; cursor: pointer; max-width: max-content;">💬 Reply</summary>
                <div style="border: 1px solid #ddd; padding: 8px; border-radius: 6px; max-width: 450px; margin-top: 3px; background: #fafafa;">
                    <form action="{{ route('reply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $child->thread_id }}">
                        <input type="hidden" name="parent_reply_id" value="{{ $child->id }}">
                        
                        <textarea id="reply-text-{{ $child->id }}" name="content" placeholder="Reply to this thread..." rows="2" required style="width: 100%; border: none; outline: none; resize: none; font-size: 12px; background: transparent;"></textarea>
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