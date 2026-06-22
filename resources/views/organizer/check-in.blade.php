<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in Peserta - EventRize</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="checkin-page">
        <header class="checkin-header">
            <a href="{{ route('organizer.dashboard') }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1>Check-in Peserta</h1>
            <p>Pindai QR code tiket peserta atau masukkan kode QR secara manual.</p>
        </header>

        @if($result)
            <div class="checkin-result {{ $result['success'] ? 'success' : 'error' }}">
                <h3>{{ $result['success'] ? 'Berhasil' : 'Gagal' }}</h3>
                <p>{{ $result['message'] }}</p>
                @if(!empty($result['registration']))
                    <div class="checkin-participant">
                        <strong>{{ $result['registration']['name'] }}</strong>
                        <span>{{ $result['registration']['email'] }}</span>
                        <span>Event: {{ $result['registration']['event'] }}</span>
                    </div>
                @endif
            </div>
        @endif

        <section class="checkin-form-section">
            <form action="{{ route('organizer.check-in.process') }}" method="POST" class="checkin-form" id="qr-checkin-form">
                @csrf
                <div class="form-group-dash">
                    <label for="event_id">Pilih Event</label>
                    <select name="event_id" id="event_id">
                        <option value="">Semua Event Offline Aktif</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $selectedEvent && $selectedEvent->id === $event->id ? 'selected' : '' }}>
                                {{ $event->title }} — {{ $event->display_date }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-dash">
                    <label for="qr_code">Kode QR / Token</label>
                    <input type="text" name="qr_code" id="qr_code" placeholder="Scan QR atau tempel token di sini" required autofocus>
                </div>

                <button type="submit" class="btn-checkin">Proses Check-in</button>
            </form>

            <div class="scanner-hint camera-scanner-card">
                <h2>Scan QR Code</h2>
                <div class="camera-viewport" id="camera-viewport">
                    <video id="qr-camera" playsinline muted></video>
                    <div class="camera-frame" aria-hidden="true"></div>
                    <span class="camera-placeholder" id="camera-placeholder">Kamera belum aktif</span>
                </div>
                <p id="scanner-status">Gunakan kamera belakang untuk memindai QR tiket peserta offline.</p>
                <div class="camera-actions">
                    <button type="button" class="btn-checkin" id="start-scanner">Buka Kamera</button>
                    <button type="button" class="btn-secondary" id="stop-scanner" hidden>Tutup Kamera</button>
                </div>
                <p class="scanner-fallback">Jika kamera tidak didukung, masukkan token QR pada formulir secara manual.</p>
            </div>
        </section>

        @if($selectedEvent)
            <section class="registered-participants">
                <h2>Peserta Terdaftar — {{ $selectedEvent->title }}</h2>
                <table class="registrations-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selectedEvent->registrations()->whereIn('status', ['terdaftar', 'hadir'])->get() as $reg)
                            <tr>
                                <td>{{ $reg->name }}</td>
                                <td>{{ $reg->email }}</td>
                                <td>
                                    <span class="status-badge {{ $reg->status }}">
                                        {{ str_replace('_', ' ', ucfirst($reg->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-cell">Belum ada peserta terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        @endif
    </div>
    <script>
        (() => {
            const video = document.getElementById('qr-camera');
            const startButton = document.getElementById('start-scanner');
            const stopButton = document.getElementById('stop-scanner');
            const status = document.getElementById('scanner-status');
            const placeholder = document.getElementById('camera-placeholder');
            const tokenInput = document.getElementById('qr_code');
            const form = document.getElementById('qr-checkin-form');
            let stream = null;
            let scanning = false;
            let detector = null;

            async function stopScanner() {
                scanning = false;
                stream?.getTracks().forEach(track => track.stop());
                stream = null;
                video.srcObject = null;
                placeholder.hidden = false;
                startButton.hidden = false;
                stopButton.hidden = true;
            }

            async function detectFrame() {
                if (!scanning || !detector) return;
                try {
                    const codes = await detector.detect(video);
                    if (codes.length && codes[0].rawValue) {
                        scanning = false;
                        tokenInput.value = codes[0].rawValue;
                        status.textContent = 'QR terdeteksi. Memproses check-in...';
                        stream?.getTracks().forEach(track => track.stop());
                        form.requestSubmit();
                        return;
                    }
                } catch (error) {
                    // Frame kamera belum siap; lanjutkan pemindaian berikutnya.
                }
                if (scanning) requestAnimationFrame(detectFrame);
            }

            startButton.addEventListener('click', async () => {
                if (!('BarcodeDetector' in window)) {
                    status.textContent = 'Browser ini belum mendukung pemindai QR. Gunakan Chrome terbaru atau input token manual.';
                    return;
                }
                try {
                    detector = new BarcodeDetector({ formats: ['qr_code'] });
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: { ideal: 'environment' } }, audio: false
                    });
                    video.srcObject = stream;
                    await video.play();
                    scanning = true;
                    placeholder.hidden = true;
                    startButton.hidden = true;
                    stopButton.hidden = false;
                    status.textContent = 'Arahkan QR ke dalam kotak. QR akan diproses otomatis.';
                    requestAnimationFrame(detectFrame);
                } catch (error) {
                    status.textContent = 'Kamera tidak dapat dibuka. Pastikan izin kamera diberikan dan halaman menggunakan HTTPS/localhost.';
                    stopScanner();
                }
            });

            stopButton.addEventListener('click', stopScanner);
            window.addEventListener('beforeunload', stopScanner);
        })();
    </script>
</body>
</html>
