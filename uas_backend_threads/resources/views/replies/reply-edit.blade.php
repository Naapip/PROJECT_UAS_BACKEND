<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Komentar</title>
</head>
<body>

    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
        <h2>Edit Komentar Anda</h2>
        
        @if(session('error'))
            <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
        @endif

        <p>Mengedit komentar sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->username }})</p>

        <form action="{{ route('reply.update', $reply->id) }}" method="POST">
            @csrf
            @method('PUT') <div style="margin-bottom: 15px;">
                <textarea name="content" rows="4" style="width: 100%; padding: 10px; border-radius: 4px;" required>{{ $reply->content }}</textarea>
            </div>

            <button type="submit" style="padding: 8px 15px; background-color: blue; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Simpan Perubahan
            </button>
            
            <a href="{{ route('threads.show', $reply->thread_id) }}" style="margin-left: 10px; color: #555; text-decoration: none;">
                Batal
            </a>
        </form>
    </div>

</body>
</html>