@extends('layouts.app')

@section('title', 'Dashboard Presensi - Bappeda DKI Jakarta')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- Page Header & Greeting Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mb-space-xs">
        <div class="flex flex-col gap-space-xs max-w-2xl">
            <div class="flex items-center gap-space-xs text-on-surface-variant font-bold text-label-sm uppercase tracking-wider">
                <span class="text-secondary">Bappeda Provinsi DKI Jakarta</span>
                <span class="text-outline-variant">•</span>
                <span>Portal Magang</span>
            </div>
            <h1 class="font-bold text-headline-xl text-primary tracking-tight">Dashboard Presensi</h1>
            <p class="text-body-md text-on-surface-variant leading-relaxed">
                Selamat Datang, <strong>{{ Auth::user()->name ?? 'Rachmat Akbar' }}</strong>. Berikut adalah ringkasan kehadiran Anda selama periode magang (13 Juli – 30 Desember 2026 / 119 hari kerja) di Bappeda Provinsi DKI Jakarta.
            </p>
        </div>

        <!-- Meta Badges -->
        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <div class="flex items-center gap-space-xs bg-surface-container-lowest border border-surface-container px-space-md py-space-sm rounded-xl shadow-sm">
                <span class="material-symbols-outlined text-primary text-[18px]">calendar_today</span>
                <span class="font-semibold text-label-md text-primary" id="dashboard-live-date">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
            </div>
            <div class="flex items-center gap-space-xs bg-surface-container-high border border-surface-container px-space-md py-space-sm rounded-xl shadow-sm text-primary">
                <span class="material-symbols-outlined text-secondary text-[18px]">schedule</span>
                <span class="font-bold text-label-md font-mono" id="dashboard-live-clock">{{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</span>
            </div>
            <div class="flex items-center gap-space-xs bg-surface-container-low border border-surface-container px-space-md py-space-sm rounded-xl shadow-sm">
                <span class="material-symbols-outlined text-secondary text-[18px]">badge</span>
                <span class="font-bold text-label-md text-secondary">Periode: 13 Juli – 30 Des 2026</span>
            </div>
        </div>
    </div>

    <!-- Quick Attendance Action Bar -->
    <div class="p-space-md rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-sm">
            <div class="w-10 h-10 rounded-lg bg-surface-container-low text-secondary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px] filled">fingerprint</span>
            </div>
            <div class="flex flex-col">
                <h3 class="font-bold text-label-md text-primary">Aksi Presensi Harian Cepat</h3>
                <span class="text-body-sm text-on-surface-variant">
                    @if($todayAttendance)
                        Presensi hari ini: <strong class="text-primary">{{ $todayAttendance->status }}</strong> (Masuk: {{ $todayAttendance->time_in ?? '-' }} • Pulang: {{ $todayAttendance->time_out ?? 'Belum' }})
                    @else
                        Sesi presensi masuk dibuka hari ini. Silakan konfirmasi kehadiran Anda.
                    @endif
                </span>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-space-xs">
            <a href="{{ route('attendances.create') }}" 
               class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary font-bold text-label-md shadow-sm hover:bg-primary transition-all">
                <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                <span>Buka Formulir Presensi</span>
            </a>

            @if(!$todayAttendance)
                <!-- Form Presensi Masuk Cepat -->
                <form action="{{ route('attendances.store') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="type" value="check_in">
                    <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-space-md py-2.5 rounded-lg bg-[#059669] hover:bg-[#047857] text-white font-bold text-label-md shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">login</span>
                        <span>Presensi Masuk</span>
                    </button>
                </form>
            @elseif(!$todayAttendance->time_out && !in_array($todayAttendance->status, ['Izin', 'Sakit']))
                <!-- Form Presensi Pulang Cepat -->
                <form action="{{ route('attendances.store') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="type" value="check_out">
                    <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-space-md py-2.5 rounded-lg bg-secondary hover:bg-secondary-container text-white font-bold text-label-md shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        <span>Presensi Pulang</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- 5 Cards Statistik Presensi (Civic Horizon Bento Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-space-md">
        <!-- Card 1: Hari Kerja Berjalan -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl border border-surface-container shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-space-md">
                <span class="font-semibold text-label-md text-on-surface-variant">Hari Kerja Berjalan</span>
                <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                </div>
            </div>
            <div class="flex items-baseline gap-space-xs">
                <span class="font-bold text-headline-xl text-primary">{{ $workDaysPassed ?? 73 }}</span>
                <span class="text-body-md text-on-surface-variant">Hari</span>
            </div>
            <span class="text-label-sm text-on-surface-variant mt-space-xs">Dari total 119 hari rencana kerja</span>
        </div>

        <!-- Card 2: Sisa Hari Kerja -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl border border-surface-container shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-space-md">
                <span class="font-semibold text-label-md text-on-surface-variant">Sisa Hari Kerja</span>
                <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[20px]">pending_actions</span>
                </div>
            </div>
            <div class="flex items-baseline gap-space-xs">
                <span class="font-bold text-headline-xl text-secondary">{{ $workDaysRemaining ?? 46 }}</span>
                <span class="text-body-md text-on-surface-variant">Hari</span>
            </div>
            <span class="text-label-sm text-on-surface-variant mt-space-xs">Hingga 30 Des 2026</span>
        </div>

        <!-- Card 3: Hadir -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl border border-surface-container shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-space-md">
                <span class="font-semibold text-label-md text-on-surface-variant">Hadir Tepat</span>
                <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-[#047857]">
                    <span class="material-symbols-outlined text-[20px] filled">check_circle</span>
                </div>
            </div>
            <div class="flex items-baseline gap-space-xs">
                <span class="font-bold text-headline-xl text-[#047857]">{{ $hadir }}</span>
                <span class="text-body-md text-on-surface-variant">Hari</span>
            </div>
            @php
                $hadirPercent = $totalPresensi > 0 ? round(($hadir / $totalPresensi) * 100, 1) : 0;
            @endphp
            <span class="text-label-sm text-[#047857] mt-space-xs font-semibold">{{ $hadirPercent }}% kehadiran berjalan</span>
        </div>

        <!-- Card 4: Terlambat -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl border border-surface-container shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-space-md">
                <span class="font-semibold text-label-md text-on-surface-variant">Terlambat</span>
                <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-[#b45309]">
                    <span class="material-symbols-outlined text-[20px]">schedule</span>
                </div>
            </div>
            <div class="flex items-baseline gap-space-xs">
                <span class="font-bold text-headline-xl text-[#b45309]">{{ $terlambat }}</span>
                <span class="text-body-md text-on-surface-variant">Hari</span>
            </div>
            <span class="text-label-sm text-[#b45309] mt-space-xs font-semibold">Toleransi evaluasi dinas</span>
        </div>

        <!-- Card 5: Izin & Sakit -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl border border-surface-container shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-space-md">
                <span class="font-semibold text-label-md text-on-surface-variant">Izin & Sakit</span>
                <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-[#1d4ed8]">
                    <span class="material-symbols-outlined text-[20px]">assignment_late</span>
                </div>
            </div>
            <div class="flex items-baseline gap-space-xs">
                <span class="font-bold text-headline-sm text-primary">{{ $izin }} Izin / {{ $sakit }} Sakit</span>
            </div>
            <span class="text-label-sm text-on-surface-variant mt-space-xs font-medium">Surat keterangan valid</span>
        </div>
    </div>

    <!-- Riwayat Presensi Terbaru Section -->
    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs pb-space-lg border-b border-surface-container">
            <div class="flex flex-col">
                <div class="flex items-center gap-space-xs">
                    <span class="material-symbols-outlined text-primary text-[20px]">history</span>
                    <h2 class="font-bold text-headline-sm text-primary">Riwayat Presensi Terbaru</h2>
                </div>
                <p class="text-body-sm text-on-surface-variant mt-0.5">5 data presensi terakhir Anda</p>
            </div>
            <div class="flex items-center gap-space-xs text-on-surface-variant text-label-sm bg-surface-container-low px-space-sm py-1.5 rounded-lg self-start sm:self-auto">
                <span class="material-symbols-outlined text-[16px] text-secondary">domain_verification</span>
                <span>Lokasi Utama: Balai Kota DKI Jakarta</span>
            </div>
        </div>

        <!-- Tabel Data Presensi -->
        <div class="overflow-x-auto mt-space-md">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant font-bold text-label-sm uppercase tracking-wider">
                        <th class="py-space-sm px-space-md rounded-l-lg w-12 text-center" scope="col">No</th>
                        <th class="py-space-sm px-space-md" scope="col">Tanggal</th>
                        <th class="py-space-sm px-space-md" scope="col">Jam Masuk</th>
                        <th class="py-space-sm px-space-md" scope="col">Jam Pulang</th>
                        <th class="py-space-sm px-space-md" scope="col">Status</th>
                        <th class="py-space-sm px-space-md rounded-r-lg" scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="text-body-md text-on-surface divide-y divide-surface-container">
                    @forelse($latestAttendances as $index => $item)
                        @php
                            $statusStyle = match(strtolower($item->status)) {
                                'hadir' => ['bg' => 'bg-[#ecfdf5]', 'text' => 'text-[#047857]', 'dot' => 'bg-[#047857]'],
                                'terlambat' => ['bg' => 'bg-[#fffbeb]', 'text' => 'text-[#b45309]', 'dot' => 'bg-[#b45309]'],
                                'izin' => ['bg' => 'bg-[#eff6ff]', 'text' => 'text-[#1d4ed8]', 'dot' => 'bg-[#1d4ed8]'],
                                'sakit' => ['bg' => 'bg-[#fef2f2]', 'text' => 'text-[#b91c1c]', 'dot' => 'bg-[#b91c1c]'],
                                default => ['bg' => 'bg-surface-container', 'text' => 'text-primary', 'dot' => 'bg-primary'],
                            };
                        @endphp
                        <tr class="hover:bg-surface-container-low/60 transition-colors">
                            <td class="py-space-md px-space-md text-center font-bold text-label-md text-on-surface-variant">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-space-md px-space-md font-semibold text-primary whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd, D MMM Y') }}
                            </td>
                            <td class="py-space-md px-space-md font-medium text-on-surface whitespace-nowrap">
                                {{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('H:i') . ' WIB' : '—' }}
                            </td>
                            <td class="py-space-md px-space-md font-medium text-on-surface whitespace-nowrap">
                                {{ $item->time_out ? \Carbon\Carbon::parse($item->time_out)->format('H:i') . ' WIB' : '—' }}
                            </td>
                            <td class="py-space-md px-space-md whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-label-sm font-semibold {{ $statusStyle['bg'] }} {{ $statusStyle['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-space-md px-space-md text-on-surface-variant text-body-sm">
                                {{ $item->notes ?? ($item->status === 'Hadir' ? 'Tepat waktu' : ($item->status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Surat keterangan diajukan')) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-space-lg text-center text-on-surface-variant text-body-md">
                                Belum ada data riwayat presensi tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Summary Info -->
        <div class="mt-space-lg pt-space-md flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm text-on-surface-variant text-body-sm bg-surface-container-low p-space-md rounded-lg">
            <div class="flex items-center gap-space-xs">
                <span class="material-symbols-outlined text-primary text-[18px]">verified_user</span>
                <span>Semua data presensi tervalidasi otomatis oleh Subbagian Kepegawaian Bappeda DKI Jakarta</span>
            </div>
            <div class="font-bold text-label-sm text-primary">
                Terakhir diperbarui: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMM Y, H:i') }} WIB
            </div>
        </div>
    </div>

</div>
@endsection
