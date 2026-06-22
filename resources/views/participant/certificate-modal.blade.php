@extends('participant.layout')

@section('title', 'Sertifikat ' . $registration->event->title . ' - EventRize')

@section('content')
<!-- HEADER -->
<header class="participant-header compact">
    <a href="{{ route('participant.certificates') }}" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M19 12H5M12 19l-7-7 7-7"></path>
        </svg>
        <span>SERTIFIKAT</span>
    </a>
</header>

<section class="certificate-detail">
    <div class="certificate-preview-card">
        <div class="certificate-preview">
            @if($registration->event->certificate_template_path)
            <div class="participant-template-preview">
                <img src="{{ $registration->event->certificate_template_url }}" alt="Sertifikat {{ $registration->event->title }}">
                <strong style="top:{{ $registration->event->certificate_name_y ?? 47 }}%;font-size:clamp(18px, {{ max(18, round(($registration->event->certificate_name_size ?? 42) * .7)) }}px, 48px);color:{{ $registration->event->certificate_name_color ?? '#1e293b' }}">{{ $registration->name }}</strong>
            </div>
            @else
            <div class="certificate-doc">
                <div class="certificate-doc-header">
                    <img src="{{ asset('images/logo.png') }}" alt="EventRize" class="certificate-doc-logo">
                    <h2>SERTIFIKAT</h2>
                    <p>Penghargaan Partisipasi</p>
                </div>
                <div class="certificate-doc-body">
                    <p>Diberikan kepada</p>
                    <h3>{{ Auth::user()->name }}</h3>
                    <p>Atas partisipasinya sebagai peserta dalam</p>
                    <h4>{{ $registration->event->title }}</h4>
                    <p>yang diselenggarakan oleh <strong>EventRize</strong></p>
                    <p>pada tanggal {{ $registration->event->display_date }}</p>
                </div>
                <div class="certificate-doc-footer">
                    <div class="certificate-stamp">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="36" stroke="#3b82f6" stroke-width="2" stroke-dasharray="4 4"/>
                            <circle cx="40" cy="40" r="28" stroke="#3b82f6" stroke-width="1"/>
                            <text x="40" y="36" text-anchor="middle" fill="#3b82f6" font-size="10" font-weight="bold">EVENTRIZE</text>
                            <text x="40" y="50" text-anchor="middle" fill="#3b82f6" font-size="8">VERIFIED</text>
                        </svg>
                    </div>
                    <div class="certificate-signature">
                        <p>Abdillah</p>
                        <span>Ketua Penyelenggara</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="certificate-info-card">
        <h2>Detail Sertifikat</h2>
        <div class="info-row">
            <span>Event</span>
            <strong>{{ $registration->event->title }}</strong>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <strong>{{ $registration->event->display_date }}</strong>
        </div>
        <div class="info-row">
            <span>Lokasi</span>
            <strong>{{ $registration->event->location }}</strong>
        </div>
        <div class="info-row">
            <span>Penyelenggara</span>
            <strong>EventRize</strong>
        </div>
        <div class="info-row">
            <span>Nomor Sertifikat</span>
            <strong>{{ strtoupper(substr($registration->certificate_token, 0, 12)) }}</strong>
        </div>

        <a href="{{ route('certificates.download', $registration->id) }}" class="btn-primary btn-download">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Unduh Sertifikat
        </a>
    </div>
</section>
@endsection
