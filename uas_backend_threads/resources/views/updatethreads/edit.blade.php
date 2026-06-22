<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        textarea { scrollbar-width: none; }
        textarea::-webkit-scrollbar { display: none; }
        input[type="password"] { letter-spacing: 0.12em; }
        input[type="password"]::placeholder { letter-spacing: normal; }
        .fade-in { animation: fadeIn 0.25s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-zinc-100 dark:bg-zinc-950 min-h-screen">

    <div class="max-w-lg mx-auto min-h-screen bg-white dark:bg-zinc-900 flex flex-col fade-in">

        <div class="sticky top-0 z-10 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md flex items-center justify-between px-4 py-3.5 border-b border-zinc-100 dark:border-zinc-800">
            <a href="{{ route('updatethreads.index') }}" class="w-16 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white transition-colors">Batal</a>
            <span class="text-[15px] font-semibold text-zinc-900 dark:text-white">Edit profil</span>
            <button form="editForm" type="submit" class="w-16 text-right text-sm font-semibold text-zinc-900 dark:text-white active:opacity-60 transition-opacity">Selesai</button>
        </div>

        <div class="px-4 py-5 border-b border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="relative shrink-0">
                        <div class="w-[60px] h-[60px] rounded-full bg-gradient-to-br from-amber-400 via-orange-400 to-red-500 flex items-center justify-center text-white text-[22px] font-semibold select-none shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <button type="button" class="absolute -bottom-0.5 -right-0.5 w-[22px] h-[22px] bg-white dark:bg-zinc-900 rounded-full border-2 border-white dark:border-zinc-900 shadow flex items-center justify-center" aria-label="Ganti foto">
                            <div class="w-4 h-4 bg-zinc-800 dark:bg-zinc-200 rounded-full flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white dark:text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[15px] font-semibold text-zinc-900 dark:text-white leading-tight truncate">{{ $user->name }}</p>
                        <!-- <p class="text-[13px] text-zinc-400 mt-0.5 truncate">@{{ strtolower(str_replace(' ', '', $user->name)) }}</p> -->
                    </div>
                </div>
                <button type="button" class="text-[13px] font-medium text-zinc-500 dark:text-zinc-400 shrink-0 ml-3">Ganti foto</button>
            </div>
        </div>

        @if ($errors->any())
            <div class="mx-4 mt-4 p-3.5 bg-red-50 dark:bg-red-950/40 border border-red-100 dark:border-red-900/50 rounded-2xl">
                @foreach ($errors->all() as $error)
                    <p class="text-[13px] text-red-600 dark:text-red-400 leading-relaxed">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form id="editForm" action="{{ route('updatethreads.update', $user->id) }}" method="POST" class="flex-1">
            @csrf
            @method('PUT')

            <div class="px-4 pt-6 pb-1.5">
                <p class="text-[11px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Informasi akun</p>
            </div>

            <div class="mx-4 rounded-2xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
                <div class="flex items-center px-4 py-3.5 border-b border-zinc-100 dark:border-zinc-800">
                    <label class="text-[13px] font-medium text-zinc-500 dark:text-zinc-400 w-16 shrink-0">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        maxlength="50"
                        placeholder="Nama tampilan"
                        class="flex-1 text-[15px] text-right bg-transparent outline-none text-zinc-900 dark:text-white placeholder-zinc-300 dark:placeholder-zinc-600 min-w-0"
                    />
                </div>
                <div class="flex items-center px-4 py-3.5">
                    <label class="text-[13px] font-medium text-zinc-500 dark:text-zinc-400 w-16 shrink-0">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Alamat email"
                        class="flex-1 text-[15px] text-right bg-transparent outline-none text-zinc-900 dark:text-white placeholder-zinc-300 dark:placeholder-zinc-600 min-w-0"
                    />
                </div>
            </div>

            <div class="px-4 pt-6 pb-1.5">
                <p class="text-[11px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Bio</p>
            </div>

            <div class="mx-4 rounded-2xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
                <div class="px-4 py-3.5">
                    <textarea
                        name="bio"
                        id="bioInput"
                        maxlength="150"
                        rows="3"
                        placeholder="Tulis bio singkat tentang dirimu..."
                        class="w-full text-[15px] bg-transparent outline-none text-zinc-900 dark:text-white placeholder-zinc-300 dark:placeholder-zinc-600 resize-none leading-relaxed"
                    >{{ old('bio') }}</textarea>
                    <div class="flex justify-end mt-1">
                        <span id="charCount" class="text-[12px] text-zinc-300 dark:text-zinc-600 tabular-nums">0 / 150</span>
                    </div>
                </div>
            </div>

            <div class="px-4 pt-6 pb-1.5">
                <p class="text-[11px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Keamanan</p>
            </div>

            <div class="mx-4 rounded-2xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
                <div class="flex items-center px-4 py-3.5">
                    <label class="text-[13px] font-medium text-zinc-500 dark:text-zinc-400 w-20 shrink-0">Kata sandi</label>
                    <div class="flex-1 flex items-center gap-2 min-w-0 justify-end">
                        <input
                            type="password"
                            name="password"
                            id="passInput"
                            placeholder="Kosongkan jika tidak diubah"
                            class="text-[15px] text-right bg-transparent outline-none text-zinc-900 dark:text-white placeholder-zinc-300 dark:placeholder-zinc-600 min-w-0 flex-1"
                        />
                        <button type="button" onclick="togglePass()" class="shrink-0 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors" aria-label="Tampilkan kata sandi">
                            <svg id="eyeOn" class="w-4.5 h-4.5" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeOff" class="hidden" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-4 mt-8 pb-10">
                <button
                    type="submit"
                    class="w-full h-12 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-2xl text-[15px] font-semibold tracking-tight active:scale-[0.98] hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-all"
                >
                    Simpan perubahan
                </button>
                <a
                    href="{{ route('updatethreads.index') }}"
                    class="block w-full h-12 mt-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 text-[15px] font-medium text-zinc-500 dark:text-zinc-400 text-center leading-[48px] hover:bg-zinc-50 dark:hover:bg-zinc-800/60 active:scale-[0.98] transition-all"
                >
                    Batal
                </a>
            </div>
        </form>

    </div>

    <script>
        const bioInput = document.getElementById('bioInput');
        const charCount = document.getElementById('charCount');
        function updateCount() {
            charCount.textContent = bioInput.value.length + ' / 150';
        }
        bioInput.addEventListener('input', updateCount);
        updateCount();

        function togglePass() {
            const input = document.getElementById('passInput');
            const eyeOn = document.getElementById('eyeOn');
            const eyeOff = document.getElementById('eyeOff');
            if (input.type === 'password') {
                input.type = 'text';
                input.style.letterSpacing = 'normal';
                eyeOn.classList.add('hidden');
                eyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                input.style.letterSpacing = '';
                eyeOn.classList.remove('hidden');
                eyeOff.classList.add('hidden');
            }
        }
    </script>
</body>
</html>