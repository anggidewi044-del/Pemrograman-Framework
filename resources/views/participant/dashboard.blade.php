@push('styles')
<style>
    :root {
        --sidebar-width: 482px;
    }

    body {
        background: #d8dff9 !important;
    }

    .participant-container {
        display: flex !important;
        width: 100vw !important;
        min-height: 100vh !important;
        background: #d8dff9 !important;
    }

    .participant-sidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 482px !important;
        height: 100vh !important;
        padding: 49px 59px 37px !important;
        background: #edf4ff !important;
        border-right: 1px solid rgba(77, 127, 232, 0.5) !important;
    }

    .participant-main {
        width: calc(100vw - 482px) !important;
        min-height: 100vh !important;
        margin-left: 482px !important;
        padding: 54px 54px 80px 69px !important;
        background: #d8dff9 !important;
    }

    .participant-main > .dashboard-content {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
    }

    .dashboard-content .participant-header {
        display: flex !important;
        justify-content: flex-end !important;
        margin-bottom: 32px !important;
        padding: 0 !important;
    }

    .dashboard-content .search-bar {
        width: 453px !important;
        max-width: 453px !important;
        height: 43px !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: #ffffff !important;
        box-shadow: none !important;
    }

    .dashboard-content .hero-banner {
        width: 100% !important;
        min-height: 248px !important;
        padding: 0 !important;
        margin: 0 !important;
        display: block !important;
        position: relative !important;
        overflow: hidden !important;
        border-radius: 10px !important;
        background: #8e9db2 !important;
    }

    .dashboard-content .hero-image {
        position: absolute !important;
        inset: 0 !important;
        max-width: none !important;
        opacity: 1 !important;
        z-index: 0 !important;
    }

    .dashboard-content .hero-image img {
        width: 100% !important;
        height: 100% !important;
        max-width: none !important;
        object-fit: cover !important;
        filter: none !important;
    }

    .dashboard-content .hero-banner::before {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        z-index: 1 !important;
        background: linear-gradient(
            90deg,
            rgba(220, 228, 243, 0.93) 0%,
            rgba(220, 228, 243, 0.86) 40%,
            rgba(220, 228, 243, 0.46) 59%,
            rgba(220, 228, 243, 0.08) 78%,
            rgba(220, 228, 243, 0) 100%
        ) !important;
    }

    .dashboard-content .hero-content {
        position: relative !important;
        z-index: 2 !important;
        max-width: 530px !important;
        padding: 39px 25px !important;
    }

    .dashboard-content .hero-banner h1 {
        margin: 0 0 6px !important;
        color: #172b4d !important;
        font-size: 33px !important;
        font-weight: 800 !important;
        line-height: 1.18 !important;
        letter-spacing: -1.1px !important;
    }

    .dashboard-content .hero-banner p {
        margin: 0 0 17px !important;
        color: #2a3d5f !important;
        font-size: 11px !important;
        opacity: 1 !important;
    }

    .dashboard-content .btn-primary {
        min-width: 120px !important;
        min-height: 33px !important;
        padding: 0 19px !important;
        border-radius: 10px !important;
        background: #2461dc !important;
        color: #ffffff !important;
        font-size: 11px !important;
        font-weight: 800 !important;
    }

    .dashboard-content .popular-events {
        margin-top: 19px !important;
    }

    .dashboard-content .section-header {
        margin: 0 10px 15px !important;
    }

    .dashboard-content .section-header h2 {
        font-size: 21px !important;
        font-weight: 800 !important;
        color: #10334d !important;
    }

    .dashboard-content .view-all {
        color: #2161e2 !important;
        font-size: 18px !important;
        font-weight: 800 !important;
    }

    .dashboard-content .event-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 10px !important;
        width: 100% !important;
    }

    .dashboard-content .event-card {
        min-height: 426px !important;
        border-radius: 17px !important;
        background: #a7b6c9 !important;
        box-shadow: none !important;
        overflow: hidden !important;
    }

    .dashboard-content .event-card-link {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
    }

    .dashboard-content .event-image {
        height: 225px !important;
        padding: 15px 10px 0 !important;
        background: transparent !important;
        overflow: visible !important;
    }

    .dashboard-content .event-image img,
    .dashboard-content .event-image-bg {
        width: 100% !important;
        height: 100% !important;
        border-radius: 15px !important;
        object-fit: cover !important;
    }

    .dashboard-content .event-body {
        display: flex !important;
        flex: 1 !important;
        flex-direction: column !important;
        padding: 20px 15px 22px !important;
    }

    .dashboard-content .event-body h3 {
        margin: 0 0 9px !important;
        color: #152947 !important;
        font-size: 21px !important;
        font-weight: 800 !important;
        line-height: 1.27 !important;
    }

    .dashboard-content .event-speaker {
        margin: 0 0 11px !important;
        color: #003c5d !important;
        font-size: 16px !important;
        font-weight: 700 !important;
    }

    .dashboard-content .event-meta {
        margin-top: auto !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        color: #003c5d !important;
        font-size: 16px !important;
        font-weight: 700 !important;
    }

    .dashboard-content .event-meta span {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        color: #003c5d !important;
        font-size: 16px !important;
    }

    .dashboard-content .event-meta svg {
        width: 21px !important;
        height: 21px !important;
    }

    .dashboard-content .event-price {
        display: none !important;
    }

    @media (max-width: 1200px) {
        .participant-sidebar {
            width: 320px !important;
            padding: 38px 28px 30px !important;
        }

        .participant-main {
            width: calc(100vw - 320px) !important;
            margin-left: 320px !important;
            padding: 38px 32px 60px !important;
        }

        .dashboard-content .event-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }

    @media (max-width: 900px) {
        .participant-sidebar {
            position: static !important;
            width: 100% !important;
            height: auto !important;
        }

        .participant-container {
            display: block !important;
        }

        .participant-main {
            width: 100% !important;
            margin-left: 0 !important;
            padding: 25px 18px 50px !important;
        }

        .dashboard-content .event-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    @media (max-width: 560px) {
        .dashboard-content .event-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@extends('participant.layout')

@section('title', 'Dashboard - EventRize')

@section('content')
<div class="dashboard-content">

    <!-- HEADER -->
    <header class="participant-header">
        <div class="search-bar">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>

            <form action="{{ route('participant.events') }}" method="GET">
                <input type="search" name="search" placeholder="Cari event" aria-label="Cari event">
            </form>
        </div>
        @include('participant.partials.notifications')
    </header>

    <!-- HERO -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1>TEMUKAN<br>EVENT MENARIK<br>DI SEKITARMU</h1>
            <p>Ikuti Event Favoritmu dan Dapatkan Pengalaman Bersama Kami!</p>

            <a href="{{ route('participant.events') }}" class="btn-primary">
                Explore Event
            </a>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/hima.png') }}" alt="Event banner">
        </div>
    </section>

    <!-- POPULAR EVENTS -->
    <section class="popular-events">
        <div class="section-header">
            <h2>Event Populer</h2>

            <a href="{{ route('participant.events') }}" class="view-all">
                view all
            </a>
        </div>

        <div class="event-grid">
            @forelse($events->take(6) as $event)
                <article class="event-card">
                    <a href="{{ route('participant.events.detail', $event->id) }}" class="event-card-link">

                        <div class="event-image">
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

                        <div class="event-body">
                            <h3>{{ $event->title }}</h3>

                            @if($event->speaker)
                                <p class="event-speaker">{{ $event->speaker }}</p>
                            @endif

                            <div class="event-meta">
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
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
                            </div>

                            <div class="event-price {{ $event->price > 0 ? 'paid' : 'free' }}">
                                {{ $event->formatted_price }}
                            </div>
                        </div>

                    </a>
                </article>
            @empty
                <p class="empty-message">Belum ada event populer saat ini.</p>
            @endforelse
        </div>
    </section>

</div>
@endsection
