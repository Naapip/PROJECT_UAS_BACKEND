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
                                    <button type="button">[Follow]</button>
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