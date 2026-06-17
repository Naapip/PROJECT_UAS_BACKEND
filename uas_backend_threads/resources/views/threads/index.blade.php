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

        <div
            style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 20px;">
            <div>
                <h1 style="margin: 0;">Threads</h1>
                <button id="openModalBtn" style="margin-top: 10px;">
                    + New Thread
                </button>
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
                <div style="padding: 16px 0; border-bottom: 1px solid #efefef;">

                    <a href="{{ route('threads.show', $thread->id) }}"
                        style="text-decoration: none; color: inherit; display: block;">
                        <div>
                            <strong>{{ $thread->user->name }}</strong>
                            <span style="color: #777;"></span>
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

                    <div style="margin-top: 10px;">
                        <button type="button" class="bookmark-btn" data-id="{{ $thread->id }}"
                            style="cursor: pointer;">
                            <span class="bookmark-icon">🔖</span> Save to Bookmark
                        </button>
                    </div>

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

                        <input type="file" id="fileInput" name="image" accept="image/*" onchange="previewFile()"
                            style="display: none;">

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

        document.addEventListener('click', (e) => {
            if (!gifPopup.contains(e.target) && e.target !== gifBtn) gifPopup.style.display = 'none';
            if (!emojiPopup.contains(e.target) && e.target !== emojiBtn) emojiPopup.style.display = 'none';
        });

        // AJAX POST Bookmark
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
