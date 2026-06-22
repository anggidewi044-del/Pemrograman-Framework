<div class="participant-notification" data-notification>
    <button type="button" class="participant-notification-button" data-notification-toggle aria-label="Notifikasi" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22ZM18 16v-5a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z"/>
        </svg>
        @if($participantNotifications->isNotEmpty())
            <span class="participant-notification-count">{{ $participantNotifications->count() }}</span>
        @endif
    </button>

    <div class="participant-notification-menu" data-notification-menu hidden>
        <div class="participant-notification-header">
            <strong>Notifikasi</strong>
            <span>{{ $participantNotifications->count() }} terbaru</span>
        </div>
        <div class="participant-notification-list">
            @forelse($participantNotifications as $notification)
                <a href="{{ $notification['url'] }}" class="participant-notification-item {{ $notification['type'] }}">
                    <span class="participant-notification-dot"></span>
                    <span>
                        <strong>{{ $notification['title'] }}</strong>
                        <small>{{ $notification['message'] }}</small>
                        <time>{{ $notification['time']?->locale('id')->diffForHumans() }}</time>
                    </span>
                </a>
            @empty
                <div class="participant-notification-empty">Belum ada notifikasi.</div>
            @endforelse
        </div>
    </div>
</div>
