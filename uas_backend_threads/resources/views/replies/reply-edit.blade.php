<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

<h2>Edit Komentar</h2>

@if(session('error'))
    <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
@endif

<div style="border: 1px solid #ccc; padding: 15px; border-radius: 8px; max-width: 600px; background: #fff;">
    <form id="form-edit-reply" action="{{ route('reply.update', $reply->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <textarea id="edit-reply-text" name="content" rows="3" required style="width: 100%; border: none; outline: none; resize: none; font-size: 14px;">{{ $reply->content }}</textarea>
        
        @if($reply->image)
            <div style="margin: 10px 0; padding: 5px; border: 1px dashed #ccc; border-radius: 6px; width: max-content;">
                <span style="font-size: 11px; color: #666; display: block; margin-bottom: 3px;">Media saat ini:</span>
                <img src="{{ asset('storage/' . $reply->image) }}" alt="Current Media" style="max-width: 150px; max-height: 150px; border-radius: 4px; display: block;">
            </div>
        @endif
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; gap: 8px; align-items: center;">
                    <label style="cursor: pointer; border: 1px solid #ccc; padding: 4px 8px; border-radius: 4px; font-size: 13px; background: #f9f9f9;">
                        🔄 Ganti Photo / GIF
                        <input type="file" name="image" accept="image/*" style="display: none;">
                    </label>
                    
                    <button type="button" id="emoji-button-edit" style="cursor: pointer; border: 1px solid #ccc; padding: 4px 8px; border-radius: 4px; font-size: 13px; background: #f9f9f9;">
                        😊 Emoji
                    </button>
                </div>
                
                <div>
                    <a href="{{ route('threads.show', $reply->thread_id) }}" style="text-decoration: none; color: #555; font-size: 13px; margin-right: 15px;">Batal</a>
                    <button type="submit" id="submit-btn-edit" style="background: #000; color: #fff; border: none; padding: 6px 15px; border-radius: 4px; font-weight: bold; cursor: pointer;">Simpan Perubahan</button>
                </div>
            </div>

            <div id="emoji-picker-container-edit" style="display: none; margin-top: 5px; max-width: 100%;"></div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editTextarea = document.getElementById('edit-reply-text');
    const emojiBtn = document.getElementById('emoji-button-edit');
    const pickerContainer = document.getElementById('emoji-picker-container-edit');

    const pickerOptions = { 
        theme: 'dark',
        set: 'native',
        onEmojiSelect: function(emoji) {
            editTextarea.value += emoji.native;
            editTextarea.focus();
        }
    };
    
    const picker = new EmojiMart.Picker(pickerOptions);
    pickerContainer.appendChild(picker);

    emojiBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (pickerContainer.style.display === 'none') {
            pickerContainer.style.display = 'block';
        } else {
            pickerContainer.style.display = 'none';
        }
    });
});
</script>