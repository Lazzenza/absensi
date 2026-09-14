<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi - Data Presensi</title>
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
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
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

        /* Top Navbar */
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

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-sm);
        }
        .alert-success {
            background-color: var(--success-light);
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .alert-error {
            background-color: var(--danger-light);
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            padding: 18px 20px;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--gray-500);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.1;
        }
        .stat-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-total { background: var(--primary); }
        .dot-hadir { background: var(--success); }
        .dot-terlambat { background: var(--warning); }
        .dot-izin { background: var(--purple); }
        .dot-sakit { background: var(--danger); }

        /* Main Card Layout */
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
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body {
            padding: 22px;
        }

        /* Presence Action Form */
        .action-form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            align-items: end;
        }
        @media (min-width: 768px) {
            .action-form {
                grid-template-columns: 1.5fr 1fr auto;
            }
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 14px;
            color: var(--dark);
            background-color: white;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        .btn-success:hover {
            background-color: #15803d;
        }
        .btn-secondary {
            background-color: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }
        .btn-secondary:hover {
            background-color: var(--gray-200);
        }
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Filter Grid */
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }
        .filter-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding-top: 14px;
            border-top: 1px solid var(--gray-200);
        }
        .btn-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }
        thead th {
            background-color: var(--gray-50);
            color: var(--gray-500);
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tbody tr {
            border-bottom: 1px solid var(--gray-200);
            transition: background-color 0.15s;
        }
        tbody tr:hover {
            background-color: #f8fafc;
        }
        tbody td {
            padding: 14px 16px;
            color: var(--dark);
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .badge-hadir {
            background-color: var(--success-light);
            color: #15803d;
        }
        .badge-terlambat {
            background-color: var(--warning-light);
            color: #b45309;
        }
        .badge-izin {
            background-color: var(--purple-light);
            color: var(--purple);
        }
        .badge-sakit {
            background-color: var(--danger-light);
            color: #b91c1c;
        }

        /* Empty State */
        .empty-state {
            padding: 50px 20px;
            text-align: center;
        }
        .empty-icon {
            width: 56px;
            height: 56px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: var(--gray-500);
            font-size: 24px;
        }
        .empty-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
        }
        .empty-desc {
            font-size: 13px;
            color: var(--gray-500);
            max-width: 400px;
            margin: 0 auto 16px;
        }

        /* Pagination container & Modern UI */
        .pagination-wrap {
            padding: 16px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            background: #ffffff;
            border-bottom-left-radius: var(--radius);
            border-bottom-right-radius: var(--radius);
        }
        .pagination-info {
            font-size: 13px;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .pagination-info strong {
            color: var(--dark);
            font-weight: 700;
        }
        .pagination-nav {
            display: flex;
            align-items: center;
        }
        .pagination-list {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }
        .pagination-list li {
            display: inline-flex;
        }
        .pagination-btn,
        .pagination-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            user-select: none;
            box-sizing: border-box;
        }
        .pagination-btn {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            background: #ffffff;
            color: var(--gray-700);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .pagination-btn:hover:not(.disabled) {
            background: var(--gray-50);
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
            transform: translateY(-1px);
        }
        .pagination-btn.disabled {
            color: var(--gray-300);
            background: var(--gray-50);
            border-color: var(--gray-200);
            cursor: not-allowed;
            opacity: 0.6;
            box-shadow: none;
        }
        .pagination-number {
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid transparent;
            color: var(--gray-700);
            background: transparent;
        }
        .pagination-number:hover:not(.active) {
            background: var(--gray-100);
            color: var(--dark);
        }
        .pagination-number.active {
            background: var(--primary);
            color: #ffffff;
            font-weight: 700;
            border-color: var(--primary);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
        }
        .pagination-dots {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 36px;
            color: var(--gray-500);
            font-weight: 700;
            font-size: 14px;
        }

        /* Fallback if default Laravel pagination is rendered */
        nav[role="navigation"] svg {
            width: 16px;
            height: 16px;
            display: inline-block;
        }

        /* Footer */
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

    <!-- Top Navigation Bar -->
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
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('attendances.index') }}" class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">Data Presensi</a>
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">Laporan</a>
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
        <!-- Notification Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <span>✕</span> {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <div>
                    <strong>Perhatian:</strong>
                    <ul style="margin-left: 20px; margin-top: 4px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Card Input Presensi (Check-in, Check-out, Izin, Sakit) -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <span>⏱️</span> Form Pencatatan Presensi Hari Ini ({{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }})
                </h2>
                <div style="font-size: 13px; color: var(--gray-500);">
                    Batas Jam Hadir Tepat Waktu: <strong>08:00 WIB</strong>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('attendances.store') }}" method="POST" class="action-form">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">Pilih Karyawan / Pengguna</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">-- Pilih Nama Karyawan --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Aksi / Jenis Presensi</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="check_in" {{ old('type') == 'check_in' ? 'selected' : '' }}>🟢 Check-in (Masuk)</option>
                            <option value="check_out" {{ old('type') == 'check_out' ? 'selected' : '' }}>🔴 Check-out (Pulang)</option>
                            <option value="izin" {{ old('type') == 'izin' ? 'selected' : '' }}>🟣 Keterangan Izin</option>
                            <option value="sakit" {{ old('type') == 'sakit' ? 'selected' : '' }}>🟡 Keterangan Sakit</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            Simpan Presensi
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Dynamic Summary Cards (Requirement 5.7) -->
        <section class="summary-grid">
            <div class="stat-card">
                <div class="stat-label">
                    Total Presensi Aktif
                    <span class="stat-dot dot-total"></span>
                </div>
                <div class="stat-value">{{ $summary['total'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">
                    Hadir Tepat Waktu
                    <span class="stat-dot dot-hadir"></span>
                </div>
                <div class="stat-value" style="color: #16a34a;">{{ $summary['hadir'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">
                    Terlambat
                    <span class="stat-dot dot-terlambat"></span>
                </div>
                <div class="stat-value" style="color: #d97706;">{{ $summary['terlambat'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">
                    Izin
                    <span class="stat-dot dot-izin"></span>
                </div>
                <div class="stat-value" style="color: #7c3aed;">{{ $summary['izin'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">
                    Sakit
                    <span class="stat-dot dot-sakit"></span>
                </div>
                <div class="stat-value" style="color: #dc2626;">{{ $summary['sakit'] }}</div>
            </div>
        </section>

        <!-- Card Pencarian, Filter & Sorting (Requirement 5.4) -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <span>🔍</span> Pencarian & Filter Multi-Kriteria
                </h2>
                <div style="font-size: 13px; color: var(--gray-500);">
                    Semua filter dapat dikombinasikan bersamaan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('attendances.index') }}" method="GET">
                    <div class="filter-grid">
                        <!-- Pencarian Nama -->
                        <div class="form-group">
                            <label for="search">Cari Nama User</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Ketik nama..." value="{{ request('search') }}">
                        </div>

                        <!-- Filter User ID -->
                        <div class="form-group">
                            <label for="filter_user_id">Pilih User</label>
                            <select name="user_id" id="filter_user_id" class="form-control">
                                <option value="">Semua Karyawan</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Status -->
                        <div class="form-group">
                            <label for="status">Status Presensi</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal Spesifik -->
                        <div class="form-group">
                            <label for="date">Tanggal Spesifik</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                        </div>

                        <!-- Filter Rentang Tanggal Mulai -->
                        <div class="form-group">
                            <label for="start_date">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>

                        <!-- Filter Rentang Tanggal Selesai -->
                        <div class="form-group">
                            <label for="end_date">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>

                        <!-- Filter Bulan -->
                        <div class="form-group">
                            <label for="month">Bulan</label>
                            <select name="month" id="month" class="form-control">
                                <option value="">Semua Bulan</option>
                                @php
                                    $bulanList = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                @endphp
                                @foreach ($bulanList as $num => $namaBulan)
                                    <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun -->
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            <select name="year" id="year" class="form-control">
                                <option value="">Semua Tahun</option>
                                @for ($y = (int)date('Y') + 1; $y >= 2022; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Sorting Kolom -->
                        <div class="form-group">
                            <label for="sort_by">Urutkan Berdasarkan</label>
                            <select name="sort_by" id="sort_by" class="form-control">
                                <option value="date" {{ request('sort_by', 'date') == 'date' ? 'selected' : '' }}>Tanggal</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama User</option>
                                <option value="time_in" {{ request('sort_by') == 'time_in' ? 'selected' : '' }}>Waktu Check-in</option>
                                <option value="time_out" {{ request('sort_by') == 'time_out' ? 'selected' : '' }}>Waktu Check-out</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                            </select>
                        </div>

                        <!-- Sorting Arah -->
                        <div class="form-group">
                            <label for="sort_direction">Arah Urutan</label>
                            <select name="sort_direction" id="sort_direction" class="form-control">
                                <option value="desc" {{ request('sort_direction', 'desc') == 'desc' ? 'selected' : '' }}>Menurun (Terbaru / Z-A)</option>
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Menaik (Terlama / A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Filter & Reset -->
                    <div class="filter-actions">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <span>🔍</span> Terapkan Filter
                            </button>
                            @if (request()->hasAny(['search', 'user_id', 'date', 'start_date', 'end_date', 'month', 'year', 'status', 'sort_by', 'sort_direction']))
                                <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                                    <span>↺</span> Reset Seluruh Filter
                                </a>
                            @endif
                        </div>

                        <!-- Export Buttons (Requirement 5.8 & Bonus) -->
                        <div class="btn-group">
                            <a href="{{ route('attendances.report.pdf', request()->query()) }}" target="_blank" class="btn btn-danger">
                                <span>📄</span> Export PDF
                            </a>
                            <a href="{{ route('attendances.report.csv', request()->query()) }}" class="btn btn-success">
                                <span>📊</span> Export CSV
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Attendance Data Table (Requirement 5.3 & 5.5) -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <span>📋</span> Tabel Riwayat Presensi
                </h2>
                <span style="font-size: 13px; color: var(--gray-500);">
                    Menampilkan {{ $attendances->firstItem() ?? 0 }} - {{ $attendances->lastItem() ?? 0 }} dari {{ $attendances->total() }} data
                </span>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status Presensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $index => $attendance)
                            <tr>
                                <td style="color: var(--gray-500); font-size: 13px;">
                                    {{ $attendances->firstItem() + $index }}
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--dark);">
                                        {{ $attendance->user?->name ?? 'User #' . $attendance->user_id }}
                                    </div>
                                    <div style="font-size: 12px; color: var(--gray-500);">
                                        {{ $attendance->user?->email ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">
                                        {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    @if ($attendance->time_in)
                                        <span style="font-family: monospace; font-weight: 600; color: #166534;">
                                            {{ \Carbon\Carbon::parse($attendance->time_in)->format('H:i') }}
                                        </span>
                                    @else
                                        <span style="color: var(--gray-500);">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($attendance->time_out)
                                        <span style="font-family: monospace; font-weight: 600; color: #1e40af;">
                                            {{ \Carbon\Carbon::parse($attendance->time_out)->format('H:i') }}
                                        </span>
                                    @else
                                        <span style="color: var(--gray-500);">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match(strtolower($attendance->status)) {
                                            'hadir' => 'badge-hadir',
                                            'terlambat' => 'badge-terlambat',
                                            'izin' => 'badge-izin',
                                            'sakit' => 'badge-sakit',
                                            default => 'badge-hadir',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State (Requirement 5.6) -->
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">📂</div>
                                        <div class="empty-title">Data Presensi Tidak Ditemukan</div>
                                        <div class="empty-desc">
                                            Tidak ada catatan presensi yang sesuai dengan kombinasi pencarian atau filter yang Anda pilih.
                                        </div>
                                        <a href="{{ route('attendances.index') }}" class="btn btn-primary">
                                            <span>↺</span> Bersihkan Filter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Requirement 5.5) -->
            @if ($attendances->hasPages())
                <div class="pagination-wrap">
                    <div class="pagination-info">
                        Menampilkan <strong>{{ $attendances->firstItem() }}</strong> - <strong>{{ $attendances->lastItem() }}</strong> dari <strong>{{ $attendances->total() }}</strong> data &bull; Halaman <strong>{{ $attendances->currentPage() }}</strong> / <strong>{{ $attendances->lastPage() }}</strong>
                    </div>
                    <div>
                        {{ $attendances->links() }}
                    </div>
                </div>
            @endif
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Sistem Presensi & Laporan Presensi — Magang Laravel 12.</p>
        </div>
    </footer>

</body>
</html>
