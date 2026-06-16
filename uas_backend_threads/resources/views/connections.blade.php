<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar pertemanan</title>
</head>
<body>
    <table border="1" width="100%" cellpadding="15">
        <tr>
            <td>
                <h2>Jaringan Sosial</h2>
                <a href="{{route('scearh')}} >[ Kembali ke pencarian ]</a>
                <hr>

                <h3>Pengikut Saya (Followers)</h3>
                @if($followers->isEmpty())
                    <p>Belum ada orang yang mengikuti Anda</p>
                @else
                    @foreach($followers as $follower)
                        <table border="1" width="100%" cellpadding="10">
                            <tr>
                                <td>
                                    <p><strong>{{ $follower->name }}</strong></p>
                                    <p>{{ $follower->email }}</p>
                                </td>
                            </tr>
                        </table>
                    @endforeach 
                @endif
                <hr>
                <h3>Orang Yang Saya Ikuti (following)</h3>
                @if($following->isEmpty())
                    <p>Anda belum mengikuti siapa pun</p>
                @else
                    @foreach($following as $follow)
                        <table border="1" width="100%" cellpadding="10">
                            <tr>
                                <td>
                                    <strong>{{ $follow->name }}</strong> - {{ $follow->email }}
                                    <from action="{{ route(unffollow, $follow-id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit">[Unfollow]</button>
                                    </from>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                @endif
            </td>
        </tr>
    </table>
</body>
</html>