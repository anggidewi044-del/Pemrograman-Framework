<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pendaftaran - {{ $event->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container registration-management-shell">
        <aside class="sidebar">
            <div class="sidebar-top">
                <a href="{{ route('home') }}" class="sidebar-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="EventRize Logo" class="brand-logo">
                    <span>EVENTRIZE</span>
                </a>
                <div class="user-profile-card">
                    <div class="avatar-container organizer-initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="profile-details">
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <span class="profile-role">Event Organizer</span>
                    </div>
                </div>
                <nav class="sidebar-nav">
                    <a class="nav-item" href="{{ route('organizer.dashboard') }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>Dashboard
                    </a>
                    <a class="nav-item active" href="{{ route('organizer.dashboard') }}#events">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>Events
                    </a>
                    <a class="nav-item" href="{{ route('organizer.events.attendance', $event->id) }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>Presensi
                    </a>
                    <a class="nav-item" href="{{ route('organizer.dashboard') }}#analytics">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"></path></svg>Analytics
                    </a>
                    <a class="nav-item" href="{{ route('organizer.dashboard') }}#certificate">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"></rect><circle cx="8" cy="10" r="2"></circle><path d="M6 16c.7-1.5 3.3-1.5 4 0M13 10h5M13 14h5"></path></svg>Certificate
                    </a>
                </nav>
            </div>
            <div class="sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="logout-btn logout-button-reset">
                        <svg class="logout-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>Logout
                    </button>
                </form>
            </div>
        </aside>
        <main class="main-content registration-management-main">
    <div class="registrations-page">
        <header class="registrations-header">
            <a href="{{ route('organizer.dashboard') }}#events" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            <span class="management-eyebrow">EVENT AKTIF</span>
            <h1>Manajemen Pendaftaran</h1>
            <p>{{ $event->title }} — {{ $event->display_date }}</p>
        </header>

        @if(session('success'))
            <div class="dashboard-alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="dashboard-alert error">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="dashboard-alert info">{{ session('info') }}</div>
        @endif

        <section class="registration-stats">
            <div class="stat-card">
                <span class="stat-number">{{ $event->registrations->count() }}</span>
                <span class="stat-label">Total Pendaftar</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $event->registrations->where('status', 'menunggu_konfirmasi')->count() }}</span>
                <span class="stat-label">Menunggu Konfirmasi</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $event->registrations->where('status', 'menunggu_verifikasi_pembayaran')->count() }}</span>
                <span class="stat-label">Menunggu Verifikasi Pembayaran</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $event->registrations->whereIn('status', ['terdaftar', 'hadir'])->count() }}</span>
                <span class="stat-label">Terdaftar</span>
            </div>
        </section>

        <section class="status-tabs">
            @foreach($tabs as $t)
                <a href="{{ route('organizer.events.registrations', ['eventId' => $event->id, 'tab' => $t]) }}"
                   class="status-tab {{ $tab === $t ? 'active' : '' }}">
                    {{ $t }}
                </a>
            @endforeach
        </section>

        <section class="registrations-table-container">
            <div class="table-toolbar">
                <div>
                    <h2>Daftar Peserta</h2>
                    <p>Kelola persetujuan peserta dan verifikasi pembayaran.</p>
                </div>
                <div class="registration-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-4-4"></path></svg>
                    <input type="search" id="registration-search" placeholder="Cari nama atau email">
                </div>
            </div>
            <table class="registrations-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $registration->name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>
                                <span class="status-badge {{ $registration->status }}">
                                    {{ str_replace('_', ' ', ucfirst($registration->status)) }}
                                </span>
                            </td>
                            <td>{{ $registration->created_at->format('d M Y H:i') }}</td>
                            <td class="actions">
                                @if($tab === 'Menunggu Konfirmasi' && $event->price <= 0 && $registration->status === 'menunggu_konfirmasi')
                                    <form action="{{ route('organizer.registrations.approve', $registration->id) }}" method="POST" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn-action-approve">Konfirmasi</button>
                                    </form>
                                    <button type="button" class="btn-action-reject" onclick="openRejectModal({{ $registration->id }})">Tolak</button>
                                @elseif($tab === 'Menunggu Verifikasi Pembayaran' && $event->price > 0 && $registration->status === 'menunggu_verifikasi_pembayaran')
                                    @if($registration->payment_proof_path)
                                        <a href="{{ $registration->payment_proof_url }}" target="_blank" rel="noopener" class="btn-proof-payment">Lihat Bukti Pembayaran</a>
                                    @endif
                                    <form action="{{ route('organizer.registrations.verify-payment', $registration->id) }}" method="POST" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn-action-verify">Konfirmasi</button>
                                    </form>
                                    <button type="button" class="btn-action-reject" onclick="openRejectModal({{ $registration->id }})">Tolak</button>
                                @elseif($tab === 'Ditolak' && $registration->status === 'ditolak')
                                    <span class="rejection-reason">{{ $registration->rejection_reason }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-cell">Tidak ada pendaftaran pada kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>

        </main>
    </div>

    <!-- Reject Modal -->
    <div class="modal-overlay" id="reject-modal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Tolak Pendaftaran</h3>
                <button type="button" class="btn-close-x" onclick="closeRejectModal()">&times;</button>
            </div>
            <form id="reject-form" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="rejection_reason">Alasan Penolakan <span class="asterisk">*</span></label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn-action-reject">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(registrationId) {
            const form = document.getElementById('reject-form');
            form.action = '{{ url("/organizer/registrations") }}/' + registrationId + '/reject';
            document.getElementById('reject-modal').classList.add('active');
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.remove('active');
        }

        document.getElementById('registration-search')?.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            document.querySelectorAll('.registrations-table tbody tr').forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
