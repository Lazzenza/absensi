<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --success: #16a34a;
            --success-light: #dcfce7;
            --warning: #d97706;
            --warning-light: #fef3c7;
            --info: #0284c7;
            --info-light: #e0f2fe;
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
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
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

        /* Topbar */
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
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }
        .brand-text h1 {
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: -0.02em;
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
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            color: var(--primary);
            background-color: var(--primary-light);
        }
        .nav-link.active {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .user-info {
            text-align: right;
            display: none;
        }
        @media (min-width: 640px) {
            .user-info { display: block; }
        }
        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
        }
        .user-role {
            font-size: 11px;
            color: var(--gray-500);
        }
        .btn-logout {
            padding: 8px 16px;
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid #fecaca;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        /* Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            border-radius: var(--radius);
            padding: 28px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.25);
        }
        .welcome-text h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }
        .welcome-text p {
            font-size: 14px;
            color: #bfdbfe;
        }
        .banner-btn {
            background: white;
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
            transition: transform 0.2s;
        }
        .banner-btn:hover {
            transform: scale(1.03);
        }

        /* Summary Cards */
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
            letter-spacing: 0.04em;
            color: var(--gray-500);
            margin-bottom: 8px;
        }
        .stat-val {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
        }

        /* Grid Charts & Today */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        @media (min-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr 1.3fr;
            }
        }

        .card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
        }
        .card-body {
            padding: 22px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th {
            background: var(--gray-50);
            color: var(--gray-500);
            font-weight: 600;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--gray-200);
            color: var(--dark);
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-hadir { background: var(--success-light); color: #166534; }
        .badge-terlambat { background: var(--warning-light); color: #92400e; }
        .badge-izin { background: var(--purple-light); color: #5b21b6; }
        .badge-sakit { background: var(--danger-light); color: #991b1b; }

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
                <a href="{{ route('dashboard') }}" class="nav-link active">Dashboard</a>
                <a href="{{ route('attendances.index') }}" class="nav-link">Data Presensi</a>
                <a href="{{ route('reports.index') }}" class="nav-link">Laporan</a>
            </nav>

            <div class="user-nav">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()?->name ?? 'Pengguna' }}</div>
                    <div class="user-role">{{ auth()->user()?->email ?? 'admin@presensi.com' }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Hero Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h2>Selamat Datang di PresensiApp</h2>
                <p>Pantau kehadiran karyawan, filter presensi, dan unduh laporan resmi secara real-time.</p>
            </div>
            <div>
                <a href="{{ route('attendances.index') }}" class="banner-btn">Kelola Presensi Sekarang →</a>
            </div>
        </div>

        <!-- Metric Cards -->
        <section class="summary-grid">
            <div class="stat-card">
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-val">{{ $totalUsers }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Presensi</div>
                <div class="stat-val" style="color: var(--primary);">{{ $totalPresensi }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Hadir Tepat Waktu</div>
                <div class="stat-val" style="color: var(--success);">{{ $hadir }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Terlambat</div>
                <div class="stat-val" style="color: var(--warning);">{{ $terlambat }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Izin / Sakit</div>
                <div class="stat-val" style="color: var(--purple);">{{ $izin + $sakit }}</div>
            </div>
        </section>

        <!-- Charts & Today's Attendance Grid (Requirement Bonus 6) -->
        <div class="content-grid">
            <!-- Visual Chart Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">📊 Visualisasi Distribusi Kehadiran</h3>
                </div>
                <div class="card-body">
                    <div style="max-width: 320px; margin: 0 auto;">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Today's Attendance Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">🕒 Presensi Hari Ini ({{ \Carbon\Carbon::today()->translatedFormat('d M Y') }})</h3>
                    <span style="font-size: 12px; color: var(--gray-500);">{{ $todayRecords->count() }} orang tercatat</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todayRecords as $record)
                                <tr>
                                    <td>
                                        <strong>{{ $record->user?->name ?? 'User #' . $record->user_id }}</strong>
                                    </td>
                                    <td>{{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('H:i') : '-' }}</td>
                                    <td>{{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('H:i') : '-' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match(strtolower($record->status)) {
                                                'hadir' => 'badge-hadir',
                                                'terlambat' => 'badge-terlambat',
                                                'izin' => 'badge-izin',
                                                'sakit' => 'badge-sakit',
                                                default => 'badge-hadir',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $record->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; color: var(--gray-500); padding: 30px;">
                                        Belum ada data presensi yang tercatat untuk hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Sistem Presensi & Laporan Presensi — Magang Laravel 12.</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir Tepat Waktu', 'Terlambat', 'Izin', 'Sakit'],
                    datasets: [{
                        data: [{{ $hadir }}, {{ $terlambat }}, {{ $izin }}, {{ $sakit }}],
                        backgroundColor: ['#16a34a', '#d97706', '#7c3aed', '#dc2626'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { family: 'Plus Jakarta Sans', size: 12 }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>

</body>
</html>
