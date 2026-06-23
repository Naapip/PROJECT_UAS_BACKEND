<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

@if (session('success'))
    <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
@endif

<!-- Form Input Post Utama -->
<div style="border: 1px solid #ccc; padding: 15px; border-radius: 8px; max-width: 600px; margin-bottom: 20px; background: #fff;">
    <form action="{{ route('reply.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
        <input type="hidden" name="parent_reply_id" value="">

        <textarea id="main-reply-text" name="content" placeholder="What's new?" rows="3" required
            style="width: 100%; border: none; outline: none; resize: none; font-size: 14px;"></textarea>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; gap: 8px; align-items: center;">
                    <label style="cursor: pointer; border: 1px solid #ccc; padding: 4px 8px; border-radius: 4px; font-size: 13px; background: #f9f9f9;">
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
        <li style="margin-bottom: 25px; list-style: none; border-left: 2px solid #eee; padding-left: 10px; position: relative;">
            
            @if ($reply->content !== '[Komentar ini telah dihapus]')
                <div style="position: absolute; right: 10px; top: 0; display: inline-block;">
                    <details style="cursor: pointer;">
                        <summary style="list-style: none; font-size: 18px; color: #666; font-weight: bold; padding: 0 5px;">&vellip;</summary>
                        <div style="position: absolute; right: 0; background: #fff; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); width: 120px; z-index: 10; padding: 5px 0;">
                            
                            @if ($reply->user_id === auth()->id())
                                <a href="{{ route('reply.edit', $reply->id) }}" style="display: block; padding: 8px 12px; font-size: 12px; color: #333; text-decoration: none; background: #fff;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">✏️ Edit</a>
                                
                                <form action="{{ route('reply.destroy', $reply->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="display: block; width: 100%; text-align: left; background: #fff; border: none; padding: 8px 12px; font-size: 12px; color: red; cursor: pointer;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">🗑️ Hapus</button>
                                </form>
                            @endif

                            @if ($reply->user_id !== auth()->id())
                                <!-- Pemicu Modal Alasan Report -->
                                <button type="button" class="report-trigger-btn" data-id="{{ $reply->id }}" style="display: block; width: 100%; text-align: left; background: #fff; border: none; padding: 8px 12px; font-size: 12px; color: orange; cursor: pointer;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">🚨 Laporkan</button>
                            @endif
                        </div>
                    </details>
                </div>
            @endif

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

            <p style="margin: 5px 0; padding-right: 30px;">{{ $reply->content }}</p>

            <!-- Tombol Like Komentar Utama -->
            <div style="margin: 5px 0; display: flex; align-items: center; gap: 8px;">
                <button type="button" class="like-btn" data-id="{{ $reply->id }}"
                    style="background: none; border: none; cursor: pointer; font-size: 14px; padding: 0; display: flex; align-items: center; gap: 4px;">
                    <span class="heart-icon">{{ $reply->isLikedByAuthUser() ? '❤️' : '🤍' }}</span>
                    <span class="like-count" style="font-size: 13px; color: #555;">{{ $reply->likes()->count() }}</span>
                </button>
            </div>

            <details style="margin-top: 8px;">
                <summary style="font-size: 12px; color: #555; cursor: pointer; max-width: max-content;">💬 Reply</summary>
                <div style="border: 1px solid #ddd; padding: 10px; border-radius: 6px; max-width: 500px; margin-top: 5px; background: #fafafa;">
                    <form action="{{ route('reply.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                        <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}">
                        <textarea id="reply-text-{{ $reply->id }}" name="content" placeholder="Reply to this comment..." rows="2" required style="width: 100%; border: none; outline: none; resize: none; font-size: 13px; background: transparent;"></textarea>
                        <button type="submit" style="background: #333; color: #fff; border: none; padding: 4px 10px; border-radius: 4px; font-size: 12px; cursor: pointer; margin-top: 5px;">Reply</button>
                    </form>
                </div>
            </details>

            @if ($reply->childReplies->count() > 0)
                @include('replies.child-replies', ['childReplies' => $reply->childReplies])
            @endif
        </li>
    @endforeach
</ul>

<!-- ==================== POP-UP MODAL REPORT (DI TARUH DI LUAR LOOP) ==================== -->
<div id="reportModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 20px; border-radius: 8px; width: 100%; max-width: 380px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0; font-size: 16px;">🚨 Laporkan Konten</h3>
        <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Pilih alasan mengapa Anda melaporkan komentar ini:</p>
        
        <form id="reportForm" method="POST" action="">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 10px; font-size: 14px; margin-bottom: 20px;">
                <label style="cursor: pointer;"><input type="radio" name="reason" value="Spam / Iklan tidak jelas" checked style="margin-right: 8px;"> Spam / Iklan tidak layak</label>
                <label style="cursor: pointer;"><input type="radio" name="reason" value="Ujaran Kebencian / SARA" style="margin-right: 8px;"> Ujaran Kebencian / SARA</label>
                <label style="cursor: pointer;"><input type="radio" name="reason" value="Pelecehan / Perundungan" style="margin-right: 8px;"> Pelecehan / Perundungan</label>
                <label style="cursor: pointer;"><input type="radio" name="reason" value="Informasi Palsu / Hoax" style="margin-right: 8px;"> Informasi Palsu / Hoax</label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="closeModalBtn" style="background: #eee; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Batal</button>
                <button type="submit" style="background: red; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: bold;">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Logic
        const modal = document.getElementById('reportModal');
        const reportForm = document.getElementById('reportForm');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Menangkap klik tombol "Laporkan" di komentar utama maupun child
        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('.report-trigger-btn');
            if (!trigger) return;

            e.preventDefault();
            const replyId = trigger.getAttribute('data-id');
            
            // Atur Action Form secara dinamis sesuai id komentar yang diklik
            reportForm.action = `/replies/${replyId}/report`;
            
            // Tampilkan Modal
            modal.style.display = 'flex';
        });

        // Tutup Modal
        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Tutup saat klik background hitam luar modal
        window.addEventListener('click', function(e) {
            if (e.target === modal) modal.style.display = 'none';
        });

        // --- Logika Emoji & Like Tetap Sama Dibawah Ini ---
        const triggerButtons = document.querySelectorAll('.emoji-trigger-btn');
        triggerButtons.forEach(button => {
            const textareaId = button.getAttribute('data-target');
            const containerId = button.getAttribute('data-container');
            const textarea = document.getElementById(textareaId);
            const container = document.getElementById(containerId);

            if (textarea && container) {
                const pickerOptions = {
                    theme: 'dark', set: 'native',
                    onEmojiSelect: function(emoji) { textarea.value += emoji.native; textarea.focus(); }
                };
                const picker = new EmojiMart.Picker(pickerOptions);
                container.appendChild(picker);
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    container.style.display = container.style.display === 'none' ? 'block' : 'none';
                });
            }
        });

        document.addEventListener('click', function(e) {
            const button = e.target.closest('.like-btn');
            if (!button) return;
            e.preventDefault();
            const replyId = button.getAttribute('data-id');
            const heartIcon = button.querySelector('.heart-icon');
            const likeCountSpan = button.querySelector('.like-count');

            fetch(`/replies/${replyId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }
            })
            .then(response => { if (!response.ok) throw new Error(); return response.json(); })
            .then(data => { if (data.success) { heartIcon.textContent = data.liked ? '❤️' : '🤍'; likeCountSpan.textContent = data.likes_count; } })
            .catch(error => console.error(error));
        });
    });
</script>