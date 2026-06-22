<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat & Analitik Aktivitas</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 25px; max-width: 850px; margin: 0 auto; background-color: #f8fafc; color: #0f172a; }
        h2 { margin-bottom: 5px; }
        .subtitle { color: #64748b; font-size: 14px; margin-top: 0; margin-bottom: 25px; }
        
        /* Desain Kotak Metrik*/
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); text-align: center; }
        .stat-label { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .stat-value { font-size: 22px; font-weight: bold; color: #0284c7; }

        /* Desain Filter Pills*/
        .filter-box { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; background: #ffffff; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .filter-label { font-size: 13px; font-weight: bold; color: #475569; margin-right: 5px; }
        .filter-pill { padding: 6px 14px; border-radius: 20px; background: #f1f5f9; color: #475569; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; border: 1px solid transparent; }
        .filter-pill:hover { background: #e2e8f0; }
        .filter-pill.active { background: #0ea5e9; color: white; font-weight: 600; box-shadow: 0 2px 4px rgba(14, 165, 233, 0.25); }

        /* Komponen standar */
        .card { background: #ffffff; border: 1px solid #e2e8f0; padding: 16px; margin-bottom: 12px; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
        .alert { padding: 12px; background-color: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0; }
        input[type="text"] { width: 75%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; }
        input[type="text"]:focus { border-color: #0ea5e9; }
        button { padding: 9px 18px; cursor: pointer; background: #0f172a; color: white; border: none; border-radius: 6px; font-weight: 500; }
        button:hover { background: #334155; }
    </style>
</head>
<body>

    <h2>Riwayat Aktivitas Pengguna</h2>
    <p class="subtitle">Memantau jejak interaksi dan log sistem secara real-time</p>

    @if (session('success'))
        <div class="alert"><b>Sukses:</b> {{ session('success') }}</div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Aktivitas</div>
            <div class="stat-value">{{ $totalActivities }} Aksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tindakan Favorit</div>
            <div class="stat-value" style="color: #10b981; font-size: 18px;">{{ $favoriteActivity }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Terakhir Aktif</div>
            <div class="stat-value" style="color: #8b5cf6; font-size: 17px;">{{ $lastActive }}</div>
        </div>
    </div>

    <div class="card" style="background: #f1f5f9; border-style: dashed;">
        <form action="{{ url('/activities') }}" method="POST" style="display: flex; gap: 10px;">
            @csrf
            <input type="text" name="description" placeholder="Simulasi: Ketik aktivitas yang dilakukan user..." required>
            <button type="submit">+ Rekam Log</button>
        </form>
    </div>

    <div class="filter-box">
        <span class="filter-label">Filter Log:</span>
        <a href="{{ url('/activities?filter=all') }}" class="filter-pill {{ $currentFilter == 'all' ? 'active' : '' }}">
            Semua ({{ $totalActivities }})
        </a>

        @foreach($filterTypes as $type)
            <a href="{{ url('/activities?filter=' . $type) }}" class="filter-pill {{ $currentFilter == $type ? 'active' : '' }}">
                {{ ucwords(str_replace('_', ' ', $type)) }}
            </a>
        @endforeach
    </div>

    <div class="activity-history-container">
        @forelse ($activities as $activity)
            @include('activities.activity-item', ['activity' => $activity])
        @empty
            <div class="card" style="text-align: center; color: #94a3b8; padding: 30px;">
                <i>Tidak ada rekaman aktivitas yang sesuai dengan filter ini.</i>
            </div>
        @endforelse
    </div>

    @if($totalActivities > 0)
        <form action="{{ url('/activities/clear') }}" method="POST" style="margin-top: 30px; text-align: center;">
            @csrf @method('DELETE')
            <button type="submit" style="background: #ef4444; font-size: 12px;">⚠️ Bersihkan Seluruh Riwayat</button>
        </form>
    @endif

</body>
</html>