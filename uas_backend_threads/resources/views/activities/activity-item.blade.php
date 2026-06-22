<div class="card">
    <h4 style="margin: 0 0 5px 0;">{{ ucwords(str_replace('_', ' ', $activity->type)) }}</h4>
    <p style="margin: 0 0 10px 0;">{{ $activity->description }}</p>
    <small style="color: #6c757d;">
        Waktu: {{ $activity->created_at->format('d M Y, H:i') }}
    </small>
</div>