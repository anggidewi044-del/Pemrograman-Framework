@extends('participant.layout')

@section('title', 'Sertifikat - EventRize')

@section('content')
<div class="certificates-page">

    <!-- TOP BAR -->
    <header class="certificates-topbar">
        <h1>Sertifikat</h1>

        <div class="certificates-search">
            <svg class="certificates-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>

            <form action="{{ route('participant.certificates') }}" method="GET">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="search" name="search" placeholder="Cari sertifikat berdasarkan event" value="{{ $search }}" aria-label="Cari sertifikat">
            </form>
        </div>

        @include('participant.partials.notifications')
    </header>

    <!-- TABS -->
    <section class="certificate-tabs">
        @foreach($tabs as $t)
            <a
                href="{{ route('participant.certificates', ['tab' => $t, 'search' => $search]) }}"
                class="certificate-tab {{ $tab === $t ? 'active' : '' }}"
            >
                {{ $t }}
            </a>
        @endforeach
    </section>

    <!-- CERTIFICATES LIST -->
    <section class="certificate-list-layout">
        @forelse($registrations as $registration)
            @php
                $event = $registration->event;

                $eventStatus = ucfirst($event->status ?? 'selesai');

                $attendanceStatus = strtolower($registration->status ?? '');

                $isPresent = $attendanceStatus === 'hadir';

                $isAbsent = in_array($attendanceStatus, [
                    'absent',
                    'tidak_hadir',
                    'ditolak',
                    'cancelled'
                ]);

                $canClaim = $isPresent
                    && $registration->certificate_token
                    && $event->certificate_template_path
                    && $event->certificate_generated_at;

                $isProcessing = $isPresent && !$canClaim;

                $attendanceText = $isPresent
                    ? 'Hadir'
                    : ($isAbsent ? 'Tidak Hadir' : 'Belum Hadir');

                $attendanceClass = $isPresent
                    ? 'present'
                    : ($isAbsent ? 'absent' : 'pending');
            @endphp

            <article class="certificate-row-card">

                <!-- EVENT IMAGE -->
                <div class="certificate-row-image">
                    @if($event->flyer_path)
                        <img
                            src="{{ asset('storage/' . $event->flyer_path) }}"
                            alt="{{ $event->title }}"
                        >
                    @elseif($event->image)
                        <div class="event-image-bg img-{{ $event->image }}"></div>
                    @else
                        <div class="event-image-bg placeholder-gradient"></div>
                    @endif
                </div>

                <!-- EVENT INFORMATION -->
                <div class="certificate-row-info">
                    <h3>{{ $event->title }}</h3>

                    <div class="certificate-row-meta">
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

                <!-- EVENT STATUS -->
                <div class="certificate-status-column">
                    <h4>Status<br>Event</h4>

                    <span class="certificate-event-status">
                        {{ $eventStatus }}
                    </span>
                </div>

                <!-- ATTENDANCE -->
                <div class="certificate-attendance-column">
                    <h4>Kehadiran</h4>

                    <div class="certificate-attendance {{ $attendanceClass }}">
                        @if($isPresent)
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M20 11.2A8 8 0 1 1 16.2 4"></path>
                                <path d="M8 11.5l2.6 2.6L20 4.8"></path>
                            </svg>
                        @elseif($isAbsent)
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

                <!-- ACTION -->
                <div class="certificate-action-column">
                    @if($canClaim)
                        <button
                            type="button"
                            class="certificate-claim-btn"
                            data-certificate-toggle="certificate-claim-{{ $registration->id }}"
                            aria-expanded="false"
                        >
                            Klaim Sertifikat
                        </button>
                    @elseif($isProcessing)
                        <button type="button" class="certificate-processing-btn" disabled>
                            Sedang Diproses
                        </button>
                    @else
                        <button type="button" class="certificate-unavailable-btn" disabled>
                            Tidak Dapat Klaim
                        </button>
                    @endif
                </div>

            </article>

            @if($canClaim)
                <section class="certificate-inline-claim" id="certificate-claim-{{ $registration->id }}" role="dialog" aria-modal="true" aria-labelledby="certificate-title-{{ $registration->id }}" hidden>
                    <div class="certificate-claim-dialog">
                        <button type="button" class="certificate-claim-close" data-certificate-close aria-label="Tutup sertifikat">&times;</button>
                        <h2 class="certificate-dialog-title">Sertifikat</h2>
                        <div class="certificate-inline-preview">
                            <div class="participant-template-preview">
                                <img src="{{ asset('storage/' . $event->certificate_template_path) }}" alt="Sertifikat {{ $event->title }}">
                                <strong style="top:{{ $event->certificate_name_y ?? 47 }}%;font-size:clamp(14px, {{ max(14, round(($event->certificate_name_size ?? 42) * .52)) }}px, 36px);color:{{ $event->certificate_name_color ?? '#1e293b' }}">{{ $registration->name }}</strong>
                            </div>
                        </div>

                        <div class="certificate-inline-description">
                            <h2 id="certificate-title-{{ $registration->id }}">{{ $event->title }}</h2>
                            <div class="certificate-dialog-date">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"></rect><path d="M8 2v4M16 2v4M3 10h18"></path></svg>
                                {{ $event->display_date }}
                            </div>
                            <p>Diselenggarakan oleh</p>
                            <strong class="certificate-organizer-name">EventRize</strong>
                            <small>Nomor: {{ strtoupper(substr($registration->certificate_token, 0, 12)) }}</small>
                            <a href="{{ route('certificates.download', $registration->id) }}" class="certificate-download-inline">Unduh Sertifikat</a>
                        </div>
                    </div>
                </section>
            @endif
        @empty
            <div class="certificate-empty-state">
                <p>Belum ada sertifikat pada kategori ini.</p>

                <a href="{{ route('participant.events') }}" class="certificate-claim-btn">
                    Jelajahi Event
                </a>
            </div>
        @endforelse
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-certificate-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.certificateToggle);
            const willOpen = target.hidden;

            document.querySelectorAll('.certificate-inline-claim').forEach((panel) => {
                panel.hidden = true;
            });
            document.querySelectorAll('[data-certificate-toggle]').forEach((toggle) => {
                toggle.setAttribute('aria-expanded', 'false');
                toggle.textContent = 'Klaim Sertifikat';
            });
            document.body.classList.remove('certificate-modal-open');

            if (willOpen) {
                target.hidden = false;
                document.body.classList.add('certificate-modal-open');
                button.setAttribute('aria-expanded', 'true');
                button.textContent = 'Tutup Sertifikat';
            }
        });
    });

    function closeCertificateModals() {
        document.querySelectorAll('.certificate-inline-claim').forEach((panel) => panel.hidden = true);
        document.querySelectorAll('[data-certificate-toggle]').forEach((toggle) => {
            toggle.setAttribute('aria-expanded', 'false');
            toggle.textContent = 'Klaim Sertifikat';
        });
        document.body.classList.remove('certificate-modal-open');
    }

    document.querySelectorAll('[data-certificate-close]').forEach((button) => {
        button.addEventListener('click', closeCertificateModals);
    });
    document.querySelectorAll('.certificate-inline-claim').forEach((overlay) => {
        overlay.addEventListener('click', (event) => {
            if (event.target === overlay) closeCertificateModals();
        });
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeCertificateModals();
    });
</script>
@endpush
