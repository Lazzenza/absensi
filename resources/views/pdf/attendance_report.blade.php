<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi Peserta Magang Bappeda DKI Jakarta</title>
    <style>
        @page {
            margin: 15mm 12mm 15mm 12mm;
            size: A4 landscape;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #0b1c30;
            line-height: 1.35;
        }
        .header {
            text-align: center;
            margin-bottom: 8px;
        }
        .header-title-gov {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .header-title-dept {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 2px 0;
        }
        .header-desc {
            font-size: 9px;
            color: #334155;
            margin: 1px 0;
        }
        .divider-thick {
            width: 100%;
            height: 2.5px;
            background-color: #000000;
            margin-top: 6px;
        }
        .divider-thin {
            width: 100%;
            height: 0.75px;
            background-color: #000000;
            margin-top: 1.5px;
            margin-bottom: 12px;
        }
        .doc-title-container {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            color: #00173b;
            margin: 0;
        }
        .doc-subtitle {
            font-size: 9px;
            color: #44474f;
            margin-top: 2px;
        }

        /* 2-Column Info Grid */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #eff4ff;
            border: 1px solid #dce9ff;
            margin-bottom: 12px;
        }
        .info-table td {
            padding: 4px 8px;
            font-size: 9.5px;
        }
        .info-label {
            font-weight: bold;
            color: #44474f;
            width: 120px;
        }
        .info-value {
            color: #0b1c30;
            font-weight: 600;
        }

        /* Summary Stats Cards */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .summary-card {
            background-color: #ffffff;
            border: 1px solid #c4c6d0;
            padding: 6px 8px;
            text-align: center;
            width: 16.6%;
        }
        .summary-card .label {
            font-size: 8px;
            text-transform: uppercase;
            color: #44474f;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .summary-card .value {
            font-size: 13px;
            font-weight: bold;
            color: #00173b;
        }
        .summary-card .sub {
            font-size: 7.5px;
            color: #747780;
        }

        /* Main Data Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #c4c6d0;
            padding: 5px 6px;
            text-align: left;
            font-size: 9px;
        }
        table.data-table th {
            background-color: #00173b;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #eff4ff;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 1.5px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-hadir { background-color: #ecfdf5; color: #047857; }
        .badge-terlambat { background-color: #fffbeb; color: #b45309; }
        .badge-izin { background-color: #eff6ff; color: #0051d5; }
        .badge-sakit { background-color: #fef2f2; color: #ba1a1a; }

        /* Signatures */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .signature-cell {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }
        .signature-space {
            height: 48px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            color: #00173b;
            font-size: 10px;
        }
        .signature-meta {
            font-size: 8.5px;
            color: #44474f;
        }
    </style>
</head>
<body>

    <!-- KOP RESMI PEMPROV DKI JAKARTA -->
    <div class="header">
        <h2 class="header-title-gov">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</h2>
        <h1 class="header-title-dept">BADAN PERENCANAAN PEMBANGUNAN DAERAH</h1>
        <p class="header-desc">Gedung Balai Kota Blok G Lantai 2, Jl. Medan Merdeka Selatan No. 8–9, Jakarta Pusat 10110</p>
        <p class="header-desc">Telepon: (021) 3822208 • Pos-el: bappeda@jakarta.go.id • Laman: bappeda.jakarta.go.id</p>
    </div>

    <!-- Garis Ganda Khas Surat Dinas RI -->
    <div class="divider-thick"></div>
    <div class="divider-thin"></div>

    <!-- Judul Dokumen -->
    <div class="doc-title-container">
        <h2 class="doc-title">LAPORAN PRESENSI PESERTA MAGANG</h2>
        <p class="doc-subtitle">Nomor Registrasi Laporan: 800.1/BAPPEDA-PPIP/PRES/{{ strtoupper(date('M')) }}/2026</p>
    </div>

    <!-- Info Table Grid -->
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Peserta</td>
            <td>:</td>
            <td class="info-value">{{ auth()->user()?->name ?? 'Rachmat Akbar' }}</td>
            <td class="info-label">Periode Laporan</td>
            <td>:</td>
            <td class="info-value">13 Juli 2026 s.d. 30 Desember 2026</td>
        </tr>
        <tr>
            <td class="info-label">NIM / ID Magang</td>
            <td>:</td>
            <td class="info-value">102042300209 (MG-2026-0842)</td>
            <td class="info-label">Tahun Anggaran</td>
            <td>:</td>
            <td class="info-value">2026</td>
        </tr>
        <tr>
            <td class="info-label">Unit Penempatan</td>
            <td>:</td>
            <td class="info-value">Bidang Perencanaan Pembangunan & PPIP</td>
            <td class="info-label">Kriteria Filter</td>
            <td>:</td>
            <td class="info-value">
                @if(!empty($appliedFilters))
                    @foreach($appliedFilters as $k => $v)
                        {{ $k }}: {{ $v }}@if(!$loop->last), @endif
                    @endforeach
                @else
                    Semua Data Presensi (Aktif)
                @endif
            </td>
        </tr>
        <tr>
            <td class="info-label">Pembimbing Lapangan</td>
            <td>:</td>
            <td class="info-value">Dhayani Ardyan, S.STP, M.Si</td>
            <td class="info-label">Waktu Cetak</td>
            <td>:</td>
            <td class="info-value">{{ now()->translatedFormat('l, d F Y H:i') }} WIB</td>
        </tr>
    </table>

    <!-- Ringkasan Statistik Akumulasi -->
    <table class="summary-table">
        <tr>
            <td class="summary-card" style="border-left: 3px solid #00173b;">
                <div class="label">Total Hari Kerja</div>
                <div class="value">{{ $summary['total'] }}</div>
                <div class="sub">Hari Berjalan</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #047857;">
                <div class="label">Hadir Tepat</div>
                <div class="value" style="color:#047857;">{{ $summary['hadir'] }}</div>
                @php
                    $rateH = $summary['total'] > 0 ? round(($summary['hadir'] / $summary['total']) * 100, 1) : 0;
                @endphp
                <div class="sub">{{ $rateH }}%</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #b45309;">
                <div class="label">Terlambat</div>
                <div class="value" style="color:#b45309;">{{ $summary['terlambat'] }}</div>
                @php
                    $rateT = $summary['total'] > 0 ? round(($summary['terlambat'] / $summary['total']) * 100, 1) : 0;
                @endphp
                <div class="sub">{{ $rateT }}%</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #0051d5;">
                <div class="label">Izin Resmi</div>
                <div class="value" style="color:#0051d5;">{{ $summary['izin'] }}</div>
                @php
                    $rateI = $summary['total'] > 0 ? round(($summary['izin'] / $summary['total']) * 100, 1) : 0;
                @endphp
                <div class="sub">{{ $rateI }}%</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #ba1a1a;">
                <div class="label">Sakit</div>
                <div class="value" style="color:#ba1a1a;">{{ $summary['sakit'] }}</div>
                @php
                    $rateS = $summary['total'] > 0 ? round(($summary['sakit'] / $summary['total']) * 100, 1) : 0;
                @endphp
                <div class="sub">{{ $rateS }}%</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #316bf3;">
                <div class="label">Skor Disiplin</div>
                @php
                    $score = $summary['total'] > 0 ? round((($summary['hadir'] + ($summary['terlambat'] * 0.5)) / $summary['total']) * 100, 1) : 100;
                @endphp
                <div class="value" style="color:#0051d5;">{{ $score }}%</div>
                <div class="sub">Sangat Baik</div>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th style="width: 140px;">Nama Peserta</th>
                <th style="width: 90px;">Tanggal</th>
                <th style="width: 65px; text-align: center;">Check-in</th>
                <th style="width: 65px; text-align: center;">Check-out</th>
                <th style="width: 75px; text-align: center;">Status</th>
                <th>Keterangan / Validasi Kedinasan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $item)
                @php
                    $badgeClass = match(strtolower($item->status)) {
                        'hadir' => 'badge-hadir',
                        'terlambat' => 'badge-terlambat',
                        'izin' => 'badge-izin',
                        'sakit' => 'badge-sakit',
                        default => 'badge-hadir',
                    };
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #00173b;">{{ $item->user?->name ?? 'User #' . $item->user_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd, D MMM Y') }}</td>
                    <td style="text-align: center; font-weight: bold;">
                        {{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('H:i') . ' WIB' : '—' }}
                    </td>
                    <td style="text-align: center; font-weight: bold;">
                        {{ $item->time_out ? \Carbon\Carbon::parse($item->time_out)->format('H:i') . ' WIB' : '—' }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge {{ $badgeClass }}">{{ $item->status }}</span>
                    </td>
                    <td style="color: #44474f;">
                        {{ $item->notes ?? ($item->status === 'Hadir' ? 'Tepat Waktu - Balai Kota Blok G' : ($item->status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Surat keterangan diajukan')) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #747780; padding: 15px;">
                        Tidak ada data presensi yang ditemukan berdasarkan parameter yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Kedinasan -->
    <table class="signature-table">
        <tr>
            <td class="signature-cell">
                <p style="margin: 0 0 2px;">Mengetahui,</p>
                <p style="margin: 0; font-weight: bold; color: #00173b; text-transform: uppercase;">PESERTA MAGANG</p>
                <div class="signature-space"></div>
                <p class="signature-name">{{ auth()->user()?->name ?? 'Rachmat Akbar' }}</p>
                <p class="signature-meta">NIM. 102042300209</p>
            </td>
            <td class="signature-cell">
                <p style="margin: 0 0 2px;">Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                <p style="margin: 0; font-weight: bold; color: #00173b; text-transform: uppercase;">PEMBIMBING LAPANGAN</p>
                <p class="signature-meta" style="margin: 1px 0;">Kepala Subbagian Tata Usaha</p>
                <p class="signature-meta" style="margin: 0;">Bappeda Provinsi DKI Jakarta</p>
                <div class="signature-space"></div>
                <p class="signature-name">Dhayani Ardyan, S.STP, M.Si</p>
                <p class="signature-meta">NIP. 199109222014031003</p>
            </td>
        </tr>
    </table>

</body>
</html>
