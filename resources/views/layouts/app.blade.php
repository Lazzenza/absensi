<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Presensi Magang - Bappeda DKI Jakarta')</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CSS with Civic Horizon Design Tokens -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00173b",
                        "primary-container": "#0f2c59",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#7c94c8",
                        "primary-fixed": "#d8e2ff",
                        "primary-fixed-dim": "#aec7fd",
                        "on-primary-fixed": "#001a41",
                        "on-primary-fixed-variant": "#2d4674",
                        "secondary": "#0051d5",
                        "secondary-container": "#316bf3",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#fefcff",
                        "secondary-fixed": "#dbe1ff",
                        "secondary-fixed-dim": "#b4c5ff",
                        "on-secondary-fixed": "#00174b",
                        "on-secondary-fixed-variant": "#003ea8",
                        "tertiary": "#001b28",
                        "tertiary-container": "#003145",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#009fd6",
                        "tertiary-fixed": "#c4e7ff",
                        "tertiary-fixed-dim": "#7bd0ff",
                        "on-tertiary-fixed": "#001e2c",
                        "on-tertiary-fixed-variant": "#004c69",
                        "surface": "#f8f9ff",
                        "surface-dim": "#cbdbf5",
                        "surface-bright": "#f8f9ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "surface-container": "#e5eeff",
                        "surface-container-high": "#dce9ff",
                        "surface-container-highest": "#d3e4fe",
                        "surface-variant": "#d3e4fe",
                        "surface-tint": "#465e8e",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#44474f",
                        "inverse-surface": "#213145",
                        "inverse-on-surface": "#eaf1ff",
                        "inverse-primary": "#aec7fd",
                        "outline": "#747780",
                        "outline-variant": "#c4c6d0",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "background": "#f8f9ff",
                        "on-background": "#0b1c30"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        sm: "0.25rem",
                        md: "0.5rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        "2xl": "1rem",
                        full: "9999px"
                    },
                    spacing: {
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-md": "1rem",
                        "space-lg": "1.5rem",
                        "space-xl": "2rem",
                        "gutter": "1.5rem",
                        "gutter-mobile": "1rem",
                        "margin": "2rem",
                        "margin-mobile": "1rem"
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        "headline-xl": ["Plus Jakarta Sans"],
                        "headline-lg": ["Plus Jakarta Sans"],
                        "headline-sm": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "body-sm": ["Plus Jakarta Sans"],
                        "label-md": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "headline-xl": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "headline-sm": ["18px", { lineHeight: "26px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "body-sm": ["12px", { lineHeight: "18px", fontWeight: "400" }],
                        "label-md": ["13px", { lineHeight: "18px", letterSpacing: "0.01em", fontWeight: "600" }],
                        "label-sm": ["11px", { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "600" }]
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9ff;
            color: #0b1c30;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }
        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #eff4ff;
        }
        ::-webkit-scrollbar-thumb {
            background: #c4c6d0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #747780;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-surface font-sans text-on-surface antialiased min-h-screen flex flex-col">

    <!-- Mobile Backdrop -->
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-40 hidden transition-opacity lg:hidden" onclick="toggleMobileSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="main-sidebar" class="fixed left-0 top-0 h-full w-64 bg-surface-container-lowest z-50 flex flex-col shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-r border-surface-container transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Logo Area -->
        <div class="h-16 px-space-md flex items-center justify-between gap-space-sm bg-surface-container-lowest border-b border-surface-container">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-space-sm min-w-0 text-decoration-none">
                <img alt="Bappeda DKI Jakarta Logo" class="h-8 w-auto object-contain shrink-0" 
                     src="https://lh3.googleusercontent.com/aida/AEtjO1W7A9Imo7Xi_Uh1n3iggTZ9ftgey78SAPg2m122-AWd7EmojWULRjqzXBVRov7e1IQDq3_VOCIhVkSrrXOIH6kXW5Cgp81ig_arWvZY_L74uRqRd-4V_5F3lC5q8j1zHWa9ZufJgBhgNFnTFrKPGdsx9ct684zw41_hhG2n-GLGZhpWC3W1refg3EJAemkB5F60RYozPyTLBKFqRvu5DAcplUSv9n1NITBOdyF7PEPdHA"
                     onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/e/eb/Coat_of_arms_of_Jakarta.svg';">
                <div class="flex flex-col min-w-0">
                    <span class="font-bold text-[13px] text-primary tracking-tight truncate leading-tight">BAPPEDA DKI JAKARTA</span>
                    <span class="text-[11px] font-medium text-on-surface-variant truncate">Sistem Presensi Magang</span>
                </div>
            </a>
            <button type="button" class="lg:hidden p-1 rounded-md text-on-surface-variant hover:bg-surface-container-low" onclick="toggleMobileSidebar()">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-space-md py-space-sm flex flex-col gap-1.5 overflow-y-auto">
            <!-- 1. Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg transition-colors font-body-md text-body-md {{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
               data-path="dashboard">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('dashboard') ? 'text-on-primary filled' : 'text-on-surface-variant' }}">dashboard</span>
                <span>Dashboard</span>
            </a>

            <!-- 2. Presensi Harian -->
            <a href="{{ route('attendances.create') }}" 
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg transition-colors font-body-md text-body-md {{ request()->routeIs('attendances.create') ? 'bg-primary-container text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
               data-path="presensi">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('attendances.create') ? 'text-on-primary filled' : 'text-on-surface-variant' }}">fingerprint</span>
                <span>Presensi</span>
            </a>

            <!-- 3. Daftar Presensi -->
            <a href="{{ route('attendances.index') }}" 
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg transition-colors font-body-md text-body-md {{ request()->routeIs('attendances.index') ? 'bg-primary-container text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
               data-path="daftar-presensi">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('attendances.index') ? 'text-on-primary filled' : 'text-on-surface-variant' }}">assignment</span>
                <span>Daftar Presensi</span>
            </a>

            <!-- 4. Laporan Presensi -->
            <a href="{{ route('reports.index') }}" 
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg transition-colors font-body-md text-body-md {{ request()->routeIs('reports.*') ? 'bg-primary-container text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
               data-path="laporan">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('reports.*') ? 'text-on-primary filled' : 'text-on-surface-variant' }}">description</span>
                <span>Laporan</span>
            </a>
        </nav>

        <!-- Sidebar Footer Unit Magang Aktif -->
        <div class="p-space-md bg-surface-container-lowest border-t border-surface-container">
            <div class="p-space-sm rounded-lg bg-surface-container-low flex items-center gap-space-sm">
                <span class="material-symbols-outlined text-secondary text-[20px] filled">verified</span>
                <div class="flex flex-col min-w-0">
                    <span class="font-semibold text-label-sm text-primary truncate">Unit Magang Aktif</span>
                    <span class="text-body-sm text-on-surface-variant truncate">Bappeda Balai Kota</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN VIEW CONTAINER (Shifted for sidebar) -->
    <div class="lg:pl-64 flex flex-col min-h-screen">
        <!-- TOPBAR HEADER -->
        <header class="fixed top-0 left-0 lg:left-64 right-0 h-16 bg-surface/90 backdrop-blur-xl z-40 border-b border-surface-container shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="h-full w-full px-4 lg:px-gutter flex items-center justify-between gap-space-md">
                <!-- Left: Mobile Menu & Breadcrumbs -->
                <div class="flex items-center gap-space-md min-w-0">
                    <button type="button" class="lg:hidden p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container" onclick="toggleMobileSidebar()">
                        <span class="material-symbols-outlined text-[22px]">menu</span>
                    </button>
                    
                    <div class="flex items-center gap-space-xs text-on-surface-variant text-label-md">
                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant">domain</span>
                        <span class="hidden sm:inline">Portal Magang</span>
                        <span class="text-outline-variant">/</span>
                        <span class="text-primary font-semibold truncate">@yield('breadcrumb', 'Bappeda Provinsi DKI Jakarta')</span>
                    </div>

                    <!-- Server Date & Live Clock -->
                    <div class="hidden xl:flex items-center gap-space-xs text-on-surface-variant text-body-sm bg-surface-container-low px-space-sm py-1 rounded-lg">
                        <span class="material-symbols-outlined text-[16px] text-primary">calendar_today</span>
                        <span id="header-live-date">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                        <span class="text-outline-variant">•</span>
                        <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                        <span id="header-live-clock" class="font-mono font-medium text-primary">{{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</span>
                    </div>
                </div>

                <!-- Right: Profile & Actions -->
                <div class="flex items-center gap-space-md shrink-0">
                    <div class="flex items-center gap-space-sm">
                        <!-- User Identity -->
                        <div class="hidden sm:flex flex-col text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <span class="font-semibold text-label-md text-primary leading-tight">
                                    {{ Auth::user()->name ?? 'Rachmat Akbar' }}
                                </span>
                                @if(Auth::user() && Auth::user()->isAdmin())
                                    <span class="px-1.5 py-0.5 bg-primary text-white text-[10px] font-bold rounded tracking-wide">ADMIN</span>
                                @endif
                            </div>
                            <span class="text-body-sm text-on-surface-variant leading-tight">
                                {{ Auth::user() && Auth::user()->isAdmin() ? 'Subbagian Kepegawaian Bappeda' : 'Peserta Magang - Bidang PPIP' }}
                            </span>
                        </div>

                        <!-- User Avatar -->
                        <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center text-xs font-bold shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'RA', 0, 2)) }}
                        </div>

                        <!-- Logout Form -->
                        <form action="{{ route('logout') }}" method="POST" class="inline ml-1">
                            @csrf
                            <button type="submit" 
                                    class="p-1.5 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/40 transition-colors"
                                    title="Keluar dari akun">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- FLASH NOTIFICATIONS / ALERTS -->
        <div class="pt-20 px-4 lg:px-gutter max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest border-l-4 border-[#059669] shadow-sm flex items-start justify-between gap-space-sm">
                    <div class="flex items-start gap-space-sm">
                        <span class="material-symbols-outlined text-[#059669] text-[22px] filled">check_circle</span>
                        <div>
                            <h4 class="font-bold text-label-md text-primary">Berhasil</h4>
                            <p class="text-body-sm text-on-surface-variant mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="text-on-surface-variant hover:text-primary p-1" onclick="this.parentElement.remove()">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest border-l-4 border-error shadow-sm flex items-start justify-between gap-space-sm">
                    <div class="flex items-start gap-space-sm">
                        <span class="material-symbols-outlined text-error text-[22px] filled">error</span>
                        <div>
                            <h4 class="font-bold text-label-md text-primary">Peringatan</h4>
                            <p class="text-body-sm text-on-surface-variant mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button type="button" class="text-on-surface-variant hover:text-primary p-1" onclick="this.parentElement.remove()">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest border-l-4 border-[#d97706] shadow-sm flex items-start justify-between gap-space-sm">
                    <div class="flex items-start gap-space-sm">
                        <span class="material-symbols-outlined text-[#d97706] text-[22px] filled">warning</span>
                        <div>
                            <h4 class="font-bold text-label-md text-primary">Validasi Data</h4>
                            <ul class="list-disc list-inside text-body-sm text-on-surface-variant mt-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="text-on-surface-variant hover:text-primary p-1" onclick="this.parentElement.remove()">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- MAIN CONTENT -->
        <main class="w-full flex-1 px-4 lg:px-gutter py-space-md max-w-7xl mx-auto">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="mt-auto border-t border-surface-container bg-surface-container-lowest py-space-md px-4 lg:px-gutter text-on-surface-variant text-body-sm">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>&copy; 2026 Badan Perencanaan Pembangunan Daerah Provinsi DKI Jakarta.</span>
                <span class="font-medium text-primary">Sistem Presensi Elektronik Magang Bappeda Balai Kota</span>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile Sidebar Toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Realtime Indonesian Time (WIB / Asia/Jakarta) Live Clock Functionality
        function updateAllClocks() {
            try {
                const now = new Date();

                // Format Waktu Indonesia Barat (WIB, 24 Jam HH:mm:ss)
                const timeFormatter = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
                const timeString = timeFormatter.format(now).replace(/\./g, ':');

                // Format Tanggal Indonesia (contoh: Kamis, 12 November 2026)
                const dateFormatter = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                const dateString = dateFormatter.format(now);

                // 1. Header Clock & Date
                const headerClock = document.getElementById('header-live-clock');
                if (headerClock) {
                    headerClock.textContent = `${timeString} WIB`;
                }
                const headerDate = document.getElementById('header-live-date');
                if (headerDate) {
                    headerDate.textContent = dateString;
                }

                // 2. Presensi Harian Clocks (Check-in & Check-out)
                const liveClock = document.getElementById('live-clock');
                if (liveClock) {
                    liveClock.textContent = timeString;
                }
                const liveClockAlt = document.getElementById('liveClockAlt');
                if (liveClockAlt) {
                    liveClockAlt.textContent = timeString;
                }
                const liveClockGeneric = document.getElementById('liveClock');
                if (liveClockGeneric) {
                    liveClockGeneric.textContent = timeString;
                }

                // 3. Dashboard & Telemetry Clocks
                const dashboardClock = document.getElementById('dashboard-live-clock');
                if (dashboardClock) {
                    dashboardClock.textContent = `${timeString} WIB`;
                }
                const liveDate = document.getElementById('live-date');
                if (liveDate) {
                    liveDate.textContent = dateString;
                }

                // 4. Update seluruh elemen dengan class live-clock
                document.querySelectorAll('.live-wib-clock').forEach(el => {
                    el.textContent = timeString;
                });
                document.querySelectorAll('.live-wib-clock-tz').forEach(el => {
                    el.textContent = `${timeString} WIB`;
                });
                document.querySelectorAll('.live-wib-date').forEach(el => {
                    el.textContent = dateString;
                });
            } catch (e) {
                console.error("Error updating live clock:", e);
            }
        }

        // Jalankan segera dan set interval tiap 1000ms (1 detik)
        updateAllClocks();
        setInterval(updateAllClocks, 1000);
        document.addEventListener('DOMContentLoaded', updateAllClocks);
    </script>
    @stack('scripts')
</body>
</html>
