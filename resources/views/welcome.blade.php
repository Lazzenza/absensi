<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Presensi Magang - Bappeda Provinsi DKI Jakarta</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CSS with Civic Horizon tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#00173b",
                        "primary-container": "#0f2c59",
                        "on-primary": "#ffffff",
                        "secondary": "#0051d5",
                        "secondary-container": "#316bf3",
                        "surface": "#f8f9ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "surface-container": "#e5eeff",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#44474f"
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-surface font-sans text-on-surface antialiased min-h-screen flex flex-col justify-between">

    <!-- Header Navigation -->
    <header class="w-full bg-white/90 backdrop-blur-md border-b border-surface-container py-4 px-6 lg:px-12 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="https://lh3.googleusercontent.com/aida/AEtjO1W7A9Imo7Xi_Uh1n3iggTZ9ftgey78SAPg2m122-AWd7EmojWULRjqzXBVRov7e1IQDq3_VOCIhVkSrrXOIH6kXW5Cgp81ig_arWvZY_L74uRqRd-4V_5F3lC5q8j1zHWa9ZufJgBhgNFnTFrKPGdsx9ct684zw41_hhG2n-GLGZhpWC3W1refg3EJAemkB5F60RYozPyTLBKFqRvu5DAcplUSv9n1NITBOdyF7PEPdHA" 
                 alt="Logo Bappeda DKI" 
                 class="h-9 w-auto object-contain"
                 onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/e/eb/Coat_of_arms_of_Jakarta.svg';">
            <div class="flex flex-col">
                <span class="font-bold text-sm text-primary tracking-tight leading-tight">BAPPEDA DKI JAKARTA</span>
                <span class="text-[11px] text-on-surface-variant">Sistem Presensi Magang</span>
            </div>
        </div>

        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary hover:bg-primary-container text-white text-xs font-bold transition-all shadow-sm">
                    <span class="material-symbols-outlined text-base">dashboard</span>
                    <span>Buka Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary hover:bg-primary-container text-white text-xs font-bold transition-all shadow-sm">
                    <span class="material-symbols-outlined text-base">login</span>
                    <span>Masuk ke Akun</span>
                </a>
            @endauth
        </nav>
    </header>

    <!-- Hero Content -->
    <main class="max-w-4xl mx-auto px-6 py-16 text-center flex flex-col items-center gap-6 my-auto">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container border border-surface-container-high text-secondary text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
            <span>Portal Magang Mandiri & Terpadu 2026</span>
        </div>

        <h1 class="font-extrabold text-3xl sm:text-5xl text-primary tracking-tight leading-tight max-w-3xl">
            Sistem Informasi Presensi Elektronik Magang Bappeda DKI Jakarta
        </h1>

        <p class="text-base sm:text-lg text-on-surface-variant max-w-2xl leading-relaxed">
            Platform presensi kedinasan berbasis geofencing dan verifikasi otomatis untuk mendukung akuntabilitas, disiplin, dan transparansi kegiatan magang di Badan Perencanaan Pembangunan Daerah Provinsi DKI Jakarta.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-primary hover:bg-primary-container text-white text-sm font-bold shadow-md hover:shadow-lg transition-all">
                    <span>Akses Dashboard Presensi</span>
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
                <a href="{{ route('attendances.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white border border-surface-container hover:bg-surface-container-low text-primary text-sm font-bold shadow-sm transition-all">
                    <span class="material-symbols-outlined text-lg text-secondary">fingerprint</span>
                    <span>Presensi Hari Ini</span>
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-primary hover:bg-primary-container text-white text-sm font-bold shadow-md hover:shadow-lg transition-all">
                    <span>Masuk ke Akun Peserta / Pegawai</span>
                    <span class="material-symbols-outlined text-lg">login</span>
                </a>
            @endauth
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-surface-container py-6 px-6 lg:px-12 text-center text-xs text-on-surface-variant bg-white">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>&copy; 2026 Badan Perencanaan Pembangunan Daerah Provinsi DKI Jakarta.</span>
            <span class="font-medium text-primary">Gedung Balai Kota Blok G Lantai 2, Jakarta Pusat</span>
        </div>
    </footer>

</body>
</html>
