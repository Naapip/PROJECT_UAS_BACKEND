<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>

    <table border="1" width="100%" cellpadding="15">
        <tr>
            <td>
                
                <h2>Search User & Thread</h2>

                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="query" placeholder="Search..." value="{{ request('query') }}">
                    <button type="submit">Search</button>
                </form>
                @if($errors->any())
                  <div style="color: red; margin-top: 10px;">
                      @foreach($errors->all() as $error)
                        <small>⚠️ {{ $error }}</small>
                      @endforeach
                  </div>  
                @endif
                <hr>

                <h3>Users Results</h3>
                @if($userResults->isEmpty())
                    <p>Tidak ada user yang cocok dengan "{{ $query }}".</p>
                @else
                    @foreach($userResults as $user)
                        <table border="1" width="100%" cellpadding="10">
                            <tr>
                                <td>
                                    <b>User Account</b>
                                    <br><br>
                                    <strong>{{ $user->name }}</strong>
                                    <p>Email: {{ $user->email }}</p>

                                    <p style="font-size: 0.9em; color: gray;">
                                        👥 <b>{{ $user->followers()->count() }}</b> followers &nbsp;|&nbsp;
                                        <b>{{ $user->following()->count() }}</b> following
                                    </p>

                                    <form action="{{ route('follow.toggle', $user->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @if($user->isFollowedByAuth())
                                            <button type="submit" style="background-color: #ff4d4d; color:white; border: none; padding: 5px 10px; cursor:pointer;">
                                                Unfollow
                                            </button>
                                        @else
                                            <button type="submit" style="background-color: #4CAF50; color:white; border: none; padding: 5px 10px; cursor:pointer;">
                                                Follow
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        </table>
                        <br>
                    @endforeach
                @endif

                <hr>

                <h3>Postingan Threads</h3>
                @if($threadResults->isEmpty())
                    <p>Tidak ada thread yang cocok dengan "{{ $query }}".</p>
                @else  
                    @foreach($threadResults as $thread)
                        <table border="1" width="100%" cellpadding="10">
                            <tr>
                                <td>
                                    <b>Thread Post</b>
                                    <br><br>
                                    <strong>{{ $thread->user->name ?? 'Anonymous' }}</strong>
                                    <p>{{ $thread->content }}</p>
                                    
                                    <small>💬 {{ $thread->replies_count ?? 0 }} Balasan</small>
                                    &nbsp;|&nbsp;
                                    <a href="{{ route('threads.show', $thread->id) }}" style="text-decoration: none;">
                                        <button type="button">Lihat Detail & Komentar</button>
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <br>
                    @endforeach
                @endif

            </td>
        </tr>
    </table>

</body>
</html>