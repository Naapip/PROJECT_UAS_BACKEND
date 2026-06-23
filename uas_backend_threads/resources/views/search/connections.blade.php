<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertemanan</title>
</head>

<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        <h2>Jaringan Sosial</h2>
        <a href="{{ route('search') }}">[ Kembali ke Pencarian ]</a>
        <hr style="margin: 15px 0;">

        <h3>Pengikut Saya (Followers)</h3>
        @if ($followers->isEmpty())
            <p style="color: #777; font-style: italic;">Belum ada orang yang mengikuti Anda</p>
        @else
            @foreach ($followers as $follower)
                <div style="border: 1px solid #ccc; padding: 12px; margin-bottom: 10px; border-radius: 4px;">
                    <p style="margin: 0 0 5px 0;"><strong>{{ $follower->name }}</strong> <span
                            style="color: #555;">(@{{ $follower - > username }})</span></p>
                    <small style="color: #777;">{{ $follower->email }}</small>
                </div>
            @endforeach
        @endif

        <hr style="margin: 20px 0;">

        <h3>Orang Yang Saya Ikuti (Following)</h3>
        @if ($following->isEmpty())
            <p style="color: #777; font-style: italic;">Anda belum mengikuti siapa pun</p>
        @else
            @foreach ($following as $follow)
                <div
                    style="border: 1px solid #ccc; padding: 12px; margin-bottom: 10px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ $follow->name }}</strong> <span style="color: #555;">(@{{ $follow - > username }})</span>
                        <br>
                        <small style="color: #777;">{{ $follow->email }}</small>
                    </div>

                    <form action="{{ route('follow.toggle', $follow->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit"
                            style="cursor: pointer; background-color: #ff4d4d; color: white; border: none; padding: 4px 8px; border-radius: 4px;">
                            Unfollow
                        </button>
                    </form>
                </div>
            @endforeach
        @endif

    </div>
</body>

</html>
