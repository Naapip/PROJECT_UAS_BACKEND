<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads Clone</title>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@1/index.js"></script>
</head>

<body>

    <div>
        <div>
            <h1>Threads</h1>
            <button id="openModalBtn">
                + New Thread
            </button>
        </div>

        <div>
            @foreach ($threads as $thread)
                <a href="{{ route('threads.show', $thread->id) }}">
                    <div>
                        <span>bakwanrimac</span>
                        @if ($thread->community_or_topic)
                            <span>•</span>
                            <span>{{ $thread->community_or_topic }}</span>
                        @endif
                    </div>

                    <p>{{ $thread->content }}</p>

                    @if ($thread->image_path)
                        <div>
                            <img
                                src="{{ str_starts_with($thread->image_path, 'http') ? $thread->image_path : asset($thread->image_path) }}">
                        </div>
                    @endif
                </a>

                <div>
                    <button type="button" class="bookmark-btn" data-id="{{ $thread->id }}">
                        <span class="bookmark-icon">🔖</span> Save to Bookmark
                    </button>
                </div>
                <hr>
            @endforeach
        </div>
    </div>

    <div id="threadModal" style="display: none;">
        <div>
            <div>
                <button id="closeModalBtn">Cancel</button>
                <h2>New thread</h2>
                <div>
                    <span>📄</span>
                    <span>⋯</span>
                </div>
            </div>

            <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div>👤</div>

                    <div>
                        <div>
                            <input type="text" name="community_or_topic" placeholder="Community or topic >">
                        </div>

                        <textarea id="threadContent" name="content" rows="3" placeholder="What's new?" required></textarea>

                        <div id="imagePreviewContainer" style="display: none;">
                            <img id="imagePreview" src="#">
                            <input type="hidden" id="gifUrlInput" name="gif_url">
                            <button type="button" id="removeImageBtn">✕</button>
                        </div>

                        <input type="file" id="fileInput" name="image" accept="image/*" onchange="previewFile()">

                        <div>
                            <button type="button" onclick="document.getElementById('fileInput').click()"
                                title="Attach Photo">🖼️</button>
                            <button type="button" id="gifBtn" title="Choose GIF">👾</button>
                            <button type="button" id="emojiBtn" title="Insert Emoji">😊</button>
                        </div>

                        <div id="gifPopup" style="display: none;">
                            <input type="text" id="gifSearchInput" placeholder="Search 12+ local database GIFs...">
                            <div id="gifGridContainer">
                            </div>
                        </div>

                        <div id="emojiPopup" style="display: none;">
                            <emoji-picker></emoji-picker>
                        </div>

                    </div>
                </div>

                <div>
                    <span>Post Options</span>
                    <button type="submit">
                        Post
                    </button>
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

        // Database 12 URL GIF Statis
        const localGifs = [{
                name: "cat laugh meme lucu kucing ketawa ngakak",
                url: "https://media4.giphy.com/media/tJqyalvo9ahykfykAj/200.gif"
            },
            {
                name: "shocked wow kaget nani terkejut blink",
                url: "https://media3.giphy.com/media/l3q2zVr6cu95nF6O4/200.gif"
            },
            {
                name: "naruto run anime ninja running lari",
                url: "https://media4.giphy.com/media/cuPm4A492Th6g/200.gif"
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
                name: "dance happy joget minion senang pesta",
                url: "https://media1.giphy.com/media/G9q3dT7SUJWNy/200.gif"
            },
            {
                name: "crying sad sedih nangis kecewa sedih",
                url: "https://media0.giphy.com/media/oGO1MPAbVfU9W/200.gif"
            },
            {
                name: "stare monkey bingung heran lirik melirik",
                url: "https://media0.giphy.com/media/ee3fPvws76Nva/200.gif"
            },
            {
                name: "spiderman point menunjuk kembar twins",
                url: "https://media4.giphy.com/media/l36kU8mSVKDFKdVpm/200.gif"
            },
            {
                name: "mind blown meledak kaget gila wow",
                url: "https://media1.giphy.com/media/26ufdipQqU2lhNA4g/200.gif"
            },
            {
                name: "dog fine fire aman santai santuy",
                url: "https://media3.giphy.com/media/QMHoU66sBXqqLqYvGO/200.gif"
            },
            {
                name: "clapping tepuk tangan bravo mantap",
                url: "https://media1.giphy.com/media/l3q2XhfQ8oCkm1K76/200.gif"
            }
        ];

        // Manajemen Aksi Buka Tutup Modal Utama menggunakan Inline Style Element
        openBtn.addEventListener('click', () => modal.style.display = 'block');
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
                gifGridContainer.innerHTML = '<div>No GIFs found.</div>';
                return;
            }

            matchedGifs.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.url;
                img.style.cursor = 'pointer';
                img.style.width = '100px';

                img.addEventListener('click', () => {
                    previewImage.src = gif.url;
                    gifUrlInput.value = gif.url;
                    previewContainer.style.style = 'block';
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

        document.addEventListener('click', (e) => {
            if (!gifPopup.contains(e.target) && e.target !== gifBtn) gifPopup.style.display = 'none';
            if (!emojiPopup.contains(e.target) && e.target !== emojiBtn) emojiPopup.style.display = 'none';
        });

        // 🔖 LOGIKA AJAX UNTUK KIRIM DATA KE MVC BOOKMARK BARU (TANPA RELOAD)
        document.querySelectorAll('.bookmark-btn').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation(); // Menahan agar tidak trigger link a href detail post

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
                        icon.innerText = "⭐"; // Menandakan postingan sukses tersimpan
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
