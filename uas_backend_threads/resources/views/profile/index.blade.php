<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} (@__{{ $user->username ?? 'username' }}) - Profile</title>
</head>

<body style="background-color: #ffffff; color: #000000; font-family: sans-serif; margin: 0; padding: 0;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; position: relative;">

        <div style="margin-bottom: 20px;">
            <a href="{{ route('threads.index') }}" style="text-decoration: none; color: #999; font-size: 14px;">← Back to
                Feed</a>
        </div>

        @if (session('success'))
            <div
                style="background-color: #1c3d27; color: #72d58a; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
            <div>
                <h1 style="margin: 0; font-size: 28px; font-weight: bold; color: #000000;">{{ $user->name }}</h1>
                <p style="margin: 5px 0 0 0; color: #666666; font-size: 15px;">
                    {{ $user->username ? '@' . $user->username : 'belum ada username' }}
                </p>

                <p
                    style="margin: 15px 0 0 0; color: #111111; font-size: 15px; line-height: 1.4; white-space: pre-line;">
                    {{ $user->bio ?? 'No bio yet.' }}
                </p>
            </div>

            <div
                style="width: 70px; height: 70px; background-color: #f0f0f0; border: 1px solid #e0e0e0; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 32px; color: #888;">
                👤
            </div>
        </div>

        <div style="color: #666666; font-size: 14px; margin-bottom: 20px;">
            <span>{{ $followersCount ?? 0 }} followers</span>
        </div>

        <button type="button" id="openEditProfileBtn"
            style="width: 100%; background-color: #101010; color: #ffffff; border: none; padding: 10px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 15px; margin-bottom: 30px;">
            Edit profile
        </button>

        <div style="display: flex; border-bottom: 1px solid #e0e0e0; margin-bottom: 10px;">
            <div
                style="flex: 1; text-align: center; padding-bottom: 12px; border-bottom: 2px solid #101010; font-weight: bold; cursor: pointer; color: #101010;">
                Threads
            </div>
        </div>

        <div>
            @if ($threads->isEmpty())
                <p style="text-align: center; color: #777; margin-top: 50px;">You haven't posted any threads yet.</p>
            @else
                @foreach ($threads as $thread)
                    <div style="padding: 16px 0; border-bottom: 1px solid #eeeeee;">
                        <div>
                            <strong style="color: #101010;">{{ $thread->user->name }}</strong>
                            @if ($thread->community_or_topic)
                                <span style="color: #777; margin: 0 4px;">•</span>
                                <span style="color: #007bff;">#{{ $thread->community_or_topic }}</span>
                            @endif
                        </div>
                        <p style="margin: 8px 0; color: #222222; line-height: 1.4;">{{ $thread->content }}</p>

                        @if ($thread->image_path)
                            <div style="margin-top: 10px; display: inline-block; max-width: 100%;">
                                <img src="{{ str_starts_with($thread->image_path, 'http') ? $thread->image_path : asset($thread->image_path) }}"
                                    style="width: 100%; max-width: 450px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            </div>
                        @endif
                        <div style="margin-top: 8px; color: #888888; font-size: 12px;">
                            {{ $thread->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

    <div id="editProfileModal"
        style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center;">

        <div
            style="background-color: #ffffff; border: 1px solid #cccccc; color: #101010; padding: 24px; width: 100%; max-width: 450px; border-radius: 12px; box-shadow: 0 4px 25px rgba(0,0,0,0.15);">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 20px; color: #101010; font-weight: bold;">Edit Profile</h3>
                <button type="button" id="closeEditProfileBtn"
                    style="background: none; border: none; color: #666666; cursor: pointer; font-size: 18px; font-weight: bold;">✕</button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 13px; color: #555555; margin-bottom: 6px; font-weight: bold;">Nama</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        style="width: 100%; background-color: #f9f9f9; border: 1px solid #cccccc; color: #101010; padding: 11px; border-radius: 6px; box-sizing: border-box; outline: none; font-size: 14px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 13px; color: #555555; margin-bottom: 6px; font-weight: bold;">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}" placeholder="username_kamu"
                        style="width: 100%; background-color: #f9f9f9; border: 1px solid #cccccc; color: #101010; padding: 11px; border-radius: 6px; box-sizing: border-box; outline: none; font-size: 14px;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label
                        style="display: block; font-size: 13px; color: #555555; margin-bottom: 6px; font-weight: bold;">Bio</label>
                    <textarea name="bio" rows="4" placeholder="Tulis bio singkat kamu..."
                        style="width: 100%; background-color: #f9f9f9; border: 1px solid #cccccc; color: #101010; padding: 11px; border-radius: 6px; box-sizing: border-box; resize: none; outline: none; font-family: inherit; line-height: 1.4; font-size: 14px;">{{ $user->bio }}</textarea>
                </div>

                <button type="submit"
                    style="width: 100%; background-color: #101010; color: #ffffff; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 15px;">
                    Save Changes
                </button>
            </form>

        </div>
    </div>

    <script>
        const editModal = document.getElementById('editProfileModal');
        const openBtn = document.getElementById('openEditProfileBtn');
        const closeBtn = document.getElementById('closeEditProfileBtn');

        openBtn.addEventListener('click', () => editModal.style.display = 'flex');
        closeBtn.addEventListener('click', () => editModal.style.display = 'none');

        window.addEventListener('click', (e) => {
            if (e.target === editModal) editModal.style.display = 'none';
        });
    </script>
</body>

</html>
