@extends('participant.layout')

@section('title', 'Detail Tiket - EventRize')

@section('content')
<!-- HEADER -->
<header class="participant-header compact">
    <a href="{{ route('participant.tickets') }}" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M19 12H5M12 19l-7-7 7-7"></path>
        </svg>
        <span>DETAIL TIKET</span>
    </a>
</header>

<section class="ticket-detail-layout">
    <div class="ticket-detail-left">
        <div class="ticket-event-image">
            @if($registration->event->flyer_path)
                <img src="{{ $registration->event->flyer_url }}" alt="{{ $registration->event->title }}">
            @elseif($registration->event->image)
                <div class="event-image-bg img-{{ $registration->event->image }}"></div>
            @else
                <div class="event-image-bg placeholder-gradient"></div>
            @endif
        </div>

        <div class="ticket-event-main">
            <div class="ticket-event-title-row">
                <div>
                    <h1>{{ $registration->event->title }}</h1>
                    <p class="event-speaker">{{ $registration->event->speaker }}</p>
                </div>
                @if($registration->event->category)
                    <span class="category-badge">{{ $registration->event->category }}</span>
                @endif
            </div>

            <div class="event-meta-list">
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {{ $registration->event->display_date }}
                </span>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $registration->event->location }}
                </span>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    {{ $registration->event->time ?? '10.00 - 12.00' }}
                </span>
            </div>

            <div class="event-info">
                <h2>Informasi Event</h2>
                <p>{{ $registration->event->description }}</p>

                @if(count($registration->event->materials) > 0)
                    <h3>Materi yang akan dibahas:</h3>
                    <ul class="materials-list">
                        @foreach($registration->event->materials as $material)
                            <li>{{ $material }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="ticket-detail-right">
        @if($registration->event->isOffline)
            <div class="ticket-code-card">
                <h2>QR Check-in Offline</h2>
                <div id="qrcode" class="qr-code" data-code="{{ $registration->qr_code }}"></div>
                <div class="ticket-code">{{ $ticketCode }}</div>
                <p>{{ $registration->event->attendance_open ? 'Sesi presensi dibuka. Tunjukkan QR ini kepada penyelenggara di lokasi.' : 'Tunjukkan QR ini ketika penyelenggara membuka sesi presensi.' }}</p>
            </div>
        @else
            <div class="ticket-code-card online-checkin-card">
                <h2>Check-in Online</h2>
                @if($registration->status === 'hadir')
                    <div class="online-checkin-success">✓ Kehadiran tercatat</div>
                    <p>Anda melakukan check-in pada {{ $registration->check_in_time }}.</p>
                @elseif($registration->event->attendance_open && $registration->event->status === 'aktif')
                    <p>Sesi presensi telah dibuka. Klik tombol berikut untuk mencatat kehadiran Anda.</p>
                    <form action="{{ route('participant.tickets.check-in', $registration->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary online-checkin-button">Check-in Sekarang</button>
                    </form>
                @else
                    <div class="online-checkin-waiting">Sesi presensi belum dibuka</div>
                    <p>Tombol check-in akan tersedia setelah penyelenggara membuka presensi.</p>
                @endif
            </div>
        @endif

        @if($registration->ticket_access_granted && $registration->event->isOnline)
            <div class="info-card zoom-card">
                <h3>Akses Online</h3>
                <a href="{{ $registration->event->zoom_link }}" target="_blank" class="btn-primary">Buka Zoom</a>
                @if($registration->event->zoom_info)
                    <p class="zoom-info">{{ $registration->event->zoom_info }}</p>
                @endif
            </div>
        @elseif($registration->ticket_access_granted && $registration->event->isOffline)
            <div class="info-card access-card">
                <h3>Lokasi Event</h3>
                <p>{{ $registration->event->location }}</p>
            </div>
        @elseif(!$registration->ticket_access_granted)
            <div class="info-card access-card pending">
                <h3>Akses Tiket</h3>
                <p>Akses akan diberikan setelah pendaftaran disetujui.</p>
            </div>
        @endif

        <div class="info-card status-event-card">
            <h3>Status Event</h3>
            <div class="status-value {{ $registration->event->status }}">
                {{ ucfirst($registration->event->status) }}
            </div>
        </div>

        <div class="info-card status-kehadiran-card">
            <h3>Status Kehadiran</h3>
            <div class="status-value {{ $registration->status }}">
                {{ ucfirst($registration->status) }}
            </div>
            @if($registration->check_in_time)
                <p>Check-in: {{ $registration->check_in_time }}</p>
            @endif
        </div>

        @if($registration->ticket_access_granted && in_array($registration->status, ['terdaftar', 'hadir'], true))
            <div class="info-card participant-feedback-card">
                <h3>Ulasan Event</h3>
                <p>Pendaftaran Anda telah dikonfirmasi. Bagikan pengalaman atau masukan untuk penyelenggara.</p>
                <form action="{{ route('participant.tickets.feedback', $registration->id) }}" method="POST">
                    @csrf
                    <label>Rating
                        <select name="rating" required>
                            @for($rating = 5; $rating >= 1; $rating--)
                                <option value="{{ $rating }}" {{ old('rating', $feedback?->rating) == $rating ? 'selected' : '' }}>{{ str_repeat('★', $rating) }} ({{ $rating }}/5)</option>
                            @endfor
                        </select>
                    </label>
                    <label>Komentar
                        <textarea name="comment" rows="4" minlength="5" maxlength="1000" required placeholder="Ceritakan pengalaman Anda...">{{ old('comment', $feedback?->comment) }}</textarea>
                    </label>
                    <button type="submit" class="btn-primary">{{ $feedback ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}</button>
                </form>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qrContainer = document.getElementById('qrcode');
        if (!qrContainer) return;
        const code = qrContainer.getAttribute('data-code');
        if (code) {
            new QRCode(qrContainer, {
                text: code,
                width: 180,
                height: 180,
                colorDark: '#1e293b',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M
            });
        }
    });
</script>
@endpush
