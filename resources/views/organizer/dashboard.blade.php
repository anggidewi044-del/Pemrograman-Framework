<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard - EventRize</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-top">
                <a href="/" class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}"
                alt="EventRize Logo"
                class="brand-logo">
                <span>EVENTRIZE</span>
                </a>
                <div class="user-profile-card">
                    <div class="avatar-container">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="#3b82f6"/>
                            <circle cx="20" cy="15" r="7" fill="#ffffffd7"/>
                            <path d="M6 31C6 25 12 24 20 24C28 24 34 25 34 31V34H6V31Z" fill="#ffffff"/>
                        </svg>
                    </div>
                    <div class="profile-details">
                        <span class="profile-name">Abdillah</span>
                        <span class="profile-role">Event Organizer</span>
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <button class="nav-item active" data-tab="tab-dashboard" id="nav-dashboard">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="9"></rect>
                            <rect x="14" y="3" width="7" height="5"></rect>
                            <rect x="14" y="12" width="7" height="9"></rect>
                            <rect x="3" y="16" width="7" height="5"></rect>
                        </svg>
                        Dashboard
                    </button>
                    <button class="nav-item" data-tab="tab-events" id="nav-events">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Events
                    </button>
                    <button class="nav-item" data-tab="tab-presensi" id="nav-presensi">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Presensi
                    </button>
                    <button class="nav-item" data-tab="tab-analytics" id="nav-analytics">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        Analytics
                    </button>
                    <button class="nav-item" data-tab="tab-certificate" id="nav-certificate">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <circle cx="8" cy="10" r="2"></circle>
                            <path d="M6 16c.7-1.5 3.3-1.5 4 0"></path>
                            <line x1="13" y1="10" x2="18" y2="10"></line>
                            <line x1="13" y1="14" x2="18" y2="14"></line>
                        </svg>
                        Certificate
                    </button>
                </nav>
            </div>

            <div class="sidebar-bottom">
                <a href="{{ route('logout') }}" class="logout-btn">
                    <svg class="logout-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- SEARCH HEADER -->
            <header class="content-header">
                <div class="page-heading">
                    <h1 id="page-title">Welcome Back, Abdillah!</h1>
                    <p id="page-subtitle" class="page-subtitle"></p>
                </div>
                <div class="search-bar" id="top-search-bar">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="search" id="search-input" placeholder="Cari event" aria-label="Cari event">
                </div>
                <div class="certificate-actions" id="certificate-actions">
                    <button class="certificate-primary-btn" id="btn-open-certificate-upload" type="button">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Upload Template
                    </button>
                </div>
                <div class="certificate-actions certificate-result-actions" id="certificate-result-actions">
                    <button class="certificate-primary-btn" type="button">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6">
                            <path d="M12 3v12"></path>
                            <path d="M7 8l5-5 5 5"></path>
                            <path d="M5 21h14"></path>
                        </svg>
                        Download Semua
                    </button>
                    <button class="certificate-secondary-btn" id="btn-back-certificate-list" type="button">Cek Daftar</button>
                </div>
            </header>

            @if(session('success'))
                <div class="dashboard-alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="dashboard-alert error">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="dashboard-alert error">{{ $errors->first() }}</div>
            @endif

            <!-- TAB: DASHBOARD -->
            <div id="tab-dashboard" class="tab-panel active">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon-wrapper active">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{{ $eventActiveCount }}</span>
                            <span class="stat-label">Event Active</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper participants">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{{ $totalParticipants }}</span>
                            <span class="stat-label">Total Participants</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper revenue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                            <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                            <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">Rp. {{ $revenue }}</span>
                            <span class="stat-label">Revenue</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-details">
                    <div class="upcoming-events-container">
                        <div class="container-title-row">
                            <h2>Upcoming Events</h2>
                            <a href="#events" class="view-all-link" id="trigger-view-all-events">View All</a>
                        </div>
                        <div class="upcoming-list">
                            @forelse ($upcomingEvents as $event)
                                <div class="upcoming-item" data-search="{{ strtolower($event->title . ' ' . $event->speaker . ' ' . $event->location) }}">
                                    <div class="stripe-indicator"></div>
                                    <div class="upcoming-img">
                                        @if($event->flyer_path)
                                            <div class="avatar-event-bg" style="background-image: url('{{ $event->flyer_url }}'); background-size: cover; background-position: center;"></div>
                                        @elseif($event->image)
                                            <div class="avatar-event-bg img-{{ $event->image }}"></div>
                                        @else
                                            <div class="avatar-event-bg empty"></div>
                                        @endif
                                    </div>
                                    <div class="upcoming-details">
                                        <h3>{{ $event->title }}</h3>
                                        <p class="event-meta-line">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                                            {{ $event->display_date }}
                                        </p>
                                        <p class="event-meta-line">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="s-icon s-icon-icon-location" class="tiny-icon" viewBox="0 0 16 16">
                                            <path d="M8 16a.667.667 0 0 1-.37-.112c-.257-.171-6.297-4.255-6.297-9.221a6.667 6.667 0 0 1 11.38-4.714 6.623 6.623 0 0 1 1.953 4.714c0 4.966-6.04 9.05-6.296 9.22A.667.667 0 0 1 8 16ZM8 1.333a5.333 5.333 0 0 0-5.334 5.334c0 3.608 4.067 6.908 5.334 7.847 1.266-.939 5.333-4.239 5.333-7.847A5.333 5.333 0 0 0 8 1.333Zm0 8A2.667 2.667 0 1 1 8 4a2.667 2.667 0 0 1 0 5.333Zm0-4A1.333 1.333 0 1 0 8 8a1.333 1.333 0 0 0 0-2.667Z"/></svg>
                                            {{ $event->isOnline ? 'Online (Zoom)' : $event->location }}
                                        </p>
                                    </div>
                                    <div class="upcoming-badge">
                                        <span>{{ $event->registrations->whereIn('status', ['terdaftar', 'hadir'])->count() }}/{{ $event->quota_max }} Slots</span>
                                    </div>
                                </div>
                            @empty
                                <p class="dashboard-empty-note">Belum ada event aktif yang akan datang.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="recent-activity-container">
                        <h2>Recent Activity</h2>
                        <div class="activity-box">
                            @foreach ($recentActivities as $activity)
                                <div class="activity-item">
                                    <h4 class="activity-title">{{ $activity['title'] }}</h4>
                                    <p class="activity-desc {{ $activity['type'] == 'success' ? 'verified' : ($activity['type'] == 'warning' ? 'action-required' : '') }}">
                                        {{ $activity['description'] }}
                                    </p>
                                    <span class="activity-time">{{ $activity['time'] }}</span>
                                </div>
                            @endforeach
                            @if($recentActivities->isEmpty())
                                <p class="dashboard-empty-note">Belum ada aktivitas terbaru.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: EVENTS -->
            <div id="tab-events" class="tab-panel">
                <div class="events-controls-row">
                    <div class="segment-container">
                        <button class="segment-btn active" data-filter="aktif">Aktif</button>
                        <button class="segment-btn" data-filter="draft">Draft</button>
                        <button class="segment-btn" data-filter="selesai">Selesai</button>
                    </div>

                    <!-- Only visible when on Draft segment -->
                    <button class="btn-add-event" id="btn-add-event" style="display: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Event
                    </button>
                </div>

                <div class="events-list-container" id="events-list">
                    @foreach ($events as $event)
                        <div class="event-row-card" data-status="{{ $event->status }}" data-id="{{ $event->id }}"
                             data-title="{{ $event->title }}" data-speaker="{{ $event->speaker }}"
                             data-category="{{ $event->category }}"
                             data-date="{{ $event->date }}" data-display-date="{{ $event->display_date }}" data-time="{{ $event->time }}"
                             data-event_type="{{ $event->event_type }}"
                             data-location="{{ $event->location }}"
                             data-zoom_link="{{ $event->zoom_link }}" data-zoom_info="{{ $event->zoom_info }}"
                             data-description="{{ $event->description }}" data-materi="{{ $event->materi }}"
                             data-quota_max="{{ $event->quota_max }}" data-quota_used="{{ $event->quota_used }}"
                             data-price="{{ $event->price }}" data-contact_phone="{{ $event->contact_phone }}"
                             data-image="{{ $event->image }}" data-flyer-url="{{ $event->flyer_url ?? '' }}">
                            
                            <div class="card-thumbnail">
                                @if($event->flyer_path)
                                    <div class="thumbnail-bg" style="background-image:url('{{ $event->flyer_url }}'); background-size:cover; background-position:center;"></div>
                                @elseif($event->image)
                                    <div class="thumbnail-bg img-{{ $event->image }}"></div>
                                @else
                                    <div class="thumbnail-bg placeholder-gradient"></div>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="card-badges">
                                    <span class="event-type-badge {{ $event->event_type }}">{{ ucfirst($event->event_type) }}</span>
                                    @if($event->category)
                                        <span class="category-badge">{{ $event->category }}</span>
                                    @endif
                                    <span class="price-badge {{ $event->price > 0 ? 'paid' : 'free' }}">{{ $event->formatted_price }}</span>
                                </div>
                                <h2>{{ $event->title }}</h2>
                                <p class="speaker-name">{{ $event->speaker }}</p>
                                <div class="event-meta-info-row">
                                    <span class="meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                                        {{ $event->display_date }}
                                    </span>
                                    <span class="meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                        {{ $event->isOnline ? 'Online (Zoom)' : $event->location }}
                                    </span>
                                </div>
                                @if($event->status !== 'selesai')
                                    <span class="slots-capsule">{{ $event->quota_used }}/{{ $event->quota_max }} Slots</span>
                                @endif
                            </div>

@if ($event->status === 'aktif')
                            <div class="card-actions">
                                <a href="{{ route('organizer.events.registrations', $event->id) }}" class="btn-action-manage">
                                    Kelola
                                </a>
                                <form action="{{ route('organizer.events.complete', $event->id) }}" method="POST" onsubmit="return confirm('Selesaikan event dan terbitkan sertifikat peserta hadir?')">
                                    @csrf
                                    <button type="submit" class="btn-action-upload">Selesaikan</button>
                                </form>
                                <button class="btn-action-details" onclick="openDetailsModal({{ (int)$event->id }})">
                                    Details
                                </button>
                            </div>

@elseif ($event->status === 'selesai')
    <div class="card-actions">
        <button class="btn-action-details" onclick="viewAnalyticsFor({{ (int)$event->id }})">
            Analytics
        </button>
    </div>

@else
    <div class="card-actions card-actions-draft">
        <button class="btn-action-edit" onclick="editEvent({{ (int)$event->id }})">
            Edit
        </button>

        <form action="{{ route('organizer.events.publish', $event->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-action-upload">Upload</button>
        </form>

        <form action="{{ route('organizer.events.delete', $event->id) }}" method="POST" onsubmit="return confirm('Delete event?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action-delete">Delete</button>
        </form>
    </div>
@endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB: PRESENSI -->
            <div id="tab-presensi" class="tab-panel">
                <div class="events-list-container">
                    @forelse ($events->where('status', 'aktif') as $event)
                        <div class="event-row-card">
                            <div class="card-thumbnail">
                                @if($event->flyer_path)
                                    <div class="thumbnail-bg" style="background-image:url('{{ $event->flyer_url }}'); background-size:cover; background-position:center;"></div>
                                @elseif($event->image)
                                    <div class="thumbnail-bg img-{{ $event->image }}"></div>
                                @else
                                    <div class="thumbnail-bg placeholder-gradient"></div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h2>{{ $event->title }}</h2>
                                <p class="speaker-name">{{ $event->speaker }}</p>
                                <div class="event-meta-info-row">
                                    <span class="meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                                        {{ $event->display_date }}
                                    </span>
                                    <span class="meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                        {{ $event->location }}
                                    </span>
                                </div>
                                <span class="slots-capsule">{{ $event->quota_used }}/{{ $event->quota_max }} Slots</span>
                            </div>
                            <div class="card-actions">
                                <a href="{{ route('organizer.events.attendance', $event->id) }}" class="btn-action-details">Kelola Presensi</a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-message">Tidak ada event aktif untuk presensi saat ini.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB: ANALYTICS -->
            <div id="tab-analytics" class="tab-panel">
                <div class="analytics-event-list-screen" id="analytics-event-list-screen">
                    <div class="analytics-list-heading"><div><h2>Analytics Event</h2><p>Pilih event yang telah selesai untuk melihat hasil dan progresnya.</p></div></div>
                    <div class="analytics-event-grid">
                        @forelse($events->where('status', 'selesai') as $event)
                            <article class="analytics-event-card">
                                <div class="analytics-card-image">
                                    @if($event->flyer_path)<img src="{{ $event->flyer_url }}" alt="{{ $event->title }}">@else<div class="placeholder-gradient"></div>@endif
                                </div>
                                <div class="analytics-card-body">
                                    <h3>{{ $event->title }}</h3>
                                    <p>📅 {{ $event->display_date }}</p>
                                    <p>📍 {{ $event->isOnline ? 'Online (Zoom)' : $event->location }}</p>
                                    <button type="button" onclick="openAnalyticsDetail({{ $event->id }})">Detail</button>
                                </div>
                            </article>
                        @empty
                            <div class="certificate-empty-state">Belum ada event selesai untuk dianalisis.</div>
                        @endforelse
                    </div>
                </div>
                <div class="analytics-layout" id="analytics-detail-screen" style="display:none">
                    <button type="button" class="analytics-back-button" onclick="showAnalyticsList()">← Kembali ke daftar event</button>

                    <!-- Header Card -->
                    <div class="analytics-header-card">
                        <div class="analytics-thumb" id="analytics-event-thumb">
                            <div class="thumbnail-bg img-tech-winter"></div>
                        </div>
                        <div class="analytics-header-details">
                            <h2 id="analytics-event-title">Tech Winter</h2>
                            <p class="speaker-name" id="analytics-event-speaker">Oliver Archio, S.Kom., M.T</p>
                            <div class="event-meta-info-row">
                                <span class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                                    <span id="analytics-event-date">25 Jan, 2026</span>
                                </span>
                                <span class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                    <span id="analytics-event-loc">Universitas Pasundan</span>
                                </span>
                                <span class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/></svg>
                                    <span id="analytics-event-time">10.00 - 12.00</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics grid (4 columns) -->
                    <div class="analytics-stats-grid">
                        <div class="stat-box-card">
                            <span class="box-title">REGISTERED PARTICIPANT</span>
                            <span class="box-number" id="analytics-stat-reg">100</span>
                        </div>
                        <div class="stat-box-card">
                            <span class="box-title">PRESENT</span>
                            <span class="box-number" id="analytics-stat-present">70</span>
                        </div>
                        <div class="stat-box-card">
                            <span class="box-title">REVENUE</span>
                            <span class="box-number" id="analytics-stat-rev">2.750.000</span>
                        </div>
                        <div class="stat-box-card">
                            <span class="box-title">ATTENDANCE RATE</span>
                            <span class="box-number" id="analytics-stat-rate">0%</span>
                        </div>
                    </div>

                    <!-- Status Kehadiran and Feedback Participant layout -->
                    <div class="analytics-details-grid">
                        <!-- Chart Panel -->
                        <div class="chart-panel-card">
                            <h3>STATUS KEHADIRAN</h3>
                            <div class="chart-wrapper">
                                <!-- Clean geometric SVG Pie Chart representation to exactly mirror screenshot -->
                                <svg width="220" height="220" viewBox="0 0 42 42" class="donut-chart">
                                    <circle class="donut-hole" cx="21" cy="21" r="15.915" fill="#fff"></circle>
                                    <circle class="donut-ring" cx="21" cy="21" r="15.915" fill="transparent" stroke="#e2e8f0" stroke-width="6"></circle>
                                    <circle class="donut-segment" cx="21" cy="21" r="15.915" fill="transparent" stroke="#16243d" stroke-width="6" stroke-dasharray="70 30" stroke-dashoffset="25"></circle>
                                    <g class="chart-text">
                                        <text x="50%" y="50%" class="chart-number">70%</text>
                                    </g>
                                </svg>
                                <div class="chart-legend">
                                    <div class="legend-item"><span class="legend-color present"></span> Present</div>
                                    <div class="legend-item"><span class="legend-color absent"></span> Absent</div>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Panel -->
                        <div class="feedback-panel-card">
                            <h3>FEEDBACK PARTICIPANT</h3>
                            <div class="feedback-list" id="analytics-feedback-list">
                                <div class="feedback-item-card"><p class="feedback-msg">Pilih event untuk melihat ulasan peserta.</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: CERTIFICATE -->
            <div id="tab-certificate" class="tab-panel">
                <section class="certificate-workflow-panel">
                    @if(!$selectedCertificateEvent)
                    <div class="certificate-event-list-screen">
                        <div class="analytics-list-heading">
                            <h2>Pilih Event untuk Sertifikat</h2>
                            <p>Pilih event yang telah selesai untuk mengunggah template dan generate sertifikat peserta.</p>
                        </div>
                        <div class="analytics-event-grid certificate-event-grid">
                            @forelse($certificateEvents as $certificateEvent)
                                <article class="analytics-event-card certificate-event-card">
                                    <div class="analytics-card-image">
                                        @if($certificateEvent->flyer_path)
                                            <img src="{{ $certificateEvent->flyer_url }}" alt="{{ $certificateEvent->title }}">
                                        @else
                                            <div class="placeholder-gradient"></div>
                                        @endif
                                    </div>
                                    <div class="analytics-card-body">
                                        <h3>{{ $certificateEvent->title }}</h3>
                                        <p>{{ $certificateEvent->display_date }}</p>
                                        <p>{{ $certificateEvent->isOnline ? 'Online (Zoom)' : $certificateEvent->location }}</p>
                                        <a href="{{ route('organizer.dashboard', ['certificate_event' => $certificateEvent->id]) }}#certificate" class="certificate-select-event-btn">Pilih Event</a>
                                    </div>
                                </article>
                            @empty
                                <div class="certificate-empty-state">Belum ada event selesai. Selesaikan event terlebih dahulu untuk membuat sertifikat.</div>
                            @endforelse
                        </div>
                    </div>
                    @else
                    <a href="{{ route('organizer.dashboard') }}#certificate" class="analytics-back-button certificate-back-button">← Kembali ke daftar event</a>
                    <div class="certificate-event-picker">
                        <div>
                            <span class="certificate-current-label">EVENT TERPILIH</span>
                            <h2>{{ $selectedCertificateEvent->title }}</h2>
                            <p>{{ $selectedCertificateEvent->display_date }} · {{ $selectedCertificateEvent->isOnline ? 'Online (Zoom)' : $selectedCertificateEvent->location }}</p>
                        </div>
                        <span class="certificate-current-status">Selesai</span>
                    </div>

                        @php
                            $certificateRegistered = $selectedCertificateEvent->registrations->whereIn('status', ['terdaftar', 'hadir'])->count();
                            $certificateAttended = $selectedCertificateEvent->registrations->where('status', 'hadir');
                            $certificateIssued = $certificateAttended->whereNotNull('certificate_token')->count();
                        @endphp
                        <div class="certificate-stats-grid">
                            <div class="certificate-stat-card"><div class="certificate-stat-title"><span>TERDAFTAR</span></div><p><strong>{{ $certificateRegistered }}</strong> orang</p></div>
                            <div class="certificate-stat-card"><div class="certificate-stat-title"><span>HADIR & LAYAK</span></div><p><strong>{{ $certificateAttended->count() }}</strong> orang</p></div>
                            <div class="certificate-stat-card"><div class="certificate-stat-title"><span>DITERBITKAN</span></div><p><strong>{{ $certificateIssued }}</strong> orang</p></div>
                        </div>

                        <div class="certificate-workflow-grid">
                            <form action="{{ route('organizer.events.certificate-template', $selectedCertificateEvent->id) }}" method="POST" enctype="multipart/form-data" class="certificate-upload-real">
                                @csrf
                                <h3>1. Upload Template</h3>
                                @if($selectedCertificateEvent->certificate_template_path)
                                    <div class="certificate-position-preview">
                                        <img id="certificate-live-preview-image" src="{{ $selectedCertificateEvent->certificate_template_url }}" alt="Template sertifikat">
                                        <strong id="certificate-preview-name" style="top:{{ $selectedCertificateEvent->certificate_name_y ?? 47 }}%;font-size:{{ max(12, round(($selectedCertificateEvent->certificate_name_size ?? 42) * .48)) }}px;color:{{ $selectedCertificateEvent->certificate_name_color ?? '#1e293b' }}">Nama Peserta</strong>
                                    </div>
                                    <p>{{ $selectedCertificateEvent->certificate_template_name }}</p>
                                @else
                                    <div class="certificate-position-preview" id="certificate-new-preview">
                                        <img id="certificate-live-preview-image" alt="Preview template" hidden>
                                        <strong id="certificate-preview-name" style="top:{{ $selectedCertificateEvent->certificate_name_y ?? 47 }}%;font-size:{{ max(12, round(($selectedCertificateEvent->certificate_name_size ?? 42) * .48)) }}px;color:{{ $selectedCertificateEvent->certificate_name_color ?? '#1e293b' }}">Nama Peserta</strong>
                                        <div class="certificate-empty-preview" id="certificate-empty-preview">Belum ada template</div>
                                    </div>
                                @endif
                                <input type="file" name="certificate_template" id="certificate-real-file" accept="image/png,image/jpeg" required>
                                <div class="certificate-position-controls">
                                    <label>Posisi nama <output id="name-y-output">{{ $selectedCertificateEvent->certificate_name_y ?? 47 }}%</output><input type="range" name="certificate_name_y" id="certificate-name-y" min="20" max="80" value="{{ $selectedCertificateEvent->certificate_name_y ?? 47 }}"></label>
                                    <label>Ukuran nama <output id="name-size-output">{{ $selectedCertificateEvent->certificate_name_size ?? 42 }}px</output><input type="range" name="certificate_name_size" id="certificate-name-size" min="18" max="72" value="{{ $selectedCertificateEvent->certificate_name_size ?? 42 }}"></label>
                                    <label>Warna nama <input type="color" name="certificate_name_color" id="certificate-name-color" value="{{ $selectedCertificateEvent->certificate_name_color ?? '#1e293b' }}"></label>
                                </div>
                                <small>Geser posisi dan ukuran sampai nama contoh tepat pada area nama di template.</small>
                                <button type="submit" class="certificate-primary-btn">Upload Template</button>
                            </form>

                            <div class="certificate-generate-real">
                                <h3>2. Generate Sertifikat</h3>
                                <p>Hanya peserta dengan status <strong>Terdaftar dan Hadir</strong> yang akan memperoleh sertifikat.</p>
                                <form action="{{ route('organizer.events.certificates.generate', $selectedCertificateEvent->id) }}" method="POST" onsubmit="return confirm('Generate sertifikat untuk seluruh peserta yang hadir?')">
                                    @csrf
                                    <button type="submit" class="certificate-generate-btn" {{ !$selectedCertificateEvent->certificate_template_path || $certificateAttended->isEmpty() ? 'disabled' : '' }}>Generate {{ $certificateAttended->count() }} Sertifikat</button>
                                </form>
                                @if($selectedCertificateEvent->certificate_generated_at)
                                    <span class="certificate-generated-note">Terakhir dibuat {{ $selectedCertificateEvent->certificate_generated_at->format('d M Y H:i') }}</span>
                                @endif
                            </div>
                        </div>

                        <section class="certificate-panel certificate-attendee-panel">
                            <div class="certificate-attendee-toolbar">
                                <div>
                                    <h2>Peserta Hadir</h2>
                                    <p>{{ $certificateAttended->count() }} peserta layak menerima sertifikat</p>
                                </div>
                                <label class="certificate-attendee-search">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-4-4"></path></svg>
                                    <span class="sr-only">Cari peserta sertifikat</span>
                                    <input type="search" id="certificate-attendee-search" placeholder="Cari nama atau email">
                                </label>
                            </div>
                            <div class="certificate-table">
                                <div class="certificate-table-head"><span>Nama Peserta</span><span>Email</span><span>Waktu Presensi</span><span>Status Sertifikat</span></div>
                                @forelse($certificateAttended as $attendee)
                                    <div class="certificate-table-row"><span>{{ $attendee->name }}</span><a href="mailto:{{ $attendee->email }}">{{ $attendee->email }}</a><span>{{ $attendee->check_in_time ?? '-' }}</span><span>{{ $attendee->certificate_token ? 'Sudah diterbitkan' : 'Belum digenerate' }}</span></div>
                                @empty
                                    <div class="certificate-empty-row">Belum ada peserta hadir.</div>
                                @endforelse
                            </div>
                        </section>
                    @endif
                </section>
                @if(false)
                <div class="certificate-screen active" id="certificate-list-screen">
                    <div class="certificate-stats-grid">
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <rect x="3" y="4" width="18" height="18" rx="3"></rect>
                                    <path d="M8 12l2.5 2.5L16 9"></path>
                                </svg>
                                <span>REGISTERED<br>PARTICIPANT</span>
                            </div>
                            <p><strong>100</strong> orang</p>
                        </div>
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M8 3h8l2 3v15H6V3h2z"></path>
                                    <path d="M9 13l2 2 4-5"></path>
                                </svg>
                                <span>PRESENT</span>
                            </div>
                            <p><strong>70</strong> orang</p>
                        </div>
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <circle cx="8" cy="10" r="1.5"></circle>
                                    <line x1="12" y1="10" x2="18" y2="10"></line>
                                    <line x1="7" y1="15" x2="18" y2="15"></line>
                                </svg>
                                <span>Creat Certificate</span>
                            </div>
                            <p><strong>70</strong> orang</p>
                        </div>
                    </div>

                    <section class="certificate-panel">
                        <h2>Tempalte Sertifikat</h2>
                        <div class="certificate-template-card">
                            <div class="certificate-template-preview">
                                <div class="certificate-sample-mini">
                                    <span>SERTIFIKAT</span>
                                    <strong>@{{nama}}</strong>
                                </div>
                            </div>
                            <div class="certificate-template-info">
                                <h3>temp - tech - winter.pdf</h3>
                                <p>diupload pada 10 Apr 2026</p>
                                <span>Aktif</span>
                            </div>
                            <button class="certificate-generate-btn" id="btn-generate-certificate" type="button">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6">
                                    <path d="M12 3v12"></path>
                                    <path d="M7 8l5-5 5 5"></path>
                                    <path d="M5 21h14"></path>
                                </svg>
                                Generate
                            </button>
                        </div>

                        <h2 class="certificate-table-title">Peserta Hadir (70)</h2>
                        <div class="certificate-table">
                            <div class="certificate-table-head">
                                <span>Nama Peserta</span>
                                <span>Email</span>
                                <span>Waktu Presensi</span>
                                <span>Status Sertifikat</span>
                            </div>
                            <div class="certificate-table-row">
                                <span>Novandra Rahmat</span>
                                <a href="mailto:bar32@gmail.com">bar32@gmail.com</a>
                                <span>10.15</span>
                                <span>Selesai dibuat</span>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="certificate-screen" id="certificate-result-screen">
                    <div class="certificate-stats-grid result">
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <rect x="3" y="4" width="18" height="18" rx="3"></rect>
                                    <path d="M8 12l2.5 2.5L16 9"></path>
                                </svg>
                                <span>REGISTERED<br>PARTICIPANT</span>
                            </div>
                            <p><strong>100</strong> orang</p>
                        </div>
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12l4 4L19 6"></path>
                                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                </svg>
                                <span>Berhasil dibuat</span>
                            </div>
                            <p><strong>70</strong> orang</p>
                        </div>
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <circle cx="8" cy="10" r="1.5"></circle>
                                    <line x1="12" y1="10" x2="18" y2="10"></line>
                                    <line x1="7" y1="15" x2="18" y2="15"></line>
                                </svg>
                                <span>Gagal dibuat</span>
                            </div>
                            <p><strong>0</strong> orang</p>
                        </div>
                        <div class="certificate-stat-card">
                            <div class="certificate-stat-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span>Tanggal Generate</span>
                            </div>
                            <p class="certificate-date">10 April 2026</p>
                        </div>
                    </div>

                    <section class="certificate-panel certificate-result-panel">
                        <div class="certificate-result-table">
                            <div class="certificate-result-head">
                                <span>Nama Peserta</span>
                                <span>Email</span>
                                <span>Status</span>
                                <span>Download Sertifikat</span>
                            </div>
                            <div class="certificate-result-row">
                                <span>Novandra Rahmat</span>
                                <a href="mailto:bar32@gmail.com">bar32@gmail.com</a>
                                <span><mark>Berhasil</mark></span>
                                <span><button type="button">Download Pdf</button></span>
                            </div>
                        </div>
                    </section>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- MODAL: FORM DETAILS EVENT -->
    <div class="modal-overlay" id="details-modal">
        <div class="details-modal-box">
            <div class="modal-header">
                <h2>Form Details Event</h2>
                <button class="btn-close-x" onclick="closeDetailsModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-group">
                    <label>Event</label>
                    <div class="detail-value" id="detail-title">Webinar Tech Winter</div>
                </div>

                <div class="detail-group">
                    <label>Speaker</label>
                    <div class="detail-value" id="detail-speaker">Oliver Archio, S.Kom.,.M.T</div>
                </div>

                <div class="detail-group">
                    <label>Schedule</label>
                    <div class="schedule-panel-box">
                    <div class="schedule-grid">
                        <div class="schedule-item">
                            <svg class="input-inline-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                            <span id="detail-date">25 Jan, 2026</span>
                        </div>
                        <div class="schedule-item">
                            <svg class="input-inline-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/></svg>
                            <span id="detail-time">10.00 - 12.00</span>
                        </div>
                        <div class="schedule-item">
                            <svg class="input-inline-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="M8 9h8M8 13h5"></path>
                            </svg>
                            <span id="detail-loc-1">Online (Zoom)</span>
                        </div>
                        <div class="schedule-item">
                            <svg class="input-inline-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                            </svg>
                            <span id="detail-loc-2">Balai Kota Bandung</span>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="detail-group">
                    <label>Description</label>
                    <div class="detail-value text-area-val" id="detail-desc">
                        Webinar akan disampaikan oleh Oliver Archio, S.Kom., M.T yang akan membahas mengenai isu Tech Winter
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-close-modal" onclick="closeDetailsModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- MODAL: ADD / EDIT FORM -->
    <div class="modal-overlay" id="form-modal">
        <div class="form-modal-box">
            <div class="modal-header">
                <h2 id="form-modal-title">Form Tambah Event</h2>
                <button class="btn-close-x" onclick="closeFormModal()">&times;</button>
            </div>
            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="form-id" name="id">
                
                <div class="modal-body form-scroll-area">
                    <!-- Title Input -->
                    <div class="form-group-dash">
                        <label for="form-title">Event <span class="asterisk">*</span></label>
                        <input type="text" id="form-title" name="title" required placeholder="contoh: Webinar Data Science">
                    </div>

                    <!-- Category and Speaker row -->
                    <div class="form-row-dash">
                        <div class="form-group-dash">
                            <label for="form-speaker">Speaker <span class="asterisk">*</span></label>
                            <input type="text" id="form-speaker" name="speaker" required placeholder="contoh: Aryo Palah">
                        </div>
                        <div class="form-group-dash">
                            <label for="form-category">Category <span class="asterisk">*</span></label>
                            <select id="form-category" name="category" required>
                                <option value="Workshop">Workshop</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Webinar">Webinar</option>
                            </select>
                        </div>
                    </div>

                    <!-- Event type and Location/Zoom row -->
                    <div class="form-row-dash">
                        <div class="form-group-dash">
                            <label for="form-location">Location <span class="asterisk">*</span></label>
                            <input type="text" id="form-location" name="location" placeholder="GSG / Balai Kota">
                        </div>
                        <div class="form-group-dash">
                            <label for="form-contact-phone">Contact Phone</label>
                            <input type="text" id="form-contact-phone" name="contact_phone" placeholder="0813xxxxxxxx">
                        </div>
                    </div>

                    <!-- Zoom fields (shown only for online) -->
                    <div class="form-row-dash zoom-fields" id="zoom-fields-row">
                        <div class="form-group-dash">
                            <label for="form-zoom-link">Link Zoom <span class="asterisk">*</span></label>
                            <input type="url" id="form-zoom-link" name="zoom_link" placeholder="https://zoom.us/j/...">
                        </div>
                        <div class="form-group-dash">
                            <label for="form-zoom-info">Zoom Meeting Info</label>
                            <input type="text" id="form-zoom-info" name="zoom_info" placeholder="Meeting ID / Passcode">
                        </div>
                    </div>

                    <span class="panel-label">Schedule</span>
                    <div class="schedule-panel-box">
                        <div class="schedule-panel-grid">
                            <label class="panel-input-wrapper" for="form-date">
                                <svg class="input-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"></rect><path d="M8 2v4M16 2v4M3 10h18"></path></svg>
                                <span class="sr-only">Tanggal</span>
                                <input type="date" id="form-date" name="date" required>
                                <span class="asterisk-inline">*</span>
                            </label>
                            <label class="panel-input-wrapper" for="form-time">
                                <svg class="input-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>
                                <span class="sr-only">Waktu Mulai</span>
                                <input type="time" id="form-time" name="time" required>
                                <span class="asterisk-inline">*</span>
                            </label>
                            <label class="panel-input-wrapper" for="form-type">
                                <svg class="input-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M8 3v4M16 3v4"></path></svg>
                                <span class="sr-only">Tipe Event</span>
                                <select id="form-type" name="event_type" class="inline-select" onchange="toggleEventTypeFields()" required>
                                    <option value="offline">offline</option>
                                    <option value="online">online</option>
                                </select>
                                <span class="asterisk-inline">*</span>
                            </label>
                            <label class="panel-input-wrapper schedule-slot-input" for="form-quota-max">
                                <svg class="input-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3"></circle><circle cx="17" cy="9" r="2"></circle><path d="M3 19c0-3 2.5-5 6-5s6 2 6 5M15 15c3 0 5 1.5 5 4"></path></svg>
                                <span class="sr-only">Jumlah Slot</span>
                                <span class="slot-manual-control">
                                    <input type="number" id="form-quota-max" name="quota_max" min="1" step="1" required aria-label="Jumlah slot">
                                    <span class="slot-suffix">Slot</span>
                                </span>
                                <span class="asterisk-inline">*</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price and File Upload -->
                    <div class="form-row-dash">
                        <div class="form-group-dash">
                            <label for="form-price">Harga Tiket (Rp)</label>
                            <div class="price-input-wrapper">
                                <input type="number" id="form-price" name="price" min="0" step="1" value="0" placeholder="Kosongkan untuk event gratis">
                                <label class="free-toggle">
                                    <input type="checkbox" id="form-price-free" onchange="togglePriceFree()">
                                    Gratis
                                </label>
                            </div>
                        </div>
                        <div class="form-group-dash">
                            <label for="form-flyer">Upload Flyer</label>
                            <div class="file-upload-box">
                                <input type="file" id="form-flyer" name="flyer" class="native-file-input" accept="image/*">
                                <label for="form-flyer" class="btn-choose-file">choose file</label>
                                <span class="file-name-placeholder" id="form-flyer-name">No file chosen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Materials Input -->
                    <div class="form-group-dash">
                        <label for="form-materi">Materials</label>
                        <textarea id="form-materi" name="materi" rows="3" placeholder="One material per line"></textarea>
                    </div>

                    <!-- Quota used and Status (hidden or minimal default) -->
                    <input type="hidden" id="form-quota-used" name="quota_used" value="0">
                    <input type="hidden" id="form-status" name="status" value="draft">

                    <!-- Description Input -->
                    <div class="form-group-dash">
                        <label for="form-description">Description <span class="asterisk">*</span></label>
                        <textarea id="form-description" name="description" rows="4" required placeholder="Contoh: Webinar Data Science yang diselenggarakan oleh Kominfo dan pemateri Aryo Palah"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-save-modal" id="btn-submit-form">Add Event</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: UPLOAD CERTIFICATE TEMPLATE -->
    <div class="modal-overlay" id="certificate-upload-modal">
        <div class="certificate-upload-box">
            <div class="certificate-upload-header">
                <h2>Upload Tempalte Sertifikat</h2>
                <button class="btn-close-x" type="button" onclick="closeCertificateUploadModal()">&times;</button>
            </div>
            <div class="certificate-upload-body">
                <label class="certificate-dropzone" for="certificate-template-file">
                    <input type="file" id="certificate-template-file" accept=".pdf,.png,.jpg,.jpeg" hidden>
                    <strong>drag & drop file template di sini</strong>
                    <span>atau</span>
                    <b>Pilih File</b>
                    <small id="certificate-template-file-name"></small>
                </label>

                <div class="certificate-placeholder-guide">
                    <h3>Contoh Penggunaan Placeholder</h3>
                    <div class="certificate-guide-content">
                        <div class="certificate-sample-mini large">
                            <span>SERTIFIKAT</span>
                            <strong>@{{nama}}</strong>
                        </div>
                        <p>Pastikan template sertifikat anda menggunakan placeholder @{{nama}} seperti contoh di samping.</p>
                    </div>
                </div>
            </div>
            <div class="certificate-upload-footer">
                <button class="certificate-cancel-btn" type="button" onclick="closeCertificateUploadModal()">Batal</button>
                <button class="certificate-upload-submit" type="button" onclick="closeCertificateUploadModal()">Upload</button>
            </div>
        </div>
    </div>

    <!-- CLIENT NAVIGATION & INTERACTION SCRIPT -->
    <script>
        // Sidebar tabs toggling
        const navItems = document.querySelectorAll('.nav-item');
        const panels = document.querySelectorAll('.tab-panel');
        const pageTitle = document.getElementById('page-title');
        const pageSubtitle = document.getElementById('page-subtitle');
        const topSearchBar = document.getElementById('top-search-bar');
        const certificateActions = document.getElementById('certificate-actions');
        const certificateResultActions = document.getElementById('certificate-result-actions');
        const certificateListScreen = document.getElementById('certificate-list-screen');
        const certificateResultScreen = document.getElementById('certificate-result-screen');

        function activateTab(targetTab, shouldUpdateHash = true) {
            const targetNav = document.querySelector(`.nav-item[data-tab="${targetTab}"]`);
            const targetPanel = document.getElementById(targetTab);

            if (!targetNav || !targetPanel) {
                return;
            }

                navItems.forEach(nav => nav.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));

            targetNav.classList.add('active');
            targetPanel.classList.add('active');

            pageSubtitle.innerText = "";
            pageSubtitle.style.display = 'none';
            certificateActions.style.display = 'none';
            certificateResultActions.style.display = 'none';

            if (targetTab === 'tab-analytics' || targetTab === 'tab-certificate') {
                topSearchBar.style.display = 'none';
            } else {
                topSearchBar.style.display = 'flex';
            }

            if (targetTab === 'tab-dashboard') {
                pageTitle.innerText = "Welcome Back, Abdillah!";
            } else if (targetTab === 'tab-events') {
                pageTitle.innerText = "EVENTS";
                const activeSegment = document.querySelector('.segment-btn.active');
                filterEvents(activeSegment ? activeSegment.getAttribute('data-filter') : 'aktif');
            } else if (targetTab === 'tab-presensi') {
                pageTitle.innerText = "PRESENSI";
            } else if (targetTab === 'tab-analytics') {
                pageTitle.innerText = "Analytic";
                showAnalyticsList();
            } else if (targetTab === 'tab-certificate') {
                showCertificateList(false);
            }

            if (shouldUpdateHash) {
                history.replaceState(null, '', '#' + targetTab.replace('tab-', ''));
            }
        }

        navItems.forEach(item => {
            item.addEventListener('click', () => {
                activateTab(item.getAttribute('data-tab'));
            });
        });

        // Trigger View All Events link to go to Events tab
        const viewAllEventsLink = document.getElementById('trigger-view-all-events');
        if(viewAllEventsLink) {
            viewAllEventsLink.addEventListener('click', (e) => {
                e.preventDefault();
                activateTab('tab-events');
            });
        }

        function showCertificateList(shouldSetTitle = true) {
            if (shouldSetTitle) {
                pageTitle.innerText = "Certificate";
            }
            pageTitle.innerText = "Certificate";
            pageSubtitle.innerText = "Kelola template dan pembuatan sertifikat";
            pageSubtitle.style.display = 'block';
            certificateActions.style.display = 'none';
            certificateResultActions.style.display = 'none';
            certificateListScreen?.classList.add('active');
            certificateResultScreen?.classList.remove('active');
        }

        function showCertificateResult() {
            pageTitle.innerText = "Hasil Generate";
            pageSubtitle.innerText = "";
            pageSubtitle.style.display = 'none';
            certificateActions.style.display = 'none';
            certificateResultActions.style.display = 'flex';
            certificateListScreen?.classList.remove('active');
            certificateResultScreen?.classList.add('active');
            history.replaceState(null, '', '#certificate');
        }

        const certificateUploadModal = document.getElementById('certificate-upload-modal');
        const btnOpenCertificateUpload = document.getElementById('btn-open-certificate-upload');
        const btnGenerateCertificate = document.getElementById('btn-generate-certificate');
        const btnBackCertificateList = document.getElementById('btn-back-certificate-list');
        const certificateTemplateFile = document.getElementById('certificate-template-file');

        function openCertificateUploadModal() {
            certificateUploadModal.classList.add('active');
            document.body.classList.add('modal-open');
        }

        function closeCertificateUploadModal() {
            certificateUploadModal.classList.remove('active');
            document.body.classList.remove('modal-open');
        }

        if (btnOpenCertificateUpload) {
            btnOpenCertificateUpload.addEventListener('click', openCertificateUploadModal);
        }

        if (btnGenerateCertificate) {
            btnGenerateCertificate.addEventListener('click', showCertificateResult);
        }

        if (btnBackCertificateList) {
            btnBackCertificateList.addEventListener('click', showCertificateList);
        }

        if (certificateTemplateFile) {
            certificateTemplateFile.addEventListener('change', () => {
                document.getElementById('certificate-template-file-name').innerText = certificateTemplateFile.files[0]?.name || '';
            });
        }

        const certificatePreviewName = document.getElementById('certificate-preview-name');
        const certificateNameY = document.getElementById('certificate-name-y');
        const certificateNameSize = document.getElementById('certificate-name-size');
        const certificateNameColor = document.getElementById('certificate-name-color');
        const certificateRealFile = document.getElementById('certificate-real-file');
        certificateRealFile?.addEventListener('change', () => {
            const file = certificateRealFile.files?.[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = event => {
                const image = document.getElementById('certificate-live-preview-image');
                if (image) {
                    image.src = event.target.result;
                    image.hidden = false;
                }
                document.getElementById('certificate-empty-preview')?.remove();
            };
            reader.readAsDataURL(file);
        });
        certificateNameY?.addEventListener('input', () => {
            if (certificatePreviewName) certificatePreviewName.style.top = certificateNameY.value + '%';
            document.getElementById('name-y-output').value = certificateNameY.value + '%';
        });
        certificateNameSize?.addEventListener('input', () => {
            if (certificatePreviewName) certificatePreviewName.style.fontSize = Math.max(12, certificateNameSize.value * .48) + 'px';
            document.getElementById('name-size-output').value = certificateNameSize.value + 'px';
        });
        certificateNameColor?.addEventListener('input', () => {
            if (certificatePreviewName) certificatePreviewName.style.color = certificateNameColor.value;
        });

        // Segment filters toggling inside Events tab
        const segmentButtons = document.querySelectorAll('.segment-btn');
        const btnAddEvent = document.getElementById('btn-add-event');

        segmentButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                segmentButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const filter = btn.getAttribute('data-filter');
                filterEvents(filter);

                // Add Event button should ONLY be visible when on Draft segment
                if (filter === 'draft') {
                    btnAddEvent.style.display = 'flex';
                } else {
                    btnAddEvent.style.display = 'none';
                }
            });
        });

        function filterEvents(status) {
            const cards = document.querySelectorAll('#events-list .event-row-card');
            cards.forEach(card => {
                if(card.getAttribute('data-status') === status) {
                    card.style.display = 'grid';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Form Details Modal
        function openDetailsModal(id) {
            const card = document.querySelector(`.event-row-card[data-id="${id}"]`);
            if(card) {
                document.getElementById('detail-title').innerText = card.getAttribute('data-title');
                document.getElementById('detail-speaker').innerText = card.getAttribute('data-speaker');
                document.getElementById('detail-date').innerText = card.getAttribute('data-display-date');
                document.getElementById('detail-time').innerText = card.getAttribute('data-time') || '10.00 - 12.00';
                const eventType = card.getAttribute('data-event_type') || 'offline';
                document.getElementById('detail-loc-1').innerText = eventType === 'online' ? 'Online' : 'Offline';
                document.getElementById('detail-loc-2').innerText = eventType === 'online'
                    ? 'Zoom Meeting'
                    : (card.getAttribute('data-location') || '-');
                document.getElementById('detail-desc').innerText = card.getAttribute('data-description') || '-';

                document.getElementById('details-modal').classList.add('active');
            }
        }

        function closeDetailsModal() {
            document.getElementById('details-modal').classList.remove('active');
        }

        // Add/Edit Event Modals
        const formModal = document.getElementById('form-modal');

        function toggleEventTypeFields() {
            const type = document.getElementById('form-type').value;
            const zoomRow = document.getElementById('zoom-fields-row');
            const locationInput = document.getElementById('form-location');

            if (type === 'online') {
                zoomRow.style.display = 'flex';
                locationInput.removeAttribute('required');
                document.getElementById('form-zoom-link').setAttribute('required', 'required');
            } else {
                zoomRow.style.display = 'none';
                locationInput.setAttribute('required', 'required');
                document.getElementById('form-zoom-link').removeAttribute('required');
            }
        }

        function togglePriceFree() {
            const priceInput = document.getElementById('form-price');
            const freeCheckbox = document.getElementById('form-price-free');

            if (freeCheckbox.checked) {
                priceInput.value = 0;
                priceInput.readOnly = true;
                priceInput.classList.add('is-readonly');
            } else {
                priceInput.readOnly = false;
                priceInput.classList.remove('is-readonly');
                if (parseInt(priceInput.value) === 0) {
                    priceInput.value = '';
                }
            }
        }

        if(btnAddEvent) {
            btnAddEvent.addEventListener('click', () => {
                document.getElementById('form-modal-title').innerText = "Form Tambah Event";
                document.getElementById('btn-submit-form').innerText = "Add Event";
                document.getElementById('form-id').value = "";
                document.getElementById('form-title').value = "";
                document.getElementById('form-speaker').value = "";
                document.getElementById('form-category').value = "Workshop";
                document.getElementById('form-date').value = "";
                document.getElementById('form-time').value = "10:00";
                document.getElementById('form-type').value = "offline";
                document.getElementById('form-location').value = "";
                document.getElementById('form-zoom-link').value = "";
                document.getElementById('form-zoom-info').value = "";
                document.getElementById('form-quota-max').value = "20";
                document.getElementById('form-quota-used').value = "0";
                document.getElementById('form-status').value = "draft"; // default new to draft
                document.getElementById('form-price').value = "0";
                document.getElementById('form-price-free').checked = true;
                document.getElementById('form-contact-phone').value = "";
                document.getElementById('form-description').value = "";
                document.getElementById('form-materi').value = "";
                const flyerName = document.getElementById('form-flyer-name');
                if (flyerName) flyerName.innerText = "No file chosen";

                toggleEventTypeFields();
                togglePriceFree();
                formModal.classList.add('active');
            });
        }

        function editEvent(id) {
            const card = document.querySelector(`.event-row-card[data-id="${id}"]`);
            if(card) {
                document.getElementById('form-modal-title').innerText = "Form Edit Event";
                document.getElementById('btn-submit-form').innerText = "Save";
                document.getElementById('form-id').value = card.getAttribute('data-id');
                document.getElementById('form-title').value = card.getAttribute('data-title');
                document.getElementById('form-speaker').value = card.getAttribute('data-speaker');
                document.getElementById('form-category').value = card.getAttribute('data-category') || 'Workshop';
                document.getElementById('form-date').value = card.getAttribute('data-date');
                const savedTime = card.getAttribute('data-time') || '10:00';
                const timeMatch = savedTime.match(/([01]?\d|2[0-3])[:.]([0-5]\d)/);
                document.getElementById('form-time').value = timeMatch
                    ? `${timeMatch[1].padStart(2, '0')}:${timeMatch[2]}`
                    : '10:00';
                document.getElementById('form-type').value = card.getAttribute('data-event_type') || 'offline';
                document.getElementById('form-location').value = card.getAttribute('data-location');
                document.getElementById('form-zoom-link').value = card.getAttribute('data-zoom_link');
                document.getElementById('form-zoom-info').value = card.getAttribute('data-zoom_info');
                document.getElementById('form-quota-max').value = card.getAttribute('data-quota_max');
                document.getElementById('form-quota-used').value = card.getAttribute('data-quota_used');
                document.getElementById('form-status').value = card.getAttribute('data-status');
                const price = parseInt(card.getAttribute('data-price') || '0');
                document.getElementById('form-price').value = price;
                document.getElementById('form-price-free').checked = price === 0;
                document.getElementById('form-contact-phone').value = card.getAttribute('data-contact_phone');
                document.getElementById('form-description').value = card.getAttribute('data-description');
                document.getElementById('form-materi').value = card.getAttribute('data-materi');

                toggleEventTypeFields();
                togglePriceFree();
                formModal.classList.add('active');
            }
        }

        function closeFormModal() {
            formModal.classList.remove('active');
        }

        // Finished event Analytics view trigger
        function viewAnalyticsFor(id) {
            activateTab('tab-analytics');
            openAnalyticsDetail(id);
        }

        function showAnalyticsList() {
            const list = document.getElementById('analytics-event-list-screen');
            const detail = document.getElementById('analytics-detail-screen');
            if (list) list.style.display = 'block';
            if (detail) detail.style.display = 'none';
            pageTitle.innerText = 'Analytics';
            pageSubtitle.innerText = 'Pilih event selesai untuk melihat progres';
            pageSubtitle.style.display = 'block';
        }

        function openAnalyticsDetail(id) {
            const list = document.getElementById('analytics-event-list-screen');
            const detail = document.getElementById('analytics-detail-screen');
            if (list) list.style.display = 'none';
            if (detail) detail.style.display = 'flex';
            pageTitle.innerText = 'Detail Analytics';
            loadAnalyticsForEvent(id);
        }

        function loadAnalyticsForEvent(id) {
            if (!id) {
                return;
            }

            const card = document.querySelector(`.event-row-card[data-id="${id}"]`);
            if (card) {
                const title = card.getAttribute('data-title');
                const speaker = card.getAttribute('data-speaker');
                const date = card.getAttribute('data-display-date');
                const time = card.getAttribute('data-time');
                const eventType = card.getAttribute('data-event_type');
                const location = card.getAttribute('data-location');
                const image = card.getAttribute('data-image');
                const flyerUrl = card.getAttribute('data-flyer-url');

                document.getElementById('analytics-event-title').innerText = title;
                document.getElementById('analytics-event-speaker').innerText = speaker;
                document.getElementById('analytics-event-date').innerText = date;
                document.getElementById('analytics-event-loc').innerText = eventType === 'online' ? 'Online (Zoom)' : location;
                document.getElementById('analytics-event-time').innerText = time || '10.00 - 12.00';

                const thumbBg = document.getElementById('analytics-event-thumb').querySelector('.thumbnail-bg');
                thumbBg.className = 'thumbnail-bg';
                thumbBg.removeAttribute('style');
                if (flyerUrl) {
                    thumbBg.style.backgroundImage = `url('${flyerUrl}')`;
                    thumbBg.style.backgroundSize = 'cover';
                    thumbBg.style.backgroundPosition = 'center';
                } else if(image) {
                    thumbBg.classList.add('img-' + image);
                } else {
                    thumbBg.classList.add('placeholder-gradient');
                }
            }

            fetch(`/organizer/events/${id}/analytics`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('analytics-stat-reg').innerText = data.total_registrants;
                document.getElementById('analytics-stat-present').innerText = data.attended_count;
                document.getElementById('analytics-stat-rev').innerText = data.revenue.toLocaleString('id-ID');
                document.getElementById('analytics-stat-rate').innerText = data.attendance_rate + '%';

                const feedbackList = document.getElementById('analytics-feedback-list');
                if (feedbackList) {
                    feedbackList.replaceChildren();
                    if (!data.feedbacks.length) {
                        const empty = document.createElement('div');
                        empty.className = 'feedback-item-card';
                        empty.textContent = 'Belum ada ulasan peserta untuk event ini.';
                        feedbackList.appendChild(empty);
                    } else {
                        data.feedbacks.forEach(feedback => {
                            const card = document.createElement('div');
                            card.className = 'feedback-item-card';
                            const name = document.createElement('h4');
                            name.className = 'feedback-user';
                            name.textContent = feedback.name + ' · ' + '★'.repeat(feedback.rating);
                            const comment = document.createElement('p');
                            comment.className = 'feedback-msg';
                            comment.textContent = feedback.comment;
                            const date = document.createElement('small');
                            date.textContent = feedback.date;
                            card.append(name, comment, date);
                            feedbackList.appendChild(card);
                        });
                    }
                }

                const donutSegment = document.querySelector('.donut-segment');
                const chartNumber = document.querySelector('.chart-number');
                if (donutSegment && chartNumber) {
                    const rate = Math.min(100, Math.max(0, data.attendance_rate));
                    donutSegment.setAttribute('stroke-dasharray', `${rate} ${100 - rate}`);
                    chartNumber.innerText = rate + '%';
                }
            })
            .catch(error => {
                console.error('Error loading analytics:', error);
            });
        }

        // Simple search function
        const searchInput = document.getElementById('search-input');
        if(searchInput) {
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase().trim();
                const isDashboardActive = document.getElementById('nav-dashboard').classList.contains('active');
                const isEventsActive = document.getElementById('nav-events').classList.contains('active');
                const isPresensiActive = document.getElementById('nav-presensi').classList.contains('active');

                if (isDashboardActive) {
                    document.querySelectorAll('.upcoming-list .upcoming-item').forEach(card => {
                        card.style.display = (card.dataset.search || '').includes(query) ? 'flex' : 'none';
                    });
                } else if (isEventsActive) {
                    const cards = document.querySelectorAll('#events-list .event-row-card');
                    const activeSegment = document.querySelector('.segment-btn.active');
                    const currentStatus = activeSegment ? activeSegment.getAttribute('data-filter') : 'aktif';

                    cards.forEach(card => {
                        const title = card.getAttribute('data-title').toLowerCase();
                        const speaker = card.getAttribute('data-speaker').toLowerCase();
                        const status = card.getAttribute('data-status');

                        if (status === currentStatus && (title.includes(query) || speaker.includes(query))) {
                            card.style.display = 'grid';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                } else if (isPresensiActive) {
                    const cards = document.querySelectorAll('#tab-presensi .event-row-card');
                    cards.forEach(card => {
                        const title = card.querySelector('h2').innerText.toLowerCase();
                        const speaker = card.querySelector('.speaker-name').innerText.toLowerCase();

                        if (title.includes(query) || speaker.includes(query)) {
                            card.style.display = 'grid';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            });
        }

        document.getElementById('certificate-attendee-search')?.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.certificate-attendee-panel .certificate-table-row').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(query) ? 'grid' : 'none';
            });
        });

        const flyerInput = document.getElementById('form-flyer');
        if (flyerInput) {
            flyerInput.addEventListener('change', () => {
                document.getElementById('form-flyer-name').innerText = flyerInput.files[0]?.name || 'No file chosen';
            });
        }

        const hashTabMap = {
            '#dashboard': 'tab-dashboard',
            '#events': 'tab-events',
            '#presensi': 'tab-presensi',
            '#analytics': 'tab-analytics',
            '#certificate': 'tab-certificate',
        };

        if (hashTabMap[window.location.hash]) {
            activateTab(hashTabMap[window.location.hash], false);
        } else {
            activateTab('tab-dashboard', false);
        }

        /* eslint-disable no-undef */
        @if($errors->any())
            activateTab('tab-events', false);
            formModal.classList.add('active');
        @endif
        /* eslint-enable no-undef */
    </script>
</body>
</html>
