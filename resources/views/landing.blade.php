<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EventRize adalah platform pendaftaran event dan e-sertifikat otomatis untuk peserta, panitia, dan penyelenggara acara.">
    <title>EventRize - Aplikasi Pendaftaran Event & E-Sertifikat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <header class="site-header">
        <a href="{{ route('home') }}" class="brand" aria-label="EventRize Home">
        <img src="{{ asset('images/logo.png') }}"
         alt="EventRize Logo"
         class="brand-logo">
         <span>EVENTRIZE</span>
         </a>

        <nav class="main-nav" aria-label="Navigasi utama">
            <a href="#home">Home</a>
            <a href="#events">Events</a>
            <a href="#about">About</a>
        </nav>

        <a href="{{ route('login') }}" class="login-button">LOGIN</a>
    </header>

    <main>
        <!-- HERO SECTION -->
        <section id="home" class="hero-section">
            <div class="hero-content">
                <h1>Rayakan Event<br><span>Abadikan Pencapaian!</span></h1>
                <p class="hero-description">
                    platform manajemen event profesional yang memudahkan registrasi, check-in, hingga distribusi e-sertifikat otomatis secara instan.
                </p>
                <div class="hero-actions">
                    <a href="#events" class="primary-button">Explore Events</a>
                </div>
            </div>

            <!-- POSTER CARD COLLAGE -->
            <div class="poster-card-container">
            <img src="{{ asset('images/hima.png') }}"
            alt="Poster HIMAIF"
            class="hero-poster">
            </div>
        </section>

        <!-- EVENTS SECTION -->
        <section id="events" class="events-section">
            <div class="section-heading-container">
                <div class="section-heading">
                    <h2>Temukan Event Menarik</h2>
                    <p>Berbagai event menarik menunggumu untuk berkembang dan belajar bersama</p>
                </div>
                <a href="#all-events" class="view-all">View All Events</a>
            </div>

            <div class="event-grid">
                @forelse($events as $event)
                    <article class="event-card {{ $loop->first ? 'event-card-dark' : 'event-card-blue' }}">
                        <div class="event-top" @if($event->flyer_path) style="background:linear-gradient(rgba(8,30,54,.78),rgba(8,30,54,.92)),url('{{ $event->flyer_url }}') center/cover" @endif>
                            <span class="event-badge">{{ $event->category ?? ucfirst($event->event_type) }}</span>
                            <h3>{{ $event->title }}</h3>
                            <div class="event-meta-info">
                                <p class="event-detail">📅 {{ $event->display_date }} · {{ $event->time }}</p>
                                <p class="event-detail">📍 {{ $event->isOnline ? 'Online (Zoom)' : $event->location }}</p>
                                <p class="event-detail">{{ $event->formatted_price }}</p>
                            </div>
                        </div>
                        <div class="event-bottom">
                            <div class="quota-row"><span>Peserta</span><strong>{{ $event->quota_used }}/{{ $event->quota_max }}</strong></div>
                            <div class="progress-track"><span class="progress-fill" style="width: {{ min(100, $event->quota_max ? ($event->quota_used / $event->quota_max * 100) : 0) }}%"></span></div>
                            <a href="{{ Auth::check() && Auth::user()->isParticipant() ? route('participant.events.detail', $event->id) : route('login') }}" class="register-button {{ $loop->first ? 'dark' : '' }}">Lihat Event</a>
                        </div>
                    </article>
                @empty
                    <article class="event-card event-card-dark">
                        <div class="event-top"><span class="event-badge">Segera Hadir</span><h3>Belum ada event aktif</h3></div>
                        <div class="event-bottom"><p>Event baru dari organizer akan tampil di sini setelah dipublikasikan.</p></div>
                    </article>
                @endforelse
                @if(false)
                <!-- Card 1 -->
                <article class="event-card event-card-dark">
                    <div class="event-top">
                        <span class="event-badge">Webinar</span>
                        <h3>Webinar Tech Winter</h3>
                        <div class="event-meta-info">
                            <p class="event-detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                25 Jan, 2026
                            </p>
                            <p class="event-detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Online (Zoom)
                            </p>
                        </div>
                    </div>
                    <div class="event-bottom">
                        <div class="quota-row">
                            <span>Peserta</span>
                            <strong>75/100</strong>
                        </div>
                        <div class="progress-track">
                            <span class="progress-fill" style="width: 75%"></span>
                        </div>
                        <a href="{{ route('register') }}" class="register-button dark">Daftar Sekarang</a>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="event-card event-card-blue">
                    <div class="event-top">
                        <span class="event-badge">Seminar</span>
                        <h3>Seminar AI VS UI</h3>
                        <div class="event-meta-info">
                            <p class="event-detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                2 Feb, 2026
                            </p>
                            <p class="event-detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Balai Kota Bandung
                            </p>
                        </div>
                    </div>
                    <div class="event-bottom">
                        <div class="quota-row">
                            <span>Peserta</span>
                            <strong>12/25</strong>
                        </div>
                        <div class="progress-track">
                            <span class="progress-fill" style="width: 48%"></span>
                        </div>
                        <a href="{{ route('register') }}" class="register-button">Daftar Sekarang</a>
                    </div>
                </article>

                <!-- Card 3 -->
                <article class="event-card event-card-blue">
                    <div class="event-top">
                        <span class="event-badge">Seminar</span>
                        <h3>Seminar Be Brave, Be Creative</h3>
                        <div class="event-meta-info">
                            <p class="event-detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                15 Feb, 2026
                            </p>
                            <p class="event-detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Gedung Sate Bandung
                            </p>
                        </div>
                    </div>
                    <div class="event-bottom">
                        <div class="quota-row">
                            <span>Peserta</span>
                            <strong>2/35</strong>
                        </div>
                        <div class="progress-track">
                            <span class="progress-fill" style="width: 6%"></span>
                        </div>
                        <a href="{{ route('register') }}" class="register-button">Daftar Sekarang</a>
                    </div>
                </article>
                @endif
            </div>
        </section>

        <!-- TESTIMONIALS SECTION -->
        <section class="testimonials-section">
            <p class="section-subtitle">Suara Rizers</p>
            <h2 class="section-title">Apa Kata Mereka?</h2>
            
            <div class="testimonials-grid">
                @forelse($testimonials as $testimonial)
                    @php($reviewerName = $testimonial->user?->name ?? $testimonial->registration?->name ?? 'Peserta')
                    <article class="testimonial-card">
                        <div class="testimonial-user">
                            <span class="avatar-circle">{{ strtoupper(mb_substr($reviewerName, 0, 1)) }}</span>
                            <span class="username">{{ $reviewerName }}</span>
                        </div>
                        <div class="testimonial-rating" aria-label="Rating {{ $testimonial->rating }} dari 5">
                            {{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}
                        </div>
                        <p class="testimonial-text">“{{ $testimonial->comment }}”</p>
                        <small class="testimonial-event">{{ $testimonial->event?->title }}</small>
                    </article>
                @empty
                    <div class="testimonial-empty">Belum ada ulasan peserta. Jadilah Rizers pertama yang berbagi pengalaman.</div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer id="about" class="site-footer">
        <div class="footer-container">
            <div class="footer-brand-column">
                <a href="{{ route('home') }}" class="footer-logo">
                <img src="{{ asset('images/logo2.png') }}"
                alt="EventRize Logo"
                class="footer-brand-logo">
                <span>EVENTRIZE</span>
                </a>
                <p class="footer-desc">
                    Menjadi tempat berkembang, berinovasi dan meningkatkan insight untuk teknologi informasi berkelanjutan.
                </p>
            </div>

            <div class="footer-info-column">
                <h3>Hubungi Kami</h3>
                <div class="contact-item">
                    <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="5">
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>Jln. Soekarno Hatta, NO.40, Kota Bandung 40183</span>
                </div>
                <div class="contact-item">
                    <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span>EventRize.id</span>
                </div>
            </div>

            <div class="footer-social-column">
                <h3>Temukan Kami</h3>
                <div class="social-item">
                    <span>@EventRize12</span>
                </div>
            </div>
        </div>
    </footer>
    <script>
    window.addEventListener('scroll', function () {
    const header = document.querySelector('.site-header');

    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>
</body>
</html>
