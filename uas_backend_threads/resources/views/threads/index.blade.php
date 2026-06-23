<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads Clone</title>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@1/index.js"></script>
</head>

<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; position: relative;">

        @if (session('success'))
            <div
                style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px;">
                {{ session('error') }}
            </div>
        @endif

        <div
            style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 20px;">
            <div>
                <h1 style="margin: 0;">Threads</h1>

                <div style="margin-top: 10px; display: flex; gap: 10px; align-items: center;">
                    <button id="openModalBtn">
                        + New Thread
                    </button>
                    <a href="{{ route('search') }}">
                        <button type="button" style="cursor: pointer;"> Search Network</button>
                    </a>
                    <a href="/bookmarks">
                        <button type="button" style="cursor: pointer;"> Saved Bookmarks</button>
                    </a>
                </div>
            </div>

            <div style="text-align: right;">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="cursor: pointer; color: red; background: none; border: 1px solid red; padding: 4px 8px; border-radius: 4px;">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div>
            @foreach ($threads as $thread)
                <div style="padding: 16px 0; border-bottom: 1px solid #efefef; position: relative;">

                    <div style="position: absolute; top: 16px; right: 0; z-index: 999;">
                        <button type="button" class="menu-dot-btn"
                            style="background: none; border: none; font-size: 20px; cursor: pointer; color: #555; padding: 0 5px;">
                            •••
                        </button>

                        <div class="menu-dropdown"
                            style="display: none; position: absolute; right: 0; top: 25px; background: white; border: 1px solid #ccc; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); width: 180px; padding: 5px 0; z-index: 1000;">

                            <button type="button" class="bookmark-btn" data-id="{{ $thread->id }}"
                                style="width: 100%; text-align: left; background: none; border: none; padding: 10px 14px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <span class="bookmark-icon"></span> Save Bookmark
                            </button>

                            @if ($thread->user_id === Auth::id())
                                <hr style="margin: 4px 0; border: 0; border-top: 1px solid #eee;">
                                <button type="button" class="edit-thread-btn" data-id="{{ $thread->id }}"
                                    data-content="{{ $thread->content }}" data-topic="{{ $thread->community_or_topic }}"
                                    style="width: 100%; text-align: left; background: none; border: none; padding: 10px 14px; font-size: 13px; cursor: pointer; color: #007bff; display: flex; align-items: center; gap: 8px;">
                                    Edit Post
                                </button>

                                <hr style="margin: 4px 0; border: 0; border-top: 1px solid #eee;">
                                <form action="{{ route('threads.destroy', $thread->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus thread ini?')"
                                    style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="width: 100%; text-align: left; background: none; border: none; padding: 10px 14px; font-size: 13px; cursor: pointer; color: red; display: flex; align-items: center; gap: 8px;">
                                        Delete Post
                                    </button>
                                </form>
                            @else
                                <hr style="margin: 4px 0; border: 0; border-top: 1px solid #eee;">

                                <button type="button" class="trigger-report-btn"
                                    style="width: 100%; text-align: left; background: none; border: none; padding: 10px 14px; font-size: 13px; cursor: pointer; color: #cc8b00; display: flex; align-items: center; gap: 8px;">
                                    Report Post
                                </button>

                                <div class="report-form-wrapper" style="display: none; padding: 5px 14px 10px 14px;">
                                    <form action="{{ route('reports.store') }}" method="POST"
                                        style="margin: 0; display: flex; flex-direction: column; gap: 6px;">
                                        @csrf
                                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                        <select name="reason" required
                                            style="width: 100%; font-size: 12px; padding: 4px; border: 1px solid #ccc; border-radius: 4px;">
                                            <option value="" disabled selected>Pilih Alasan...</option>
                                            <option value="Spam atau Iklan">Spam / Iklan</option>
                                            <option value="Ujaran Kebencian">Hate Speech</option>
                                            <option value="Konten Tidak Layak">Inappropriate</option>
                                        </select>
                                        <button type="submit"
                                            style="width: 100%; font-size: 12px; background: #f0ad4e; color: white; border: none; padding: 6px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                                            Kirimin Laporan
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>

                    <a href="{{ route('threads.show', $thread->id) }}"
                        style="text-decoration: none; color: inherit; display: block; padding-right: 40px;">
                        <div>
                            <strong>{{ $thread->user->name }}</strong>
                            @if ($thread->community_or_topic)
                                <span>•</span>
                                <span style="color: blue;">{{ $thread->community_or_topic }}</span>
                            @endif
                        </div>

                        <p style="margin: 8px 0;">{{ $thread->content }}</p>

                        @if ($thread->image_path)
                            <div style="margin-top: 10px; margin-bottom: 15px; display: inline-block; max-width: 100%;">
                                <img src="{{ str_starts_with($thread->image_path, 'http') ? $thread->image_path : asset($thread->image_path) }}"
                                    alt="Uploaded Image"
                                    style="width: 400px; max-width: 100%; height: auto; max-height: 300px; object-fit: cover; display: block; border: 1px solid #ccc;">
                            </div>
                        @endif
                    </a>

                </div>
            @endforeach
        </div>
    </div>

    <div id="threadModal"
        style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center;">
        <div
            style="background-color: #ffffff; color: #000000; padding: 20px; width: 100%; max-width: 500px; border-radius: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <button id="closeModalBtn">Cancel</button>
                <h2 style="margin: 0;">New thread</h2>
                <div style="color: #999;">📄</div>
            </div>

            <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: flex; gap: 12px; margin-bottom: 15px;">
                    <div style="font-size: 24px;">👤</div>
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 8px;">
                        <input type="text" name="community_or_topic" placeholder="Community or topic (optional)"
                            style="width: 100%; padding: 6px;">
                        <textarea id="threadContent" name="content" rows="4" placeholder="What's new?" required
                            style="width: 100%; padding: 6px; resize: none; font-family: inherit;"></textarea>

                        <div id="imagePreviewContainer"
                            style="display: none; position: relative; margin-top: 10px; max-width: 100px;">
                            <img id="imagePreview" src="#" style="max-width: 100%;">
                            <input type="hidden" id="gifUrlInput" name="gif_url">
                            <button type="button" id="removeImageBtn"
                                style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; cursor: pointer;">✕</button>
                        </div>

                        <input type="file" id="fileInput" name="image" accept="image/*"
                            onchange="previewFile()" style="display: none;">

                        <div style="display: flex; gap: 10px; margin-top: 5px;">
                            <button type="button" onclick="document.getElementById('fileInput').click()"
                                title="Attach Photo">🖼️ Photo</button>
                            <button type="button" id="gifBtn" title="Choose GIF">👾 GIF</button>
                            <button type="button" id="emojiBtn" title="Insert Emoji">😊 Emoji</button>
                        </div>

                        <div id="gifPopup"
                            style="display: none; background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 10px; margin-top: 5px; max-height: 200px; overflow-y: auto;">
                            <input type="text" id="gifSearchInput" placeholder="Search local GIFs..."
                                style="width: 100%; padding: 6px; margin-bottom: 8px; box-sizing: border-box;">
                            <div id="gifGridContainer"
                                style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 5px;"></div>
                        </div>

                        <div id="emojiPopup" style="display: none; margin-top: 5px;">
                            <emoji-picker style="width: 100%; height: 250px;"></emoji-picker>
                        </div>
                    </div>
                </div>

                <div
                    style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 15px;">
                    <span style="color: #999; font-size: 13px;">Anyone can reply</span>
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editThreadModal"
        style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center;">
        <div
            style="background-color: #ffffff; color: #000000; padding: 20px; width: 100%; max-width: 500px; border-radius: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <button type="button" id="closeEditModalBtn">Cancel</button>
                <h2 style="margin: 0;">Edit Thread</h2>
                <div style="color: #999;">✏️</div>
            </div>

            <form id="editThreadForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div style="display: flex; gap: 12px; margin-bottom: 15px;">
                    <div style="font-size: 24px;">👤</div>
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 8px;">
                        <input type="text" id="editCommunityOrTopic" name="community_or_topic"
                            placeholder="Community or topic (optional)" style="width: 100%; padding: 6px;">
                        <textarea id="editThreadContent" name="content" rows="4" placeholder="Update content..." required
                            style="width: 100%; padding: 6px; resize: none; font-family: inherit;"></textarea>
                    </div>
                </div>

                <div
                    style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 15px;">
                    <span style="color: #999; font-size: 13px;">Editing post mode</span>
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('threadModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');
        const gifUrlInput = document.getElementById('gifUrlInput');
        const removeImageBtn = document.getElementById('removeImageBtn');
        const threadContent = document.getElementById('threadContent');

        const gifBtn = document.getElementById('gifBtn');
        const gifPopup = document.getElementById('gifPopup');
        const gifGridContainer = document.getElementById('gifGridContainer');
        const gifSearchInput = document.getElementById('gifSearchInput');

        const emojiBtn = document.getElementById('emojiBtn');
        const emojiPopup = document.getElementById('emojiPopup');
        const picker = document.querySelector('emoji-picker');

        const editModal = document.getElementById('editThreadModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editThreadForm = document.getElementById('editThreadForm');
        const editCommunityOrTopic = document.getElementById('editCommunityOrTopic');
        const editThreadContent = document.getElementById('editThreadContent');

        const localGifs = [{
                name: "cat laugh meme lucu kucing ketawa ngakak",
                url: "https://media4.giphy.com/media/tJqyalvo9ahykfykAj/200.gif"
            },
            {
                name: "shocked wow kaget nani terkejut blink",
                url: "https://media3.giphy.com/media/l3q2zVr6cu95nF6O4/200.gif"
            },
            {
                name: "homer simpson hide back sembunyi",
                url: "https://media1.giphy.com/media/a93jwI0wkWTQs/200.gif"
            },
            {
                name: "thumbs up mantap okey setuju keren sip",
                url: "https://media1.giphy.com/media/3NtY188QaxDdC/200.gif"
            },
            {
                name: "mind blown meledak kaget gila wow",
                url: "https://media1.giphy.com/media/26ufdipQqU2lhNA4g/200.gif"
            },
            {
                name: "dog fine fire aman santai santuy",
                url: "https://media3.giphy.com/media/QMHoU66sBXqqLqYvGO/200.gif"
            },
        ];

        openBtn.addEventListener('click', () => modal.style.display = 'flex');
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            gifPopup.style.display = 'none';
            emojiPopup.style.display = 'none';
        });

        function previewFile() {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                    gifUrlInput.value = "";
                    gifPopup.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }

        removeImageBtn.addEventListener('click', () => {
            fileInput.value = "";
            gifUrlInput.value = "";
            previewContainer.style.display = 'none';
            previewImage.src = "#";
        });

        function renderLocalGIFs(filterKeyword = "") {
            gifGridContainer.innerHTML = "";
            const query = filterKeyword.toLowerCase().trim();
            const matchedGifs = localGifs.filter(item => item.name.includes(query));

            if (matchedGifs.length === 0) {
                gifGridContainer.innerHTML =
                    '<div style="grid-column: span 3; font-size: 12px; color: #999;">No GIFs found.</div>';
                return;
            }

            matchedGifs.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.url;
                img.style.cursor = 'pointer';
                img.style.width = '100%';
                img.style.borderRadius = '4px';

                img.addEventListener('click', () => {
                    previewImage.src = gif.url;
                    gifUrlInput.value = gif.url;
                    previewContainer.style.display = 'block';
                    fileInput.value = "";
                    gifPopup.style.display = 'none';
                });
                gifGridContainer.appendChild(img);
            });
        }

        gifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            gifPopup.style.display = gifPopup.style.display === 'none' ? 'block' : 'none';
            emojiPopup.style.display = 'none';
            if (gifPopup.style.display === 'block') {
                renderLocalGIFs(gifSearchInput.value);
            }
        });

        gifSearchInput.addEventListener('input', () => {
            renderLocalGIFs(gifSearchInput.value);
        });

        emojiBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            emojiPopup.style.display = emojiPopup.style.display === 'none' ? 'block' : 'none';
            gifPopup.style.display = 'none';
        });

        picker.addEventListener('emoji-click', event => {
            threadContent.value += event.detail.unicode;
        });

        document.querySelectorAll('.menu-dot-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const currentDropdown = btn.nextElementSibling;
                document.querySelectorAll('.menu-dropdown').forEach(dd => {
                    if (dd !== currentDropdown) dd.style.display = 'none';
                });

                currentDropdown.style.display = currentDropdown.style.display === 'none' ? 'block' : 'none';
            });
        });

        document.querySelectorAll('.trigger-report-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const formWrapper = btn.nextElementSibling;
                if (formWrapper.style.display === 'none') {
                    formWrapper.style.display = 'block';
                    btn.style.fontWeight = 'bold';
                } else {
                    formWrapper.style.display = 'none';
                    btn.style.fontWeight = 'normal';
                }
            });
        });

        document.querySelectorAll('.edit-thread-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const id = btn.getAttribute('data-id');
                const content = btn.getAttribute('data-content');
                const topic = btn.getAttribute('data-topic');

                editThreadContent.value = content;
                editCommunityOrTopic.value = topic;
                editThreadForm.action = `/threads/${id}`;

                btn.closest('.menu-dropdown').style.display = 'none';
                editModal.style.display = 'flex';
            });
        });

        closeEditModalBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });


        document.addEventListener('click', (e) => {
            if (!gifPopup.contains(e.target) && e.target !== gifBtn) gifPopup.style.display = 'none';
            if (!emojiPopup.contains(e.target) && e.target !== emojiBtn) emojiPopup.style.display = 'none';
            if (e.target === editModal) editModal.style.display = 'none';

            if (!e.target.classList.contains('menu-dot-btn') && !e.target.closest('.menu-dropdown')) {
                document.querySelectorAll('.menu-dropdown').forEach(dd => {
                    dd.style.display = 'none';
                    const formWrapper = dd.querySelector('.report-form-wrapper');
                    const triggerBtn = dd.querySelector('.trigger-report-btn');
                    if (formWrapper) formWrapper.style.display = 'none';
                    if (triggerBtn) triggerBtn.style.fontWeight = 'normal';
                });
            }
        });

        document.querySelectorAll('.bookmark-btn').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();

                const threadId = this.getAttribute('data-id');
                const icon = this.querySelector('.bookmark-icon');

                try {
                    const response = await fetch('/bookmarks', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            thread_id: threadId
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        icon.innerText = "⭐";
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    console.error('Error proses bookmarking:', error);
                }
            });
        });
    </script>
</body>

</html>
