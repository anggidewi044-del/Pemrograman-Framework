@extends('participant.layout')

@section('title', 'Tiket Saya - EventRize')

@section('content')
<div class="tickets-page">

    <!-- TOP BAR -->
    <header class="tickets-topbar">
        <h1>Tiket Saya</h1>

        <div class="tickets-search">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>

            <form action="{{ route('participant.tickets') }}" method="GET">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="search" name="search" placeholder="Cari tiket berdasarkan event" value="{{ $search }}" aria-label="Cari tiket">
            </form>
        </div>

        @include('participant.partials.notifications')
    </header>

    <!-- TABS -->
    <section class="ticket-tabs">
        @foreach($tabs as $t)
            <a
                href="{{ route('participant.tickets', ['tab' => $t, 'search' => $search]) }}"
                class="ticket-tab {{ $tab === $t ? 'active' : '' }}"
            >
                {{ $t }}
            </a>
        @endforeach
    </section>

    <!-- TICKETS LIST -->
    <section class="tickets-list">
        @forelse($registrations as $registration)
            @php
                $event = $registration->event;

                $eventStatus = ucfirst($event->status ?? 'Selesai');

                $attendanceRaw = data_get($registration, 'attendance_status')
                    ?? data_get($registration, 'attendance')
                    ?? data_get($registration, 'status');

                $attendanceText = match($attendanceRaw) {
                    'hadir' => 'Hadir',
                    'absent' => 'Tidak Hadir',
                    'tidak_hadir' => 'Tidak Hadir',
                    'cancelled' => 'Tidak Hadir',
                    default => in_array($event->status, ['selesai', 'Selesai']) ? 'Hadir' : '-'
                };

                $attendanceClass = $attendanceText === 'Tidak Hadir'
                    ? 'not-present'
                    : ($attendanceText === 'Hadir' ? 'present' : 'pending');
            @endphp

            <article class="ticket-row-card">

                <div class="ticket-row-image">
                    @if($event->flyer_path)
                        <img
                            src="{{ $event->flyer_url }}"
                            alt="{{ $event->title }}"
                        >
                    @elseif($event->image)
                        <div class="event-image-bg img-{{ $event->image }}"></div>
                    @else
                        <div class="event-image-bg placeholder-gradient"></div>
                    @endif
                </div>

                <div class="ticket-row-info">
                    <h3>{{ $event->title }}</h3>

                    <div class="ticket-meta">
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
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.14 2 5 5.14 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86-3.14-7-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/>
                            </svg>

                            {{ $event->location }}
                        </span>

                        <span>
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 1 0 .01 0ZM13 12.1l3.6 2.15-.9 1.48L11 13V6h2v6.1Z"/>
                            </svg>

                            {{ $event->time ?? '10.00 - 12.00' }}
                        </span>
                    </div>
                </div>

                <div class="ticket-status-col">
                    <h4>Status<br>Event</h4>

                    <span class="ticket-event-status">
                        {{ $eventStatus }}
                    </span>
                </div>

                <div class="ticket-attendance-col">
                <h4>Kehadiran</h4>

    <div class="ticket-attendance {{ $attendanceClass }}">
        @if($attendanceText === 'Hadir')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 11.2A8 8 0 1 1 16.2 4"></path>
                <path d="M8 11.5l2.6 2.6L20 4.8"></path>
            </svg>
        @elseif($attendanceText === 'Tidak Hadir')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="8"></circle>
                <line x1="9" y1="9" x2="15" y2="15"></line>
                <line x1="15" y1="9" x2="9" y2="15"></line>
            </svg>
        @else
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="8"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        @endif

        <span>{{ $attendanceText }}</span>
    </div>
</div>

                <div class="ticket-action-col">
                    @if(in_array($registration->status, ['menunggu_verifikasi_pembayaran', 'ditolak']) && $event->price > 0)
                        <form
                            action="{{ route('participant.events.register', $event->id) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="reupload-form"
                        >
                            @csrf
                            <input
                                type="file"
                                name="payment_proof"
                                accept="image/*"
                                required
                                onchange="this.form.submit()"
                            >

                            <button
                                type="button"
                                class="ticket-detail-btn"
                                onclick="this.previousElementSibling.click()"
                            >
                                Unggah Ulang
                            </button>
                        </form>
                    @else
                        <a
                            href="{{ route('participant.tickets.detail', $registration->id) }}"
                            class="ticket-detail-btn"
                        >
                            Lihat Detail
                        </a>
                    @endif
                </div>

            </article>
        @empty
            <div class="ticket-empty-state">
                <p>Belum ada tiket pada kategori ini.</p>

                <a href="{{ route('participant.events') }}" class="ticket-detail-btn">
                    Jelajahi Event
                </a>
            </div>
        @endforelse
    </section>

</div>
@endsection
