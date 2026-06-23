<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>

<body>

    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        <div style="margin-bottom: 15px; display: flex; gap: 15px;">
            <a href="{{ route('threads.index') }}">← Back to Feed</a>
            <a href="{{ route('connections') }}">👥 View My Network</a>
        </div>

        <h2>Search User & Thread</h2>
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="query" placeholder="Search users or content..." value="{{ request('query') }}"
                style="width: 75%; padding: 6px;">
            <button type="submit" style="padding: 6px 12px; cursor: pointer;">Search</button>
        </form>

        @if ($errors->any())
            <div style="color: red; margin-top: 10px;">
                @foreach ($errors->all() as $error)
                    <small style="display: block;">⚠️ {{ $error }}</small>
                @endforeach
            </div>
        @endif

        <hr style="margin: 20px 0;">

        <h3>Users Results</h3>
        @if (empty($query))
            <p style="color: #777; font-style: italic;">Masukkan kata kunci untuk mencari.</p>
        @elseif($userResults->isEmpty())
            <p>Tidak ada user yang cocok dengan "{{ $query }}".</p>
        @else
            @foreach ($userResults as $user)
                <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 6px;">
                    <b>User Account</b>
                    <br><br>
                    <strong>{{ $user->name }}</strong> <span></span>

                    <p style="font-size: 0.9em; color: gray; margin: 10px 0;">
                        👥 <b>{{ $user->followers()->count() }}</b> followers &nbsp;|&nbsp;
                        <b>{{ $user->following()->count() }}</b> following
                    </p>

                    <form action="{{ route('follow.toggle', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @if ($user->isFollowedByAuth())
                            <button type="submit"
                                style="background-color: #ff4d4d; color:white; border: none; padding: 6px 12px; cursor:pointer; border-radius: 4px;">
                                Unfollow
                            </button>
                        @else
                            <button type="submit"
                                style="background-color: #4CAF50; color:white; border: none; padding: 6px 12px; cursor:pointer; border-radius: 4px;">
                                Follow
                            </button>
                        @endif
                    </form>
                </div>
            @endforeach
        @endif

        <hr style="margin: 20px 0;">

        <h3>Postingan Threads</h3>
        @if (empty($query))
            <p style="color: #777; font-style: italic;">Masukkan kata kunci untuk mencari postingan.</p>
        @elseif($threadResults->isEmpty())
            <p>Tidak ada thread yang cocok dengan "{{ $query }}".</p>
        @else
            @foreach ($threadResults as $thread)
                <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 6px;">
                    <b>Thread Post</b>
                    <br><br>
                    <strong>{{ $thread->user->name ?? 'Anonymous' }}</strong> <span style="color: #777;"></span>
                    <p style="margin: 10px 0; line-height: 1.4;">{{ $thread->content }}</p>

                    @if (!empty($thread->community_or_topic))
                        <p style="margin: 5px 0 10px 0; font-size: 14px;">
                            <a href="{{ route('search') }}?query=%23{{ $thread->community_or_topic }}" style="color: blue; text-decoration: none; font-weight: bold;">
                                #{{ $thread->community_or_topic }}
                            </a>
                        </p>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <small style="color: #555;">💬 {{ $thread->replies_count ?? $thread->replies()->count() }}
                            Balasan</small>
                        <a href="{{ route('threads.show', $thread->id) }}">
                            <button type="button" style="cursor: pointer; padding: 4px 8px;">Lihat Detail &
                                Komentar</button>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

</body>

</html>