<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

@if (session('success'))
    <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
@endif

<!-- Form Input Post Utama -->
<div
    style="border: 1px solid #ccc; padding: 15px; border-radius: 8px; max-width: 600px; margin-bottom: 20px; background: #fff;">
    <form action="{{ route('reply.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
        <input type="hidden" name="parent_reply_id" value="">

        <textarea id="main-reply-text" name="content" placeholder="What's new?" rows="3" required
            style="width: 100%; border: none; outline: none; resize: none; font-size: 14px;"></textarea>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; gap: 8px; align-items: center;">
                    <label
                        style="cursor: pointer; border: 1px solid #ccc; padding: 4px 8px; border-radius: 4px; font-size: 13px; background: #f9f9f9;">
                        🖼️ Photo / 👾 GIF
                        <input type="file" name="image" accept="image/*" style="display: none;">
                    </label>

                    <button type="button" class="emoji-trigger-btn" data-target="main-reply-text"
                        data-container="emoji-picker-main"
                        style="cursor: pointer; border: 1px solid #ccc; padding: 4px 8px; border-radius: 4px; font-size: 13px; background: #f9f9f9;">
                        😊 Emoji
                    </button>
                </div>
                <button type="submit"
                    style="background: #000; color: #fff; border: none; padding: 6px 15px; border-radius: 4px; font-weight: bold; cursor: pointer;">Post</button>
            </div>

            <div id="emoji-picker-main" style="display: none; margin-top: 5px; max-width: 100%;"></div>
        </div>
    </form>
</div>

<hr>

<!-- List Looping Replies / Komentar -->
<ul>
    @foreach ($replies as $reply)
        <li style="margin-bottom: 25px; list-style: none; border-left: 2px solid #eee; padding-left: 10px;">
            <div>
                <strong>
                    @if ($reply->user)
                        {{ $reply->user->username }}
                    @else
                        user_anonim
                    @endif
                </strong>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">
                    {{ \Carbon\Carbon::parse($reply->created_at)->translatedFormat('H:i - d M Y') }}
                </span>
            </div>

            <p style="margin: 5px 0;">{{ $reply->content }}</p>

            @if ($reply->image)
                <div style="margin: 8px 0;">
                    <img src="{{ asset('storage/' . $reply->image) }}" alt="Media"
                        style="max-width: 255px; max-height: 250px; border-radius: 6px; display: block;">
                </div>
            @endif

            <!-- Tombol Like Komentar Utama -->
            <div style="margin: 5px 0; display: flex; align-items: center; gap: 8px;">
                <button type="button" class="like-btn" data-id="{{ $reply->id }}"
                    style="background: none; border: none; cursor: pointer; font-size: 14px; padding: 0; display: flex; align-items: center; gap: 4px;">
                    <span class="heart-icon">{{ $reply->isLikedByAuthUser() ? '❤️' : '🤍' }}</span>
                    <span class="like-count"
                        style="font-size: 13px; color: #555;">{{ $reply->likes()->count() }}</span>
                </button>
            </div>

            <div style="margin-top: 5px;">
                <form action="{{ route('like.toggle') }}" method="POST"
                    style="display:inline-block; margin-right: 10px;">
                    @csrf
                    <input type="hidden" name="likeable_id" value="{{ $reply->id }}">
                    <input type="hidden" name="likeable_type" value="App\Models\Reply">

                    <button type="submit"
                        style="background: none; border: none; cursor: pointer; font-size: 1.1em; padding: 0;">
                        @if ($reply->isLikedByAuthUser())
                            ❤️ <span
                                style="color: red; font-weight: bold; font-size: 12px;">{{ $reply->likes()->count() }}</span>
                        @else
                            🤍 <span style="color: gray; font-size: 12px;">{{ $reply->likes()->count() }}</span>
                        @endif
                    </button>
                </form>
                @if ($reply->content !== '[Komentar ini telah dihapus]' && $reply->user_id === auth()->id())
                    <a href="{{ route('reply.edit', $reply->id) }}"
                        style="font-size: 12px; color: blue; text-decoration: none; margin-right: 10px;">[Edit]</a>
                    <form action="{{ route('reply.destroy', $reply->id) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="font-size: 12px; color: red; background: none; border: none; padding: 0; cursor: pointer;">[Hapus]</button>
                    </form>
                @endif
            </div>

            <details style="margin-top: 8px;">
                <summary style="font-size: 12px; color: #555; cursor: pointer; max-width: max-content;">💬 Reply
                </summary>
                <div
                    style="border: 1px solid #ddd; padding: 10px; border-radius: 6px; max-width: 500px; margin-top: 5px; background: #fafafa;">
                    <form action="{{ route('reply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                        <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}">

                        <textarea id="reply-text-{{ $reply->id }}" name="content" placeholder="Reply to this comment..." rows="2"
                            required style="width: 100%; border: none; outline: none; resize: none; font-size: 13px; background: transparent;"></textarea>
                        <hr style="border: 0; border-top: 1px solid #ddd; margin: 8px 0;">

                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 5px;">
                                    <label
                                        style="cursor: pointer; border: 1px solid #ccc; padding: 2px 6px; border-radius: 4px; font-size: 11px; background: #fff;">
                                        🖼️ Photo/GIF
                                        <input type="file" name="image" accept="image/*" style="display: none;">
                                    </label>
                                    <button type="button" class="emoji-trigger-btn"
                                        data-target="reply-text-{{ $reply->id }}"
                                        data-container="emoji-picker-{{ $reply->id }}"
                                        style="cursor: pointer; border: 1px solid #ccc; padding: 2px 6px; border-radius: 4px; font-size: 11px; background: #fff;">
                                        😊 Emote
                                    </button>
                                </div>
                                <button type="submit"
                                    style="background: #333; color: #fff; border: none; padding: 4px 10px; border-radius: 4px; font-size: 12px; cursor: pointer;">Reply</button>
                            </div>
                            <div id="emoji-picker-{{ $reply->id }}"
                                style="display: none; margin-top: 5px; max-width: 100%;"></div>
                        </div>
                    </form>
                </div>
            </details>

            @if ($reply->childReplies->count() > 0)
                @include('replies.child-replies', ['childReplies' => $reply->childReplies])
            @endif
        </li>
    @endforeach
</ul>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Emoji Mart
        const triggerButtons = document.querySelectorAll('.emoji-trigger-btn');
        triggerButtons.forEach(button => {
            const textareaId = button.getAttribute('data-target');
            const containerId = button.getAttribute('data-container');
            const textarea = document.getElementById(textareaId);
            const container = document.getElementById(containerId);

            if (textarea && container) {
                const pickerOptions = {
                    theme: 'dark',
                    set: 'native',
                    onEmojiSelect: function(emoji) {
                        textarea.value += emoji.native;
                        textarea.focus();
                    }
                };
                const picker = new EmojiMart.Picker(pickerOptions);
                container.appendChild(picker);

                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    container.style.display = container.style.display === 'none' ? 'block' :
                        'none';
                });
            }
        });

        // 2. AJAX Like Komentar (Event Delegation + Error Catching)
        document.addEventListener('click', function(e) {
            const button = e.target.closest('.like-btn');
            if (!button) return;

            e.preventDefault();
            const replyId = button.getAttribute('data-id');
            const heartIcon = button.querySelector('.heart-icon');
            const likeCountSpan = button.querySelector('.like-count');

            fetch(`/replies/${replyId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Jika rute salah (404) atau server error (500), akan langsung ketahuan di sini
                    if (!response.ok) {
                        console.error('Status Kode Eror:', response.status);
                        return response.text().then(text => {
                            throw new Error(text)
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        heartIcon.textContent = data.liked ? '❤️' : '🤍';
                        likeCountSpan.textContent = data.likes_count;
                    }
                })
                .catch(error => {
                    console.error('Detail Eror Fetch:', error);
                    alert('Gagal menyukai komentar, cek inspect console kamu!');
                });
        });
    });
</script>
