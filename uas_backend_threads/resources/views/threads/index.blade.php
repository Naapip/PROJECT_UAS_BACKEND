<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@1/index.js"></script>
</head>

<body class="bg-[#101010] text-white font-sans">

    <div class="max-w-xl mx-auto p-4">
        <div class="flex justify-between items-center py-4 border-b border-gray-800">
            <h1 class="text-2xl font-bold">Threads</h1>
            <button id="openModalBtn"
                class="bg-white text-black px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition">
                + New Thread
            </button>
        </div>

        <!-- LIST FEED THREADS -->
        <div class="mt-6 space-y-4">
            @foreach ($threads as $thread)
                <a href="{{ route('threads.show', $thread->id) }}"
                    class="block p-4 bg-[#181818] rounded-xl border border-gray-800 hover:bg-[#202020] transition">
                    <div class="flex items-center space-x-2 text-gray-400 text-sm mb-2">
                        <span class="font-bold text-white">bakwanrimac</span>
                        @if ($thread->community_or_topic)
                            <span>•</span>
                            <span class="text-blue-400">{{ $thread->community_or_topic }}</span>
                        @endif
                    </div>

                    <p class="text-gray-200 mb-3">{{ $thread->content }}</p>

                    @if ($thread->image_path)
                        <div
                            class="rounded-lg overflow-hidden border border-gray-800 max-h-60 flex items-center justify-center bg-black">
                            <img src="{{ str_starts_with($thread->image_path, 'http') ? $thread->image_path : asset($thread->image_path) }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <!-- MODAL POST -->
    <div id="threadModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-[#181818] w-full max-w-lg rounded-2xl border border-gray-800 shadow-2xl mx-4 relative">

            <div class="flex justify-between items-center px-4 py-3 border-b border-gray-800">
                <button id="closeModalBtn" class="text-gray-400 hover:text-white text-sm">Cancel</button>
                <h2 class="font-bold text-base">New thread</h2>
                <div class="flex space-x-3 text-gray-400">
                    <span class="cursor-pointer hover:text-white">📄</span>
                    <span>⋯</span>
                </div>
            </div>

            <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf
                <div class="flex items-start space-x-3">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-600 flex-shrink-0 flex items-center justify-center text-xs">
                        👤</div>

                    <div class="flex-1 relative">
                        <div class="mb-1">
                            <input type="text" name="community_or_topic" placeholder="Community or topic >"
                                class="bg-transparent text-sm text-gray-500 focus:outline-none w-full placeholder-gray-600">
                        </div>

                        <textarea id="threadContent" name="content" rows="3" placeholder="What's new?" required
                            class="bg-transparent text-white placeholder-gray-600 w-full resize-none focus:outline-none text-sm"></textarea>

                        <!-- Wadah Preview Gambar / GIF Seleksi -->
                        <div id="imagePreviewContainer"
                            class="hidden relative mt-2 rounded-lg overflow-hidden border border-gray-800 max-h-40 bg-black">
                            <img id="imagePreview" src="#" class="max-h-40 mx-auto object-contain">
                            <input type="hidden" id="gifUrlInput" name="gif_url">
                            <button type="button" id="removeImageBtn"
                                class="absolute top-1 right-1 bg-black/70 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-black">✕</button>
                        </div>

                        <input type="file" id="fileInput" name="image" accept="image/*" class="hidden"
                            onchange="previewFile()">

                        <!-- Tombol Aksi (Sesuai gambar cbdc7e.png) -->
                        <div class="flex space-x-4 text-gray-500 text-base mt-3 items-center relative">
                            <button type="button" onclick="document.getElementById('fileInput').click()"
                                class="hover:text-gray-300" title="Attach Photo">🖼️</button>
                            <button type="button" id="gifBtn" class="hover:text-gray-300"
                                title="Choose GIF">👾</button>
                            <button type="button" id="emojiBtn" class="hover:text-gray-300"
                                title="Insert Emoji">😊</button>
                        </div>

                        <!-- PANEL POPUP GIF (100% Aman Langsung Pakai URL Bebas Blokir) -->
                        <div id="gifPopup"
                            class="absolute left-0 bottom-10 bg-[#222] border border-gray-700 rounded-xl p-3 hidden w-72 z-50 shadow-xl">
                            <input type="text" id="gifSearchInput" placeholder="Search 12+ local database GIFs..."
                                class="bg-[#101010] text-sm text-white border border-gray-700 rounded-lg px-3 py-1.5 w-full mb-3 focus:outline-none focus:border-gray-500">

                            <div id="gifGridContainer" class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                                <!-- Konten akan dirender otomatis oleh JavaScript -->
                            </div>
                        </div>

                        <!-- PANEL POPUP EMOTE PICKER (Real Picker) -->
                        <div id="emojiPopup" class="absolute left-0 bottom-10 hidden z-50 shadow-xl">
                            <emoji-picker class="dark"></emoji-picker>
                        </div>

                    </div>
                </div>

                <div class="flex justify-between items-center mt-6 pt-3 border-t border-gray-800">
                    <span class="text-xs text-gray-500">Post Options</span>
                    <button type="submit"
                        class="bg-white text-black px-5 py-1.5 rounded-full text-sm font-semibold hover:bg-gray-200 transition">
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

        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            gifPopup.classList.add('hidden');
            emojiPopup.classList.add('hidden');
        });

        function previewFile() {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    gifUrlInput.value = ""; 
                    gifPopup.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        removeImageBtn.addEventListener('click', () => {
            fileInput.value = "";
            gifUrlInput.value = "";
            previewContainer.classList.add('hidden');
            previewImage.src = "#";
        });

        function renderLocalGIFs(filterKeyword = "") {
            gifGridContainer.innerHTML = "";
            const query = filterKeyword.toLowerCase().trim();

            const matchedGifs = localGifs.filter(item => item.name.includes(query));

            if (matchedGifs.length === 0) {
                gifGridContainer.innerHTML =
                    '<div class="text-xs text-gray-500 text-center col-span-2 py-4">No GIFs found.</div>';
                return;
            }

            matchedGifs.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.url;
                img.className =
                    'cursor-pointer rounded h-24 w-full object-cover hover:scale-105 transition border border-transparent hover:border-gray-500';

                img.addEventListener('click', () => {
                    previewImage.src = gif.url;
                    gifUrlInput.value = gif.url; 
                    previewContainer.classList.remove('hidden');
                    fileInput.value = "";
                    gifPopup.classList.add('hidden');
                });

                gifGridContainer.appendChild(img);
            });
        }

        gifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            gifPopup.classList.toggle('hidden');
            emojiPopup.classList.add('hidden');

            if (!gifPopup.classList.contains('hidden')) {
                renderLocalGIFs(gifSearchInput.value);
            }
        });

        gifSearchInput.addEventListener('input', () => {
            renderLocalGIFs(gifSearchInput.value);
        });

        emojiBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            emojiPopup.classList.toggle('hidden');
            gifPopup.classList.add('hidden');
        });

        picker.addEventListener('emoji-click', event => {
            threadContent.value += event.detail.unicode;
        });

        document.addEventListener('click', (e) => {
            if (!gifPopup.contains(e.target) && e.target !== gifBtn) gifPopup.classList.add('hidden');
            if (!emojiPopup.contains(e.target) && e.target !== emojiBtn) emojiPopup.classList.add('hidden');
        });
    </script>
</body>

</html>
