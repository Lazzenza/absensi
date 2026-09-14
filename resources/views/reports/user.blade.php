<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi - Detail Presensi {{ $user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --success: #16a34a;
            --success-light: #dcfce7;
            --warning: #d97706;
            --warning-light: #fef3c7;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --purple: #7c3aed;
            --purple-light: #ede9fe;
            --dark: #0f172a;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-500: #64748b;
            --gray-700: #334155;
            --radius: 12px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--gray-700);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 20px;
            width: 100%;
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: var(--shadow-sm);
        }
        .topbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 68px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--dark);
        }
        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
        }
        .brand-text h1 {
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
        }
        .brand-text p {
            font-size: 12px;
            color: var(--gray-500);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-500);
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }
        .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-500);
            margin-bottom: 6px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
        }

        .card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
        }
        .card-body {
            padding: 22px;
        }

        .filters {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 14px;
            align-items: end;
            margin-bottom: 20px;
        }
        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--gray-700);
        }
        .field input, .btn {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            font-size: 14px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }
        .btn-secondary {
            background-color: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }
        .btn-danger {
            background-color: var(--danger);
            color: white;
            border: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th {
            background-color: var(--gray-50);
            color: var(--gray-500);
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 12px;
            text-transform: uppercase;
        }
        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--gray-200);
            color: var(--dark);
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge.hadir { background: var(--success-light); color: #166534; }
        .badge.terlambat { background: var(--warning-light); color: #92400e; }
        .badge.izin { background: var(--purple-light); color: #5b21b6; }
        .badge.sakit { background: var(--danger-light); color: #991b1b; }

        footer {
            margin-top: auto;
            border-top: 1px solid var(--gray-200);
            background: white;
            padding: 20px 0;
            text-align: center;
            font-size: 13px;
            color: var(--gray-500);
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="container topbar-content">
            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-icon">P</div>
                <div class="brand-text">
                    <h1>PresensiApp</h1>
                    <p>Sistem Presensi & Laporan</p>
                </div>
            </a>

            <nav class="nav-links">
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('attendances.index') }}" class="nav-link">Data Presensi</a>
                <a href="{{ route('reports.index') }}" class="nav-link active">Laporan</a>
            </nav>

            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="padding:8px 16px; background:var(--danger-light); color:var(--danger); border:1px solid #fecaca; border-radius:8px; font-weight:600; cursor:pointer;">Keluar</button>
            </form>
        </div>
    </header>

    <main class="container">
        <div style="display: flex; gap: 12px; margin-bottom: 20px; align-items: center; justify-content: space-between;">
            <a href="{{ route('reports.index') }}" class="btn btn-secondary" style="width: auto;">
                ← Kembali ke Ringkasan Laporan
            </a>
            <a href="{{ route('attendances.report.pdf', ['user_id' => $user->id, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-danger" style="width: auto;">
                📄 Cetak PDF Karyawan Ini
            </a>
        </div>

        <!-- Summary Cards -->
        <section class="summary-grid">
            <div class="stat-card">
                <div class="stat-label">Total Presensi</div>
                <div class="stat-value">{{ $summary['total'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Hadir Tepat Waktu</div>
                <div class="stat-value" style="color: var(--success);">{{ $summary['hadir'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Terlambat</div>
                <div class="stat-value" style="color: var(--warning);">{{ $summary['terlambat'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Izin</div>
                <div class="stat-value" style="color: var(--purple);">{{ $summary['izin'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Sakit</div>
                <div class="stat-value" style="color: var(--danger);">{{ $summary['sakit'] }}</div>
            </div>
        </section>

        <!-- Main Card -->
        <section class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Riwayat Presensi: {{ $user->name }}</h2>
                    <p style="font-size: 13px; color: var(--gray-500);">Email: {{ $user->email }}</p>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.user.detail', $user) }}" class="filters">
                    <div class="field">
                        <label for="start_date">Tanggal Awal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="field">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="field">
                        <button type="submit" class="btn btn-primary">Filter Periode</button>
                    </div>
                </form>

                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->translatedFormat('l, d F Y') }}</td>
                                    <td>{{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('H:i') : '-' }}</td>
                                    <td>{{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('H:i') : '-' }}</td>
                                    <td>
                                        <span class="badge {{ strtolower($record->status) }}">{{ $record->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; color: var(--gray-500); padding: 30px;">
                                        Belum ada catatan presensi untuk karyawan ini dalam periode yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Sistem Presensi & Laporan Presensi — Magang Laravel 12.</p>
        </div>
    </footer>

</body>
</html>
