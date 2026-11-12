<!-- REALTIME TELEMETRY & HERO PANEL (Civic Horizon - Bappeda DKI Jakarta) -->
<section class="relative w-full rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm p-space-md lg:p-space-lg overflow-hidden mb-space-lg">
    <div class="relative z-10 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-space-md">
        <!-- Title & Greeting -->
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-space-xs flex-wrap mb-0.5">
                <span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-bold text-label-sm uppercase tracking-wider">
                    Portal Layanan Magang
                </span>
                <span class="px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-bold text-label-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    Sistem Presensi Aktif 2026
                </span>
            </div>
            <h2 class="font-bold text-headline-sm lg:text-headline-lg text-primary tracking-tight">
                Selamat Datang, <span class="text-secondary">{{ Auth::user()->name ?? 'Rachmat Akbar' }}</span>
            </h2>
            <p class="text-body-sm text-on-surface-variant">
                {{ Auth::user()->email ?? 'intern@jakarta.go.id' }} • Peserta Magang - Bidang PPIP (Pusat Perencanaan dan Informasi Pembangunan)
            </p>
        </div>

        <!-- Realtime Telemetry Data Strips -->
        <div class="flex flex-wrap items-center gap-space-sm w-full xl:w-auto">
            <!-- Date Badge -->
            <div class="flex items-center gap-space-xs px-space-md py-2 rounded-xl bg-surface-container-low border border-surface-container shadow-sm">
                <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Hari & Tanggal</span>
                    <span class="font-semibold text-label-md text-primary" id="live-date">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>

            <!-- Real-Time Clock Box -->
            <div class="flex items-center gap-space-xs px-space-md py-2 rounded-xl bg-primary-container text-on-primary shadow-sm">
                <span class="material-symbols-outlined text-secondary text-[20px] filled">schedule</span>
                <div class="flex flex-col">
                    <span class="text-[10px] font-medium text-on-primary-container tracking-wider uppercase">Waktu Server Balai Kota</span>
                    <div class="flex items-center gap-1">
                        <span class="font-mono font-bold text-label-md lg:text-body-lg text-white tracking-wider" id="live-clock">
                            {{ \Carbon\Carbon::now()->format('H:i:s') }}
                        </span>
                        <span class="text-[10px] font-bold text-white/80 px-1 rounded bg-white/10">WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Geofencing & Office Protocol Sub-bar -->
    <div class="mt-space-md pt-space-sm border-t border-surface-container grid grid-cols-1 md:grid-cols-3 gap-space-sm">
        <!-- Geofence Status -->
        <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container-low">
            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                <span class="material-symbols-outlined text-[18px] filled">location_on</span>
            </div>
            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-1">
                    <span class="text-label-sm font-bold text-primary">Lokasi Tugas</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-[#ecfdf5] text-[#047857] text-[10px] font-bold">Terverifikasi</span>
                </div>
                <span class="text-body-sm text-on-surface-variant truncate">Balai Kota Blok G Lt. 2 (Bappeda)</span>
            </div>
        </div>

        <!-- Jaringan ASN -->
        <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container-low">
            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[18px] filled">wifi_password</span>
            </div>
            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-1">
                    <span class="text-label-sm font-bold text-primary">Jaringan Resmi</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-surface-container-high text-primary text-[10px] font-bold">Terkoneksi</span>
                </div>
                <span class="text-body-sm text-on-surface-variant truncate">SSID: BalaiKota_ASN_Gov</span>
            </div>
        </div>

        <!-- Jam Layanan Operasional -->
        <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container-low">
            <div class="w-8 h-8 rounded-lg bg-[#fffbeb] flex items-center justify-center text-[#b45309] shrink-0">
                <span class="material-symbols-outlined text-[18px] filled">timelapse</span>
            </div>
            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-1">
                    <span class="text-label-sm font-bold text-primary">Batas Tepat Waktu</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-[#fffbeb] text-[#b45309] text-[10px] font-bold">08:00 WIB</span>
                </div>
                <span class="text-body-sm text-on-surface-variant truncate">Lewat 08:00 WIB tercatat Terlambat</span>
            </div>
        </div>
    </div>
</section>
