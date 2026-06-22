@extends('participant.layout')

@section('title', $event->title . ' - EventRize')

@section('content')
<!-- HEADER -->
<header class="participant-header compact">
    <a href="{{ route('participant.events') }}" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M19 12H5M12 19l-7-7 7-7"></path>
        </svg>
        <span>DETAIL EVENT</span>
    </a>
</header>

<section class="event-detail-layout">
    <div class="event-detail-left">
        <div class="event-detail-image">
            @if($event->flyer_path)
                <img src="{{ asset('storage/' . $event->flyer_path) }}" alt="{{ $event->title }}">
            @elseif($event->image)
                <div class="event-image-bg img-{{ $event->image }}"></div>
            @else
                <div class="event-image-bg placeholder-gradient"></div>
            @endif
        </div>

        <div class="event-detail-main">
            <div class="event-detail-title-row">
                <div>
                    <h1>{{ $event->title }}</h1>
                    <p class="event-speaker">{{ $event->speaker }}</p>
                </div>
                @if($event->category)
                    <span class="category-badge">{{ $event->category }}</span>
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
                    {{ $event->display_date }}
                </span>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $event->location }}
                </span>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    {{ $event->time ?? '10.00 - 12.00' }}
                </span>
            </div>

            <div class="event-info">
                <h2>Informasi Event</h2>
                <p>{{ $event->description }}</p>

                @if(count($event->materials) > 0)
                    <h3>Materi yang akan dibahas:</h3>
                    <ul class="materials-list">
                        @foreach($event->materials as $material)
                            <li>{{ $material }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="event-detail-right">
        <div class="ticket-card">
            <h2>Tiket</h2>
            <div class="ticket-price">{{ $event->formatted_price }}</div>
            <div class="ticket-quota">
                Kuota tersisa <span class="quota-badge">{{ $event->remaining_quota }} Orang</span>
            </div>

            @if($registration)
                <div class="registration-status-badge {{ $registration->status }}">
                    Status: {{ str_replace('_', ' ', ucfirst($registration->status)) }}
                </div>
                @if($registration->status === 'ditolak')
                    <p class="rejection-reason">Alasan: {{ $registration->rejection_reason ?? 'Tidak disebutkan' }}</p>
                    <a href="{{ route('participant.tickets') }}" class="btn-outline">Lihat di Tiket Saya</a>
                @else
                    <a href="{{ route('participant.tickets') }}" class="btn-outline">Lihat di Tiket Saya</a>
                @endif
            @elseif($event->status !== 'aktif')
                <button class="btn-primary disabled" disabled>Event Tidak Tersedia</button>
            @elseif($event->remaining_quota <= 0)
                <button class="btn-primary disabled" disabled>Kuota Penuh</button>
            @elseif($event->price > 0)
                <form action="{{ route('participant.events.register', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="payment-info">
                        <p>Harga tiket: <strong>{{ $event->formatted_price }}</strong></p>
                        <p class="payment-instruction">Silakan transfer ke rekening <strong>EventRize</strong> dan unggah bukti pembayaran.</p>
                        <div class="payment-upload">
                            <label for="payment_proof">Unggah Bukti Pembayaran</label>
                            <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Daftar & Bayar</button>
                </form>
            @else
                <form action="{{ route('participant.events.register', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary">Daftar Sekarang</button>
                </form>
            @endif
        </div>

        <div class="info-card organizer-card">
            <h3>Penyelenggara</h3>
            <div class="organizer-name">
                <img src="{{ asset('images/logo.png') }}" alt="EventRize" class="organizer-logo">
                <span>EventRize</span>
            </div>
            <p>Penyelenggara Terverifikasi</p>
        </div>

        <div class="info-card help-card">
            <h3>Butuh bantuan?</h3>
            <p>Hubungi panitia jika ada kendala</p>
            <div class="help-phone">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                {{ $event->contact_phone ?? '081352637393' }}
            </div>
        </div>
    </div>
</section>
@endsection
