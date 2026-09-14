<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Presensi</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .header p {
            margin: 0;
            font-size: 11px;
            color: #64748b;
        }

        /* Filter Box */
        .filter-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 14px;
        }
        .filter-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 6px;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .filter-table {
            width: 100%;
            border-collapse: collapse;
        }
        .filter-table td {
            padding: 2px 4px;
            font-size: 10px;
        }
        .filter-label {
            font-weight: 600;
            color: #475569;
            width: 130px;
        }
        .filter-val {
            color: #0f172a;
        }

        /* Summary Stats */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .summary-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: center;
        }
        .summary-card .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .summary-card .number {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }

        /* Main Data Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-hadir { background: #dcfce7; color: #166534; }
        .badge-terlambat { background: #fef3c7; color: #92400e; }
        .badge-izin { background: #ede9fe; color: #5b21b6; }
        .badge-sakit { background: #fee2e2; color: #991b1b; }

        .signature {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
        }
        .signature .date {
            font-size: 10px;
            color: #475569;
            margin-bottom: 50px;
        }
        .signature .name {
            font-weight: bold;
            text-decoration: underline;
            color: #0f172a;
        }
        .signature .title {
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Data Presensi Karyawan</h1>
        <p>Sistem Informasi Manajemen Presensi & Kehadiran Terintegrasi</p>
    </div>

    <!-- Kotak Informasi Filter Aktif (Requirement 5.8) -->
    <div class="filter-box">
        <div class="filter-title">Parameter Filter & Kriteria Laporan</div>
        <table class="filter-table">
            <tr>
                <td class="filter-label">Tanggal Cetak:</td>
                <td class="filter-val">{{ now()->translatedFormat('l, d F Y H:i') }} WIB</td>
                <td class="filter-label">Dicetak Oleh:</td>
                <td class="filter-val">{{ auth()->user()?->name ?? 'Administrator' }}</td>
            </tr>
            @if (!empty($appliedFilters))
                @foreach ($appliedFilters as $filterName => $filterVal)
                    <tr>
                        <td class="filter-label">{{ $filterName }}:</td>
                        <td class="filter-val" colspan="3"><strong>{{ $filterVal }}</strong></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="filter-label">Filter Aktif:</td>
                    <td class="filter-val" colspan="3">Semua Data (Tanpa Kriteria Filter)</td>
                </tr>
            @endif
        </table>
    </div>

    <!-- Ringkasan Statistik -->
    <table class="summary-table">
        <tr>
            <td class="summary-card" style="border-left: 3px solid #2563eb;">
                <div class="label">Total Catatan</div>
                <div class="number">{{ $summary['total'] }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #16a34a;">
                <div class="label">Hadir Tepat Waktu</div>
                <div class="number" style="color:#16a34a;">{{ $summary['hadir'] }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #d97706;">
                <div class="label">Terlambat</div>
                <div class="number" style="color:#d97706;">{{ $summary['terlambat'] }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #7c3aed;">
                <div class="label">Izin</div>
                <div class="number" style="color:#7c3aed;">{{ $summary['izin'] }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #dc2626;">
                <div class="label">Sakit</div>
                <div class="number" style="color:#dc2626;">{{ $summary['sakit'] }}</div>
            </td>
        </tr>
    </table>

    <!-- Tabel Data Presensi -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th style="width: 40px; text-align: center;">ID</th>
                <th>Nama Karyawan</th>
                <th>Email</th>
                <th style="width: 75px;">Tanggal</th>
                <th style="width: 55px; text-align: center;">Check-in</th>
                <th style="width: 55px; text-align: center;">Check-out</th>
                <th style="width: 70px; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center; color: #64748b;">#{{ $item->id }}</td>
                    <td style="font-weight: bold;">{{ $item->user?->name ?? 'User #' . $item->user_id }}</td>
                    <td style="color: #64748b;">{{ $item->user?->email ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                    <td style="text-align: center;">
                        {{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('H:i') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        {{ $item->time_out ? \Carbon\Carbon::parse($item->time_out)->format('H:i') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        @php
                            $badgeStyle = match(strtolower($item->status)) {
                                'hadir' => 'badge-hadir',
                                'terlambat' => 'badge-terlambat',
                                'izin' => 'badge-izin',
                                'sakit' => 'badge-sakit',
                                default => 'badge-hadir',
                            };
                        @endphp
                        <span class="badge {{ $badgeStyle }}">{{ $item->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #94a3b8; padding: 20px;">
                        Tidak ada data presensi yang ditemukan berdasarkan filter yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Pengesahan -->
    <div class="signature">
        <div class="date">{{ now()->translatedFormat('d F Y') }}</div>
        <div class="name">{{ auth()->user()?->name ?? 'Penanggung Jawab' }}</div>
        <div class="title">Bagian Kepegawaian / HRD</div>
    </div>

</body>
</html>