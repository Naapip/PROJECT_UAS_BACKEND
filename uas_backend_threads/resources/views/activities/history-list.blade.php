<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        .card { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .alert { padding: 10px; background-color: #d4edda; color: #155724; margin-bottom: 15px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        input[type="text"] { width: 70%; padding: 8px; }
        button { padding: 8px 15px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Riwayat Aktivitas Pengguna</h2>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="background-color: #f8f9fa;">
        <h4>Uji Tambah Aktivitas</h4>
        <form action="{{ url('/activities') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="description" placeholder="Ketik aktivitas baru di sini..." required>
                <button type="submit">Catat</button>
            </div>
        </form>
    </div>

    <hr>

    <div class="activity-history-container">
        @forelse ($activities as $activity)
            @include('activities.activity-item', ['activity' => $activity])
        @empty
            <p>Belum ada rekam aktivitas untuk akun Anda.</p>
        @endforelse
    </div>

    @if($activities->count() > 0)
        <form action="{{ url('/activities/clear') }}" method="POST" style="margin-top: 20px;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background-color: #dc3545; color: white; border: none;">Bersihkan Semua Riwayat</button>
        </form>
    @endif

</body>
</html>