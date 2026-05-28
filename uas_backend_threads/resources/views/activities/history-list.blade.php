@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Aktivitas Pengguna</h2>
    
    <div class="activity-history-container mt-4">
        @forelse ($activities as $activity)
            {{-- Memanggil komponen item individual --}}
            @include('activities.activity-item', ['activity' => $activity])
        @empty
            <div class="alert alert-info">
                Belum ada rekam aktivitas untuk akun Anda.
            </div>
        @endforelse
    </div>
</div>
@endsection