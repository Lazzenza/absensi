@extends('layouts.app')

@section('title', 'Presensi Harian - Bappeda DKI Jakarta')
@section('breadcrumb', 'Presensi Harian')

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- Top Metadata & Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md pb-space-xs">
        <div class="space-y-space-xs">
            <div class="flex items-center gap-space-xs text-on-surface-variant text-label-sm tracking-wider uppercase">
                <span class="text-secondary font-bold">Bappeda Provinsi DKI Jakarta</span>
                <span class="text-outline-variant">•</span>
                <span>Portal Magang</span>
                <span class="text-outline-variant">•</span>
                <span class="text-primary font-semibold">Presensi Harian</span>
            </div>
            <h1 class="font-bold text-headline-xl text-primary tracking-tight">
                @if(!$todayAttendance)
                    Presensi Masuk
                @elseif(!$todayAttendance->time_out && !in_array($todayAttendance->status, ['Izin', 'Sakit']))
                    Presensi Pulang
                @else
                    Status Presensi Hari Ini
                @endif
            </h1>
            <p class="text-body-md text-on-surface-variant max-w-2xl">
                Silakan lakukan konfirmasi kehadiran atau kelola administrasi presensi magang Anda di Bappeda Provinsi DKI Jakarta.
            </p>
        </div>

        <!-- Quick Info Pills -->
        <div class="flex flex-wrap items-center gap-space-sm self-start md:self-auto">
            <div class="flex items-center gap-space-xs bg-surface-container-lowest border border-surface-container px-space-md py-space-xs rounded-xl shadow-sm text-on-surface">
                <span class="material-symbols-outlined text-[18px] text-secondary">calendar_month</span>
                <span class="font-bold text-label-md">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <div class="flex items-center gap-space-xs bg-surface-container-lowest border border-surface-container px-space-md py-space-xs rounded-xl shadow-sm text-on-surface">
                <span class="material-symbols-outlined text-[18px] text-secondary">location_on</span>
                <span class="text-label-md text-on-surface">Balai Kota Blok G - Gedung Bappeda</span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs between Daily Check-in/out and Special Form (Izin/Sakit) -->
    <div class="flex items-center gap-2 border-b border-surface-container pb-1">
        <button type="button" id="tab-btn-daily" onclick="switchPresensiTab('daily')" 
                class="px-space-md py-2.5 rounded-lg font-bold text-label-md flex items-center gap-2 transition-all bg-primary-container text-on-primary shadow-sm">
            <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
            <span>Presensi Harian (Masuk / Pulang)</span>
        </button>
        <button type="button" id="tab-btn-special" onclick="switchPresensiTab('special')" 
                class="px-space-md py-2.5 rounded-lg font-medium text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low flex items-center gap-2 transition-all">
            <span class="material-symbols-outlined text-[18px]">edit_note</span>
            <span>Form Presensi Khusus (Izin & Sakit)</span>
        </button>
    </div>

    <!-- TAB 1: DAILY ATTENDANCE (PRESENSI MASUK / PULANG) -->
    <div id="tab-content-daily" class="space-y-space-lg">
        @if(!$todayAttendance)
            <!-- ================= STATE 1: PRESENSI MASUK ================= -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                <!-- Primary Form Container (8 Cols) -->
                <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg flex flex-col gap-space-lg">
                    <!-- Form Header -->
                    <div class="flex items-center justify-between pb-space-sm border-b border-surface-container">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[22px]">how_to_reg</span>
                            </div>
                            <div>
                                <h2 class="font-bold text-headline-sm text-primary leading-tight">
                                    Formulir Presensi Masuk
                                </h2>
                                <p class="text-body-sm text-on-surface-variant">
                                    Konfirmasi data kepegawaian & waktu kedatangan presensi kerja
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-surface-container-low text-secondary font-bold text-label-sm">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Sistem Aktif
                        </span>
                    </div>

                    <!-- Form Body -->
                    <form action="{{ route('attendances.store') }}" method="POST" class="space-y-space-lg">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="type" value="check_in">

                        <!-- Field: Peserta Magang -->
                        <div class="space-y-space-xs">
                            <label class="block font-bold text-label-md text-primary" for="intern-name">
                                Nama Peserta Magang
                            </label>
                            <div class="w-full bg-surface-container-low rounded-lg p-space-sm pl-space-md flex items-center justify-between border border-surface-container">
                                <div class="flex items-center gap-space-sm min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-label-md shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'RA', 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-bold text-label-md text-primary truncate">
                                            {{ Auth::user()->name ?? 'Rachmat Akbar' }}
                                        </span>
                                        <span class="text-body-sm text-on-surface-variant truncate">
                                            Peserta Magang - Bidang PPIP (Pusat Perencanaan dan Informasi Pembangunan)
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-xs pr-space-xs shrink-0">
                                    <span class="bg-surface-container-highest px-2 py-0.5 rounded text-primary font-bold text-label-sm">
                                        ID: MG-2026-0842
                                    </span>
                                    <span class="material-symbols-outlined text-[20px] text-secondary filled">verified</span>
                                </div>
                            </div>
                        </div>

                        <!-- Information Display Grid (Tanggal & Waktu) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                            <!-- Tanggal Card -->
                            <div class="bg-surface-container-low p-space-md rounded-xl border border-surface-container flex flex-col justify-between gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-label-sm text-on-surface-variant uppercase tracking-wider font-bold">
                                        Tanggal Presensi
                                    </span>
                                    <span class="material-symbols-outlined text-[20px] text-primary">event_available</span>
                                </div>
                                <div>
                                    <p class="font-bold text-headline-sm text-primary">
                                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                    </p>
                                    <p class="text-body-sm text-on-surface-variant mt-0.5">
                                        Tahun Anggaran 2026 / Triwulan IV
                                    </p>
                                </div>
                            </div>

                            <!-- Real-time Waktu Check-In Card -->
                            <div class="bg-surface-container-low p-space-md rounded-xl border border-surface-container flex flex-col justify-between gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-label-sm text-on-surface-variant uppercase tracking-wider font-bold">
                                        Waktu Check-In (Server)
                                    </span>
                                    <span class="material-symbols-outlined text-[20px] text-secondary">schedule</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-space-xs">
                                        <span class="font-bold text-headline-lg text-primary tracking-tight font-mono live-wib-clock" id="live-clock">
                                            {{ \Carbon\Carbon::now()->format('H:i:s') }}
                                        </span>
                                        <span class="font-bold text-label-md text-on-surface-variant">WIB</span>
                                    </div>
                                    <div class="mt-space-xs inline-flex items-center gap-1 bg-surface-container-highest text-primary px-2 py-0.5 rounded text-label-sm">
                                        <span class="material-symbols-outlined text-[14px] text-secondary filled">task_alt</span>
                                        <span>Batas Tepat Waktu: 08:00 WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan / Keterangan Optional -->
                        <div class="space-y-space-xs">
                            <label class="block font-bold text-label-md text-primary" for="notes">
                                Catatan Kehadiran (Opsional)
                            </label>
                            <input type="text" name="notes" id="notes" 
                                   placeholder="Contoh: Hadir tepat waktu di Balai Kota Blok G"
                                   class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors">
                        </div>

                        <!-- Alert / Warning Banner -->
                        <div class="rounded-xl bg-surface-container-low p-space-md flex items-start gap-space-sm border border-surface-container">
                            <span class="material-symbols-outlined text-secondary text-[22px] shrink-0 mt-0.5">
                                info
                            </span>
                            <div class="space-y-0.5 text-on-surface">
                                <p class="font-bold text-label-md text-primary">
                                    Perhatian Presensi Harian
                                </p>
                                <p class="text-body-sm text-on-surface-variant leading-relaxed">
                                    Anda hanya dapat melakukan presensi masuk (check-in) sebanyak 1 (satu) kali dalam sehari. Pastikan data nama, unit kerja, dan waktu kedatangan sudah sesuai sebelum menekan tombol konfirmasi.
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-space-sm flex flex-col sm:flex-row items-center gap-space-sm">
                            <button type="submit" 
                                    class="w-full sm:w-auto flex-1 h-12 px-space-lg bg-[#00173b] hover:bg-[#0f2c59] text-white font-bold text-label-md rounded-lg flex items-center justify-center gap-space-xs shadow-md transition-all active:scale-[0.99] cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                <span>Konfirmasi Presensi Masuk</span>
                            </button>
                            <a href="{{ route('dashboard') }}" 
                               class="w-full sm:w-auto h-12 px-space-lg bg-surface-container-low hover:bg-surface-container text-primary font-bold text-label-md rounded-lg flex items-center justify-center gap-space-xs transition-colors text-center border border-surface-container">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                <span>Kembali ke Dashboard</span>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Status Summary Sidebar (4 Cols) -->
                <div class="lg:col-span-4 flex flex-col gap-space-md">
                    <!-- Today's Status Box -->
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg space-y-space-md">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-label-sm uppercase tracking-wider text-on-surface-variant">
                                Status Hari Ini
                            </span>
                            <span class="w-2.5 h-2.5 rounded-full bg-secondary-container"></span>
                        </div>
                        <div class="space-y-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-outline text-[22px]">pending_actions</span>
                                <span class="font-bold text-headline-sm text-primary">
                                    Belum Presensi
                                </span>
                            </div>
                            <p class="text-body-sm text-on-surface-variant">
                                Sesi presensi masuk dibuka dari pukul 07:00 hingga 09:00 WIB.
                            </p>
                        </div>
                        <div class="space-y-space-xs pt-space-xs">
                            <div class="flex justify-between font-bold text-label-sm">
                                <span class="text-on-surface-variant">Batas Tepat Waktu</span>
                                <span class="text-primary">08:00 WIB</span>
                            </div>
                            <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full w-[78%] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule & Office Protocol Box -->
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg space-y-space-md">
                        <h3 class="font-bold text-label-md text-primary uppercase tracking-wider">
                            Ketentuan Jam Kerja Magang
                        </h3>
                        <div class="space-y-space-sm text-body-sm">
                            <div class="flex items-start gap-space-sm">
                                <span class="material-symbols-outlined text-[20px] text-secondary shrink-0 mt-0.5">work_history</span>
                                <div>
                                    <p class="font-bold text-label-md text-primary">Jadwal Kerja Magang</p>
                                    <p class="text-on-surface-variant">Senin – Kamis: 07:30 – 16:00 WIB</p>
                                    <p class="text-on-surface-variant">Jumat: 07:30 – 16:30 WIB</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-space-sm">
                                <span class="material-symbols-outlined text-[20px] text-secondary shrink-0 mt-0.5">meeting_room</span>
                                <div>
                                    <p class="font-bold text-label-md text-primary">Penugasan Unit Kerja</p>
                                    <p class="text-on-surface-variant">Ruang Bidang PPIP Lantai 4, Balai Kota</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-space-sm">
                                <span class="material-symbols-outlined text-[20px] text-secondary shrink-0 mt-0.5">assignment_turned_in</span>
                                <div>
                                    <p class="font-bold text-label-md text-primary">Logbook Aktivitas</p>
                                    <p class="text-on-surface-variant">Dapat diisi setelah presensi masuk tervalidasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Official Trust Note -->
                    <div class="bg-surface-container-low border border-surface-container rounded-xl p-space-md flex items-center gap-space-sm">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">cloud_done</span>
                        <p class="text-body-sm text-on-surface-variant leading-snug">
                            Data presensi tersinkronisasi otomatis dengan Sistem Informasi Kepegawaian Bappeda DKI Jakarta.
                        </p>
                    </div>
                </div>
            </div>

        @elseif(!$todayAttendance->time_out && !in_array($todayAttendance->status, ['Izin', 'Sakit']))
            <!-- ================= STATE 2: PRESENSI PULANG ================= -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                <!-- Left Main Column (8 Cols) -->
                <div class="lg:col-span-8 flex flex-col gap-space-md">
                    <!-- Inline Success Toast of Check-in -->
                    <div class="flex items-start justify-between gap-space-md p-space-md rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm">
                        <div class="flex items-start gap-space-sm">
                            <div class="h-9 w-9 rounded-lg bg-[#ecfdf5] flex items-center justify-center text-[#047857] shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[22px] filled">check_circle</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-label-md text-primary">Presensi Masuk Telah Tercatat</span>
                                <span class="text-body-sm text-on-surface-variant mt-0.5">
                                    Waktu masuk Anda pada pukul <strong class="text-primary">{{ $todayAttendance->time_in }} WIB</strong> (Status: {{ $todayAttendance->status }}) telah terekam ke sistem kepegawaian.
                                </span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-[#ecfdf5] text-[#047857] text-label-sm font-bold">
                            Tercatat
                        </span>
                    </div>

                    <!-- Main Form Card Presensi Pulang -->
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg flex flex-col gap-space-lg">
                        <!-- Card Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm pb-space-sm border-b border-surface-container">
                            <div class="flex items-center gap-space-sm">
                                <div class="h-10 w-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[24px]">logout</span>
                                </div>
                                <div class="flex flex-col">
                                    <h2 class="font-bold text-headline-sm text-primary">Formulir Presensi Pulang</h2>
                                    <span class="text-body-sm text-on-surface-variant">Konfirmasi kehadiran akhir jam kerja operasional dinas</span>
                                </div>
                            </div>
                            <div class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-surface-container text-primary font-bold text-label-sm w-fit">
                                <span class="inline-block w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                                <span>Status: Siap Check-out</span>
                            </div>
                        </div>

                        <!-- Identity Strip -->
                        <div class="p-space-md rounded-xl bg-surface-container-low border border-surface-container flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
                            <div class="flex items-center gap-space-md">
                                <div class="h-12 w-12 rounded-xl bg-primary text-on-primary font-bold text-headline-sm flex items-center justify-center shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'RA', 0, 2)) }}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-bold text-headline-sm text-primary leading-tight truncate">
                                        {{ Auth::user()->name ?? 'Rachmat Akbar' }}
                                    </span>
                                    <span class="text-body-sm text-on-surface-variant truncate">
                                        Peserta Magang - Bidang PPIP (Pusat Perencanaan dan Informasi Pembangunan)
                                    </span>
                                </div>
                            </div>
                            <span class="font-bold text-label-sm text-primary bg-surface-container-highest px-space-sm py-1 rounded-lg tracking-wider">
                                ID: MG-2026-0842
                            </span>
                        </div>

                        <!-- Metrics Grid (3 Indicator Cards) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                            <!-- Metric 1: Tanggal -->
                            <div class="flex flex-col justify-between p-space-md bg-surface-container-low border border-surface-container rounded-xl">
                                <div class="flex flex-col">
                                    <span class="font-bold text-label-sm text-on-surface-variant uppercase tracking-wider">TANGGAL PRESENSI</span>
                                    <span class="font-bold text-headline-sm text-primary mt-1">
                                        {{ \Carbon\Carbon::parse($todayAttendance->date)->locale('id')->isoFormat('D MMM Y') }}
                                    </span>
                                </div>
                                <div class="mt-space-md pt-space-xs">
                                    <span class="text-body-sm text-on-surface-variant leading-tight block">Tahun Anggaran 2026</span>
                                    <span class="font-medium text-label-sm text-secondary">Triwulan IV (Okt-Des)</span>
                                </div>
                            </div>

                            <!-- Metric 2: Waktu Masuk -->
                            <div class="flex flex-col justify-between p-space-md bg-surface-container-low border border-surface-container rounded-xl">
                                <div class="flex flex-col">
                                    <span class="font-bold text-label-sm text-on-surface-variant uppercase tracking-wider">WAKTU CHECK-IN</span>
                                    <div class="flex items-baseline gap-1 mt-1">
                                        <span class="font-bold text-headline-sm text-primary font-mono">{{ $todayAttendance->time_in }}</span>
                                        <span class="font-bold text-label-sm text-on-surface-variant">WIB</span>
                                    </div>
                                </div>
                                <div class="mt-space-md">
                                    <div class="inline-flex items-center gap-1 bg-[#ecfdf5] text-[#047857] px-2 py-0.5 rounded text-label-sm font-semibold">
                                        <span class="material-symbols-outlined text-[14px]">done_all</span>
                                        <span>Tervalidasi Masuk</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Metric 3: Waktu Pulang Server -->
                            <div class="flex flex-col justify-between p-space-md bg-surface-container-high border border-surface-container rounded-xl">
                                <div class="flex flex-col">
                                    <span class="font-bold text-label-sm text-primary uppercase tracking-wider">WAKTU CHECK-OUT (SERVER)</span>
                                    <div class="flex items-baseline gap-1 mt-1">
                                        <span class="font-bold text-headline-sm text-primary font-mono live-wib-clock" id="liveClockAlt">
                                            {{ \Carbon\Carbon::now()->format('H:i:s') }}
                                        </span>
                                        <span class="font-bold text-label-sm text-on-surface-variant">WIB</span>
                                    </div>
                                </div>
                                <div class="mt-space-md">
                                    <div class="inline-flex items-center gap-1 bg-surface-container-lowest text-secondary px-2 py-0.5 rounded text-label-sm font-bold shadow-sm">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        <span>Jam Kerja Selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Submission -->
                        <form action="{{ route('attendances.store') }}" method="POST" class="space-y-space-md">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="type" value="check_out">

                            <div class="space-y-space-xs">
                                <label class="block font-bold text-label-md text-primary" for="checkout-notes">
                                    Ringkasan Aktivitas / Catatan Kepulangan (Opsional)
                                </label>
                                <input type="text" name="notes" id="checkout-notes" 
                                       placeholder="Contoh: Menyelesaikan rekap dokumen perencanaan triwulan IV"
                                       class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors">
                            </div>

                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row items-center gap-space-sm pt-space-xs">
                                <button type="submit" 
                                        class="w-full sm:w-auto flex-1 h-12 px-space-lg bg-secondary hover:bg-secondary-container text-white font-bold text-label-md rounded-lg flex items-center justify-center gap-space-xs shadow-md transition-all active:scale-[0.99] cursor-pointer">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    <span>Konfirmasi Presensi Pulang (Check-out)</span>
                                </button>
                                <a href="{{ route('dashboard') }}" 
                                   class="w-full sm:w-auto h-12 px-space-lg bg-surface-container-low hover:bg-surface-container text-primary font-bold text-label-md rounded-lg flex items-center justify-center gap-space-xs transition-colors border border-surface-container">
                                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                    <span>Kembali</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Companion Sidebar (4 Cols) -->
                <div class="lg:col-span-4 flex flex-col gap-space-md">
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg space-y-space-md">
                        <span class="font-bold text-label-sm uppercase tracking-wider text-on-surface-variant">
                            Informasi Presensi Pulang
                        </span>
                        <div class="space-y-space-sm text-body-sm text-on-surface-variant">
                            <p>
                                Presensi pulang menandai berakhirnya jam tugas magang harian Anda.
                            </p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Senin - Kamis: Minimal pukul 16:00 WIB</li>
                                <li>Jumat: Minimal pukul 16:30 WIB</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- ================= STATE 3: SUDAH SELESAI / DALAM PENINJAUAN ================= -->
            <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-xl flex flex-col items-center text-center max-w-2xl mx-auto gap-space-md">
                @if(in_array($todayAttendance->status, ['Izin', 'Sakit']))
                    @if($todayAttendance->approval_status === 'pending')
                        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm border border-amber-200">
                            <span class="material-symbols-outlined text-[36px]">hourglass_top</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-headline-sm text-primary">Permohonan Menunggu Persetujuan Admin</h2>
                            <p class="text-body-md text-on-surface-variant mt-1">
                                Anda telah mengajukan dispensasi <strong>{{ $todayAttendance->status }}</strong> untuk tanggal <strong>{{ \Carbon\Carbon::parse($todayAttendance->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>. Permohonan ini sedang ditinjau oleh Administrator / Kepegawaian Bappeda DKI Jakarta.
                            </p>
                        </div>
                    @elseif($todayAttendance->approval_status === 'approved')
                        <div class="w-16 h-16 rounded-full bg-[#ecfdf5] text-[#047857] flex items-center justify-center shadow-sm border border-emerald-200">
                            <span class="material-symbols-outlined text-[36px] filled">verified</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-headline-sm text-primary">Permohonan Disetujui Admin</h2>
                            <p class="text-body-md text-on-surface-variant mt-1">
                                Permohonan dispensasi <strong>{{ $todayAttendance->status }}</strong> Anda untuk tanggal <strong>{{ \Carbon\Carbon::parse($todayAttendance->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong> telah disetujui resmi oleh Administrator.
                            </p>
                        </div>
                    @elseif($todayAttendance->approval_status === 'rejected')
                        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center shadow-sm border border-rose-200">
                            <span class="material-symbols-outlined text-[36px]">cancel</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-headline-sm text-rose-700">Permohonan Ditolak Admin</h2>
                            <p class="text-body-md text-on-surface-variant mt-1">
                                Permohonan dispensasi <strong>{{ $todayAttendance->status }}</strong> Anda tidak disetujui.
                            </p>
                            @if($todayAttendance->approval_note)
                                <div class="mt-2 p-3 rounded-lg bg-rose-50 text-rose-800 text-body-sm border border-rose-200 text-left">
                                    <strong>Catatan Admin:</strong> {{ $todayAttendance->approval_note }}
                                </div>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="w-16 h-16 rounded-full bg-[#ecfdf5] text-[#047857] flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[36px] filled">verified</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-headline-sm text-primary">Presensi Hari Ini Telah Selesai</h2>
                        <p class="text-body-md text-on-surface-variant mt-1">
                            Catatan kehadiran Anda untuk tanggal <strong>{{ \Carbon\Carbon::parse($todayAttendance->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong> telah lengkap tervalidasi.
                        </p>
                    </div>
                @endif

                <div class="flex flex-wrap items-center justify-center gap-space-md p-space-md rounded-xl bg-surface-container-low border border-surface-container w-full">
                    <div>
                        <span class="block text-label-sm text-on-surface-variant">Status</span>
                        <span class="font-bold text-label-md text-primary">{{ $todayAttendance->status }}</span>
                    </div>
                    <div class="w-px h-8 bg-surface-container-high hidden sm:block"></div>
                    <div>
                        <span class="block text-label-sm text-on-surface-variant">Status Persetujuan</span>
                        @if($todayAttendance->approval_status === 'pending')
                            <span class="font-bold text-label-md text-amber-700">Menunggu Review</span>
                        @elseif($todayAttendance->approval_status === 'approved')
                            <span class="font-bold text-label-md text-emerald-700">Disetujui</span>
                        @elseif($todayAttendance->approval_status === 'rejected')
                            <span class="font-bold text-label-md text-rose-700">Ditolak</span>
                        @else
                            <span class="font-bold text-label-md text-primary">Tervalidasi</span>
                        @endif
                    </div>
                    <div class="w-px h-8 bg-surface-container-high hidden sm:block"></div>
                    <div>
                        <span class="block text-label-sm text-on-surface-variant">Waktu</span>
                        <span class="font-bold text-label-md text-primary">
                            {{ $todayAttendance->time_in ? $todayAttendance->time_in . ' WIB' : 'Dispensasi Penuh' }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm pt-space-xs">
                    <a href="{{ route('dashboard') }}" class="px-space-lg py-2.5 rounded-lg bg-surface-container-low text-primary font-bold text-label-md border border-surface-container hover:bg-surface-container">
                        Dashboard
                    </a>
                    <a href="{{ route('attendances.index') }}" class="px-space-lg py-2.5 rounded-lg bg-primary-container text-on-primary font-bold text-label-md shadow-sm hover:bg-primary">
                        Lihat Daftar Presensi
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- TAB 2: SPECIAL ATTENDANCE FORM (FORM PRESENSI KHUSUS - IZIN & SAKIT) -->
    <div id="tab-content-special" class="hidden space-y-space-lg">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
            <!-- Main Form Card (8 Cols) -->
            <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg flex flex-col gap-space-lg">
                <!-- Card Header -->
                <div class="flex items-center justify-between pb-space-sm border-b border-surface-container">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[22px]">edit_note</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-headline-sm text-primary leading-tight">Formulir Presensi Khusus</h2>
                            <span class="text-body-sm text-on-surface-variant">Kategori Dispensasi Izin & Sakit</span>
                        </div>
                    </div>
                    <span class="text-label-sm px-space-sm py-1 rounded-full bg-surface-container-low text-primary font-bold">
                        Mode Pengajuan
                    </span>
                </div>

                <!-- Administrative Notice Banner -->
                <div class="p-space-md rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-body-sm flex items-start gap-space-sm">
                    <span class="material-symbols-outlined text-[22px] text-blue-600 shrink-0 mt-0.5">info</span>
                    <div>
                        <strong class="font-bold text-label-md block text-blue-950">Alur Penyetujuan Administrator:</strong>
                        Setiap pengajuan dispensasi <em>Izin</em> atau <em>Sakit</em> akan masuk dengan status <strong>Menunggu Persetujuan</strong> dan memerlukan peninjauan langsung oleh Admin / Subbagian Kepegawaian Bappeda DKI Jakarta sebelum tercatat sah.
                    </div>
                </div>

                <!-- Form Element -->
                <form action="{{ route('attendances.store') }}" method="POST" class="flex flex-col gap-space-lg">
                    @csrf
                    <!-- Select Intern User -->
                    <div class="flex flex-col gap-space-xs">
                        <div class="flex items-center justify-between">
                            <label class="font-bold text-label-md text-primary" for="selectPeserta">
                                Nama Peserta Magang <span class="text-error">*</span>
                            </label>
                            <span class="text-label-sm text-secondary font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span> Terverifikasi SSO
                            </span>
                        </div>
                        <select name="user_id" id="selectPeserta" required 
                                class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-primary font-body-md text-body-md focus:border-secondary focus:ring-1 focus:ring-secondary focus:outline-none transition-colors">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ (Auth::id() == $u->id) ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category of Absence (Radio Selection) -->
                    <div class="flex flex-col gap-space-xs">
                        <label class="font-bold text-label-md text-primary">
                            Jenis Presensi Khusus <span class="text-error">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                            <!-- Option 1: Sakit -->
                            <label class="cursor-pointer relative flex items-start gap-space-sm p-space-md rounded-xl border border-surface-container bg-surface-container-low hover:bg-surface-container-lowest transition-colors has-[:checked]:border-secondary has-[:checked]:bg-[#eff6ff]">
                                <input type="radio" name="type" value="sakit" required class="mt-1 text-secondary focus:ring-secondary" checked>
                                <div class="flex flex-col">
                                    <span class="font-bold text-label-md text-primary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-error text-[18px]">medical_services</span>
                                        Sakit (Dispensasi Medis)
                                    </span>
                                    <span class="text-body-sm text-on-surface-variant mt-0.5">
                                        Memerlukan surat keterangan sakit dokter atau faskes rawat jalan.
                                    </span>
                                </div>
                            </label>

                            <!-- Option 2: Izin -->
                            <label class="cursor-pointer relative flex items-start gap-space-sm p-space-md rounded-xl border border-surface-container bg-surface-container-low hover:bg-surface-container-lowest transition-colors has-[:checked]:border-secondary has-[:checked]:bg-[#eff6ff]">
                                <input type="radio" name="type" value="izin" required class="mt-1 text-secondary focus:ring-secondary">
                                <div class="flex flex-col">
                                    <span class="font-bold text-label-md text-primary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[#1d4ed8] text-[18px]">event_note</span>
                                        Izin (Keperluan Akademik / Mendesak)
                                    </span>
                                    <span class="text-body-sm text-on-surface-variant mt-0.5">
                                        Izin bimbingan skripsi, sidang akademik, atau keperluan dinas luar.
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Keterangan Alasan -->
                    <div class="flex flex-col gap-space-xs">
                        <label class="font-bold text-label-md text-primary" for="special-notes">
                            Keterangan & Alasan Pengajuan <span class="text-error">*</span>
                        </label>
                        <textarea name="notes" id="special-notes" rows="3" required
                                  placeholder="Jelaskan alasan ketidakhadiran secara terperinci (contoh: Menghadiri bimbingan tugas akhir di kampus...)"
                                  class="w-full p-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors"></textarea>
                    </div>

                    <!-- Lampiran Bukti File (Simulation) -->
                    <div class="flex flex-col gap-space-xs">
                        <label class="font-bold text-label-md text-primary">
                            Lampiran Berkas Pendukung (Surat Keterangan / Bukti)
                        </label>
                        <div class="border-2 border-dashed border-surface-container hover:border-secondary rounded-xl p-space-md flex flex-col items-center justify-center text-center bg-surface-container-low/50 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-[32px] text-on-surface-variant mb-1">upload_file</span>
                            <span class="font-bold text-label-md text-primary">Klik untuk memilih dokumen atau seret ke sini</span>
                            <span class="text-body-sm text-on-surface-variant mt-0.5">Format didukung: PDF, JPG, PNG (Maks. 5 MB)</span>
                        </div>
                    </div>

                    <!-- Submit Action -->
                    <div class="pt-space-sm flex flex-col sm:flex-row items-center gap-space-sm">
                        <button type="submit" 
                                class="w-full sm:w-auto flex-1 h-12 px-space-lg bg-primary-container hover:bg-primary text-on-primary font-bold text-label-md rounded-lg flex items-center justify-center gap-space-xs shadow-md transition-all active:scale-[0.99] cursor-pointer">
                            <span class="material-symbols-outlined text-[20px]">send</span>
                            <span>Kirim Pengajuan Presensi Khusus</span>
                        </button>
                        <button type="button" onclick="switchPresensiTab('daily')"
                                class="w-full sm:w-auto h-12 px-space-lg bg-surface-container-low hover:bg-surface-container text-primary font-bold text-label-md rounded-lg flex items-center justify-center gap-space-xs transition-colors border border-surface-container">
                            <span>Batal</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Companion Info Panel (4 Cols) -->
            <div class="lg:col-span-4 flex flex-col gap-space-md">
                <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg space-y-space-md">
                    <h3 class="font-bold text-label-md text-primary uppercase tracking-wider">
                        Ketentuan Dispensasi Magang
                    </h3>
                    <div class="space-y-space-sm text-body-sm text-on-surface-variant">
                        <div class="flex items-start gap-space-xs">
                            <span class="material-symbols-outlined text-[18px] text-secondary shrink-0 mt-0.5">verified_user</span>
                            <p>Pengajuan izin diajukan maksimal 1 hari sebelum atau pada hari H sebelum pukul 09:00 WIB.</p>
                        </div>
                        <div class="flex items-start gap-space-xs">
                            <span class="material-symbols-outlined text-[18px] text-secondary shrink-0 mt-0.5">medical_information</span>
                            <p>Keterangan sakit wajib disertai dokumen resmi surat keterangan dari fasilitas pelayanan kesehatan.</p>
                        </div>
                        <div class="flex items-start gap-space-xs">
                            <span class="material-symbols-outlined text-[18px] text-secondary shrink-0 mt-0.5">assignment_turned_in</span>
                            <p>Verifikasi akhir dilakukan oleh Subbagian Kepegawaian & Tata Usaha Bappeda DKI Jakarta.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function switchPresensiTab(tab) {
        const dailyBtn = document.getElementById('tab-btn-daily');
        const specialBtn = document.getElementById('tab-btn-special');
        const dailyContent = document.getElementById('tab-content-daily');
        const specialContent = document.getElementById('tab-content-special');

        if (tab === 'daily') {
            dailyBtn.className = "px-space-md py-2.5 rounded-lg font-bold text-label-md flex items-center gap-2 transition-all bg-primary-container text-on-primary shadow-sm";
            specialBtn.className = "px-space-md py-2.5 rounded-lg font-medium text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low flex items-center gap-2 transition-all";
            dailyContent.classList.remove('hidden');
            specialContent.classList.add('hidden');
        } else {
            specialBtn.className = "px-space-md py-2.5 rounded-lg font-bold text-label-md flex items-center gap-2 transition-all bg-primary-container text-on-primary shadow-sm";
            dailyBtn.className = "px-space-md py-2.5 rounded-lg font-medium text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low flex items-center gap-2 transition-all";
            specialContent.classList.remove('hidden');
            dailyContent.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection

