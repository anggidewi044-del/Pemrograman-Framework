<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventRize')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/participant.css') }}">
    @stack('styles')
</head>
<body>
    <div class="participant-container">
        <!-- SIDEBAR -->
        <aside class="participant-sidebar">
            <div class="sidebar-top">
                <a href="{{ route('home') }}" class="sidebar-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="EventRize Logo" class="brand-logo">
                    <span>EVENTRIZE</span>
                </a>

                <div class="user-profile-card">
                    <div class="avatar-container">
                        <svg width="48" height="48" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="#3b82f6"/>
                            <circle cx="20" cy="15" r="7" fill="#ffffffd7"/>
                            <path d="M6 31C6 25 12 24 20 24C28 24 34 25 34 31V34H6V31Z" fill="#ffffff"/>
                        </svg>
                    </div>
                    <div class="profile-details">
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <span class="profile-role">Peserta</span>
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <a class="nav-item {{ request()->routeIs('participant.dashboard') ? 'active' : '' }}" href="{{ route('participant.dashboard') }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="9"></rect>
                            <rect x="14" y="3" width="7" height="5"></rect>
                            <rect x="14" y="12" width="7" height="9"></rect>
                            <rect x="3" y="16" width="7" height="5"></rect>
                        </svg>
                        Dashboard
                    </a>
                    <a class="nav-item {{ request()->routeIs('participant.events') || request()->routeIs('participant.events.detail') ? 'active' : '' }}" href="{{ route('participant.events') }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Events
                    </a>
                    <a class="nav-item {{ request()->routeIs('participant.tickets') || request()->routeIs('participant.tickets.detail') ? 'active' : '' }}" href="{{ route('participant.tickets') }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Tiket Saya
                    </a>
                    <a class="nav-item {{ request()->routeIs('participant.certificates') || request()->routeIs('participant.certificates.detail') ? 'active' : '' }}" href="{{ route('participant.certificates') }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <circle cx="8" cy="10" r="2"></circle>
                            <path d="M6 16c.7-1.5 3.3-1.5 4 0"></path>
                            <line x1="13" y1="10" x2="18" y2="10"></line>
                            <line x1="13" y1="14" x2="18" y2="14"></line>
                        </svg>
                        Sertifikat
                    </a>
                </nav>
            </div>

            <div class="sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg class="logout-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="participant-main">
            @if(session('success'))
                <div class="participant-alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="participant-alert error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        document.querySelectorAll('[data-notification]').forEach((notification) => {
            const toggle = notification.querySelector('[data-notification-toggle]');
            const menu = notification.querySelector('[data-notification-menu]');

            toggle?.addEventListener('click', (event) => {
                event.stopPropagation();
                const willOpen = menu.hidden;
                document.querySelectorAll('[data-notification-menu]').forEach((otherMenu) => otherMenu.hidden = true);
                document.querySelectorAll('[data-notification-toggle]').forEach((otherToggle) => otherToggle.setAttribute('aria-expanded', 'false'));
                menu.hidden = !willOpen;
                toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('[data-notification]')) {
                document.querySelectorAll('[data-notification-menu]').forEach((menu) => menu.hidden = true);
                document.querySelectorAll('[data-notification-toggle]').forEach((toggle) => toggle.setAttribute('aria-expanded', 'false'));
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                document.querySelectorAll('[data-notification-menu]').forEach((menu) => menu.hidden = true);
                document.querySelectorAll('[data-notification-toggle]').forEach((toggle) => toggle.setAttribute('aria-expanded', 'false'));
            }
        });
    </script>
</body>
</html>
