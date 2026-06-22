<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $registration->event->title }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            background: #fff;
        }
        .certificate {
            width: 297mm;
            height: 210mm;
            padding: 40mm;
            border: 12px solid #3b82f6;
            text-align: center;
            position: relative;
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 15mm;
            left: 15mm;
            right: 15mm;
            bottom: 15mm;
            border: 2px solid #93c5fd;
        }
        .logo {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }
        .header-title {
            font-size: 42px;
            font-weight: bold;
            color: #3b82f6;
            margin: 0 0 8px;
            letter-spacing: 4px;
        }
        .subtitle {
            font-size: 18px;
            color: #64748b;
            margin: 0 0 30px;
        }
        .line {
            width: 120px;
            height: 2px;
            background: #3b82f6;
            margin: 0 auto 30px;
        }
        .label {
            font-size: 18px;
            color: #475569;
            margin-bottom: 8px;
        }
        .recipient {
            font-size: 46px;
            font-weight: bold;
            color: #1e293b;
            margin: 0 0 20px;
            border-bottom: 2px solid #3b82f6;
            display: inline-block;
            padding: 0 40px 10px;
        }
        .event-title {
            font-size: 28px;
            font-weight: bold;
            color: #1e293b;
            margin: 20px 0 10px;
        }
        .event-meta {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 40px;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 50px;
            padding: 0 40px;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            width: 160px;
            height: 1px;
            background: #1e293b;
            margin: 60px auto 8px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 16px;
            margin: 0;
        }
        .signature-role {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        .certificate-number {
            position: absolute;
            bottom: 20mm;
            right: 25mm;
            font-size: 12px;
            color: #94a3b8;
        }
        .template-background { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 1; }
        .template-recipient { position: absolute; top: 47%; left: 12%; right: 12%; z-index: 2; color: #1e293b; font-family: Arial, sans-serif; font-size: 42px; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <div class="certificate">
        @if($registration->event->certificate_template_path)
        <img src="{{ storage_path('app/public/' . $registration->event->certificate_template_path) }}" class="template-background">
        <div class="template-recipient" style="top:{{ $registration->event->certificate_name_y ?? 47 }}%;font-size:{{ $registration->event->certificate_name_size ?? 42 }}px;color:{{ $registration->event->certificate_name_color ?? '#1e293b' }}">{{ $registration->name }}</div>
        <span class="certificate-number" style="z-index:2">No. {{ strtoupper(substr($registration->certificate_token, 0, 12)) }}</span>
        @else
        <img src="{{ public_path('images/logo.png') }}" alt="EventRize" class="logo">
        <h1 class="header-title">SERTIFIKAT</h1>
        <p class="subtitle">Penghargaan Partisipasi</p>
        <div class="line"></div>

        <p class="label">Diberikan kepada</p>
        <p class="recipient">{{ Auth::user()->name }}</p>

        <p class="label">Atas partisipasinya sebagai peserta dalam</p>
        <p class="event-title">{{ $registration->event->title }}</p>
        <p class="event-meta">
            yang diselenggarakan oleh <strong>EventRize</strong><br>
            pada tanggal {{ $registration->event->display_date }}
            @if($registration->event->isOffline)
                di {{ $registration->event->location }}
            @else
                secara online
            @endif
        </p>

        <div class="footer">
            <div class="signature">
                <div class="signature-line"></div>
                <p class="signature-name">Abdillah</p>
                <p class="signature-role">Ketua Penyelenggara</p>
            </div>
        </div>

        <span class="certificate-number">No. {{ strtoupper(substr($registration->certificate_token, 0, 12)) }}</span>
        @endif
    </div>
</body>
</html>
