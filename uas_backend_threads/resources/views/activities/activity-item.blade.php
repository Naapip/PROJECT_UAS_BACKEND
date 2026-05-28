<div class="card mb-3">
    <div class="card-body">
        {{-- Memformat teks tipe aktivitas menjadi lebih rapi --}}
        <h5 class="card-title">{{ ucwords(str_replace('_', ' ', $activity->type)) }}</h5>
        <p class="card-text">{{ $activity->description }}</p>
        <small class="text-muted">
            Dilakukan pada: {{ $activity->created_at->format('d M Y, H:i') }}
            ({{ $activity->created_at->diffForHumans() }})
        </small>
    </div>
</div>