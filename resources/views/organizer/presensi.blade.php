<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi - {{ $event->title }} | EventRize</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/presensi.css') }}">
</head>
<body class="presensi-page">
    <div class="dashboard-container">
        <aside class="sidebar">
    <div class="sidebar-top">

        <a href="/" class="sidebar-brand">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="EventRize Logo"
                class="brand-logo"
            >
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

            <a class="nav-item" href="{{ route('organizer.dashboard') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                Dashboard
            </a>

            <a class="nav-item" href="{{ route('organizer.dashboard') }}#events">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Events
            </a>

            <a class="nav-item active" href="{{ route('organizer.events.attendance', $event->id) }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Presensi
            </a>

            <a class="nav-item" href="{{ route('organizer.dashboard') }}#analytics">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                Analytics
            </a>

            <a class="nav-item" href="{{ route('organizer.dashboard') }}#certificate">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                    <circle cx="8" cy="10" r="2"></circle>
                    <path d="M6 16c.7-1.5 3.3-1.5 4 0"></path>
                    <line x1="13" y1="10" x2="18" y2="10"></line>
                    <line x1="13" y1="14" x2="18" y2="14"></line>
                </svg>
                Certificate
            </a>

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

        <main class="main-content">
            <a href="{{ route('organizer.dashboard') }}#presensi" class="back-link presensi-back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            <section class="attendance-header">
                <div>
                    <h1>PRESENSI</h1>
                    <p class="attendance-breadcrumb">Presensi &gt; {{ $event->title }}</p>
                </div>

                <div class="attendance-actions">
                    <form action="{{ route('organizer.events.attendance.toggle', $event->id) }}" method="POST">
                        @csrf
                        <button class="attendance-pill-btn" type="submit">
                            {{ $event->attendance_open ? 'Tutup Sesi Presensi' : 'Buka Sesi Presensi' }}
                        </button>
                    </form>
                    <a href="{{ route('organizer.events.attendance.export', $event->id) }}" class="attendance-pill-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M12 3v12"></path>
                            <path d="M7 8l5-5 5 5"></path>
                            <path d="M5 15v4h14v-4"></path>
                        </svg>
                        Export Data
                    </a>
                    @if($event->isOffline)
                        <button type="button" class="attendance-pill-btn" id="btn-open-qr" {{ !$event->attendance_open ? 'disabled' : '' }}>
                            Scan QR Code
                        </button>
                        <button class="attendance-manual-btn" type="button" id="btn-open-manual" {{ !$event->attendance_open ? 'disabled' : '' }}>
                            Presensi Manual
                        </button>
                    @else
                        <span class="attendance-online-hint">Peserta check-in melalui akun masing-masing</span>
                    @endif
                </div>
            </section>

            @if(session('success'))
                <div class="attendance-alert">{{ session('success') }}</div>
            @endif

            @if(session('checkin_result'))
                <div class="attendance-alert {{ session('checkin_result.success') ? '' : 'error' }}">
                    {{ session('checkin_result.message') }}
                </div>
            @endif

            @if($errors->any())
                <div class="attendance-alert error">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="event-summary">
                <h2>{{ $event->title }}</h2>
                <div class="event-meta-line">
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                            <path d="M16 3v4M8 3v4M3 10h18"></path>
                        </svg>
                        {{ $formattedDate }}
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"></path>
                        </svg>
                        {{ $event->location }}
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a10 10 0 1 0 .01 0zM13 7v5.15l3.8 2.25-1 1.7-4.8-2.85V7h2z"></path>
                        </svg>
                        {{ $event->time ?? '10.00 - 12.00' }}
                    </span>
                </div>
            </section>

            <section class="attendance-stats">
                <article class="attendance-stat-card">
                    <h3>PARTICIPANT</h3>
                    <strong>{{ $participantCount }}</strong>
                </article>
                <article class="attendance-stat-card">
                    <h3>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="3" width="14" height="18"></rect>
                            <path d="M8 11l2 2 4-5"></path>
                        </svg>
                        PRESENT
                    </h3>
                    <strong>{{ $presentCount }}</strong>
                </article>
                <article class="attendance-stat-card">
                    <h3>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="3" width="14" height="18"></rect>
                            <path d="M9 9l5 5M14 9l-5 5"></path>
                        </svg>
                        ABSENT
                    </h3>
                    <strong>{{ $absentCount }}</strong>
                </article>
            </section>

            <section class="attendance-table-card">
                <div class="attendance-search-row">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="M20 20l-4-4"></path>
                    </svg>
                    <input type="text" id="attendance-search" placeholder="Cari Peserta" autocomplete="off">
                </div>

                <div class="attendance-table-wrap">
                    <table class="attendance-table" id="attendance-table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Peserta</th>
                                <th>Email</th>
                                <th>Waktu Presensi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $index => $registration)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $registration->name }}</td>
                                    <td><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a></td>
                                    <td>{{ $registration->check_in_time ? str_replace(':', '.', $registration->check_in_time) : '-' }}</td>
                                    <td>{{ $registration->status === 'hadir' ? 'Present' : ucfirst($registration->status) }}</td>
                                </tr>
                            @empty
                                <tr class="empty-row">
                                    <td colspan="5">Belum ada peserta terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div class="manual-modal-overlay" id="manual-modal" aria-hidden="true">
        <div class="manual-modal" role="dialog" aria-modal="true" aria-labelledby="manual-modal-title">
            <div class="manual-modal-header">
                <h2 id="manual-modal-title">Presensi Manual</h2>
                <button type="button" class="manual-modal-close" id="btn-close-manual" aria-label="Tutup modal">&times;</button>
            </div>

            <form action="{{ route('organizer.events.attendance.manual', $event->id) }}" method="POST" class="manual-form">
                @csrf
                <label class="manual-field">
                    <span>Name <b>*</b></span>
                    <input type="text" name="name" placeholder="contoh: Abdillah Aryo Bayu" value="{{ old('name') }}" required>
                </label>

                <label class="manual-field">
                    <span>Kode <b>*</b></span>
                    <input type="email" name="email" placeholder="contoh: TCKT - 25APR - 234" value="{{ old('email') }}" required>
                </label>

                <div class="manual-field-grid">
                    <label class="manual-field">
                        <span>Date <b>*</b></span>
                        <input type="date" name="check_in_date" value="{{ old('check_in_date', now()->toDateString()) }}" required>
                    </label>

                    <label class="manual-field">
                        <span>Time <b>*</b></span>
                        <input type="time" name="check_in_time" value="{{ old('check_in_time', now()->format('H:i')) }}" required>
                    </label>
                </div>

                <button type="submit" class="manual-submit">SUBMIT</button>
            </form>
        </div>
    </div>

    <div class="manual-modal-overlay compact" id="qr-modal" aria-hidden="true">
        <div class="manual-modal qr-modal" role="dialog" aria-modal="true" aria-labelledby="qr-modal-title">
            <div class="manual-modal-header">
                <h2 id="qr-modal-title">Scan QR Code</h2>
                <button type="button" class="manual-modal-close" id="btn-close-qr" aria-label="Tutup modal">&times;</button>
            </div>
            <div class="inline-qr-scanner">
                <div id="inline-qr-reader"></div>
                <p id="inline-scanner-status">Kamera akan aktif otomatis.</p>
                <form action="{{ route('organizer.events.attendance.scan', $event->id) }}" method="POST" id="inline-scan-form">
                    @csrf
                    <input type="hidden" name="qr_code" id="inline-qr-token">
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        const manualModal = document.getElementById('manual-modal');
        const qrModal = document.getElementById('qr-modal');
        const searchInput = document.getElementById('attendance-search');
        const scannerStatus = document.getElementById('inline-scanner-status');
        let inlineScanner = null;
        let scannerRunning = false;
        let scanSubmitted = false;

        async function startInlineScanner() {
            if (!qrModal || scannerRunning) return;
            scanSubmitted = false;

            if (typeof Html5Qrcode === 'undefined') {
                scannerStatus.textContent = 'Komponen pemindai gagal dimuat. Periksa koneksi internet lalu muat ulang halaman.';
                return;
            }

            inlineScanner = inlineScanner || new Html5Qrcode('inline-qr-reader');
            scannerStatus.textContent = 'Meminta izin kamera...';
            try {
                const cameras = await Html5Qrcode.getCameras();
                if (!cameras.length) throw new Error('Kamera tidak ditemukan');
                const preferredCamera = cameras.find(camera => /back|rear|environment/i.test(camera.label)) || cameras[0];
                await inlineScanner.start(
                    preferredCamera.id,
                    { fps: 12, qrbox: { width: 240, height: 240 }, aspectRatio: 1 },
                    async (decodedText) => {
                        if (scanSubmitted) return;
                        scanSubmitted = true;
                        scannerStatus.textContent = 'QR terdeteksi. Memproses kehadiran...';
                        document.getElementById('inline-qr-token').value = decodedText;
                        try { await stopInlineScanner(); } catch (error) {}
                        document.getElementById('inline-scan-form').requestSubmit();
                    },
                    () => {}
                );
                scannerRunning = true;
                scannerStatus.textContent = 'Kamera aktif. Arahkan QR peserta ke kotak pemindai.';
            } catch (error) {
                scannerRunning = false;
                scannerStatus.textContent = 'Kamera tidak dapat dibuka. Berikan izin kamera dan gunakan localhost atau HTTPS.';
            }
        }

        async function stopInlineScanner() {
            if (inlineScanner && scannerRunning) {
                await inlineScanner.stop();
                scannerRunning = false;
            }
        }

        function openModal(modal) {
            if (!modal) return;
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
        }

        function closeModal(modal) {
            if (!modal) return;
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
        }

        document.getElementById('btn-open-manual')?.addEventListener('click', () => openModal(manualModal));
        document.getElementById('btn-close-manual')?.addEventListener('click', () => closeModal(manualModal));
        document.getElementById('btn-open-qr')?.addEventListener('click', () => {
            openModal(qrModal);
            startInlineScanner();
        });
        document.getElementById('btn-close-qr')?.addEventListener('click', async () => {
            await stopInlineScanner();
            closeModal(qrModal);
        });

        [manualModal, qrModal].forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    if (modal === qrModal) stopInlineScanner();
                    closeModal(modal);
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal(manualModal);
                stopInlineScanner();
                closeModal(qrModal);
            }
        });

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('#attendance-table tbody tr').forEach((row) => {
                row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        });

        /* eslint-disable no-undef */
        @if($errors->any())
            openModal(manualModal);
        @endif
        /* eslint-enable no-undef */
    </script>
</body>
</html>
