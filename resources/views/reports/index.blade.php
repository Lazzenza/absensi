@extends('layouts.app')

@section('title', 'Laporan Presensi - Bappeda DKI Jakarta')
@section('breadcrumb', 'Laporan Presensi')

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- Top Header & Action Row -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md">
        <div class="flex flex-col gap-space-xs max-w-3xl">
            <div class="flex items-center gap-space-xs text-secondary font-bold text-label-sm uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px] filled">verified_user</span>
                <span>Rekapitulasi Resmi Kepegawaian</span>
            </div>
            <h1 class="font-bold text-headline-xl text-primary tracking-tight">Laporan Presensi</h1>
            <p class="text-body-md text-on-surface-variant leading-relaxed">
                Rekapitulasi dan ringkasan eksekutif kehadiran peserta magang Bappeda Provinsi DKI Jakarta periode 13 Juli – 30 Desember 2026.
            </p>
        </div>

        <!-- Export & Printing Actions -->
        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <a href="{{ route('attendances.report.csv', request()->query()) }}" 
               class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-low text-primary font-bold text-label-md hover:bg-surface-container transition-all border border-surface-container shadow-sm">
                <span class="material-symbols-outlined text-[18px] text-secondary">table_chart</span>
                <span>Unduh CSV</span>
            </a>
            <button type="button" onclick="window.print()" 
                    class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-low text-primary font-bold text-label-md hover:bg-surface-container transition-all border border-surface-container shadow-sm">
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant">print</span>
                <span>Cetak Laporan</span>
            </button>
            <a href="{{ route('reports.preview', request()->query()) }}" 
               class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-lowest text-primary font-bold text-label-md hover:bg-surface-container transition-all border border-secondary shadow-sm">
                <span class="material-symbols-outlined text-[18px] text-secondary">visibility</span>
                <span>Pratinjau Dokumen</span>
            </a>
            <a href="{{ route('attendances.report.pdf', request()->query()) }}" target="_blank"
               class="inline-flex items-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-primary-container text-on-primary font-bold text-label-md hover:bg-primary transition-all shadow-md">
                <span class="material-symbols-outlined text-[20px] text-secondary-fixed">picture_as_pdf</span>
                <span>Export PDF</span>
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <section class="rounded-xl bg-surface-container-lowest border border-surface-container p-space-lg shadow-sm flex flex-col gap-space-md">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-xs pb-space-xs border-b border-surface-container">
            <div class="flex items-center gap-space-xs">
                <div class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                </div>
                <div>
                    <h2 class="font-bold text-headline-sm text-primary">Filter Rekapitulasi Laporan</h2>
                    <p class="text-body-sm text-on-surface-variant">Ringkasan statistik dan data tabel di bawah otomatis menyesuaikan kriteria filter yang aktif.</p>
                </div>
            </div>
            <span class="text-label-sm text-secondary bg-surface-container-low border border-surface-container px-space-sm py-1 rounded-full w-fit font-bold">
                Kriteria Aktif
            </span>
        </div>

        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col gap-space-md">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
                <!-- Date Range: Start -->
                <div class="flex flex-col gap-space-xs">
                    <label class="font-bold text-label-md text-primary" for="start_date">Dari Tanggal</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-on-surface-variant pointer-events-none">date_range</span>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                               class="w-full h-11 pl-10 pr-3 rounded-lg bg-surface-container-low border border-surface-container font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest">
                    </div>
                </div>

                <!-- Date Range: End -->
                <div class="flex flex-col gap-space-xs">
                    <label class="font-bold text-label-md text-primary" for="end_date">Sampai Tanggal</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-on-surface-variant pointer-events-none">date_range</span>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                               class="w-full h-11 pl-10 pr-3 rounded-lg bg-surface-container-low border border-surface-container font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="flex flex-col gap-space-xs">
                    <label class="font-bold text-label-md text-primary" for="filter-status">Status Kehadiran</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-on-surface-variant pointer-events-none">filter_alt</span>
                        <select name="status" id="filter-status"
                                class="w-full h-11 pl-10 pr-8 rounded-lg bg-surface-container-low border border-surface-container font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir Saja</option>
                            <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat Saja</option>
                            <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin Saja</option>
                            <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit Saja</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>

                <!-- Tahun Anggaran -->
                <div class="flex flex-col gap-space-xs">
                    <label class="font-bold text-label-md text-primary" for="filter-tahun">Tahun Anggaran</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-on-surface-variant pointer-events-none">event</span>
                        <select id="filter-tahun"
                                class="w-full h-11 pl-10 pr-8 rounded-lg bg-surface-container-low border border-surface-container font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary appearance-none cursor-pointer">
                            <option value="2026" selected>2026 (Aktif)</option>
                            <option value="2025">2025</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center justify-end gap-space-sm pt-space-xs border-t border-surface-container">
                <a href="{{ route('reports.index') }}" 
                   class="px-space-md py-2.5 rounded-lg bg-surface-container-low text-on-surface-variant font-bold text-label-md hover:bg-surface-container hover:text-primary transition-colors flex items-center gap-1.5 border border-surface-container">
                    <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    <span>Reset Filter</span>
                </a>
                <button type="submit" 
                        class="px-space-lg py-2.5 rounded-lg bg-primary-container text-on-primary font-bold text-label-md hover:bg-primary transition-all flex items-center gap-1.5 shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </form>
    </section>

    <!-- Summary Metric Cards (5 Columns Bento Grid) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-space-md">
        <!-- 1. Total Presensi -->
        <div class="rounded-xl bg-surface-container-lowest border border-surface-container p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between gap-space-sm relative overflow-hidden">
            <div class="flex items-start justify-between">
                <span class="font-bold text-label-md text-on-surface-variant">Total Presensi</span>
                <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-xl text-primary">{{ $summary['total'] }}</span>
                    <span class="font-bold text-label-sm text-on-surface-variant">Log Data</span>
                </div>
                <p class="text-body-sm text-on-surface-variant mt-1">Periode aktif berjalan</p>
            </div>
            <div class="w-full bg-surface-container-low h-1.5 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full" style="width: 100%;"></div>
            </div>
        </div>

        <!-- 2. Hadir Tepat -->
        <div class="rounded-xl bg-surface-container-lowest border border-surface-container p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between gap-space-sm relative overflow-hidden">
            <div class="flex items-start justify-between">
                <span class="font-bold text-label-md text-on-surface-variant">Hadir Tepat</span>
                <div class="w-8 h-8 rounded-lg bg-[#ecfdf5] flex items-center justify-center text-[#047857]">
                    <span class="material-symbols-outlined text-[18px] filled">check_circle</span>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-xl text-[#047857]">{{ $summary['hadir'] }}</span>
                    <span class="font-bold text-label-sm text-on-surface-variant">Hari</span>
                </div>
                @php
                    $rateHadir = $summary['total'] > 0 ? round(($summary['hadir'] / $summary['total']) * 100, 1) : 0;
                @endphp
                <p class="text-body-sm text-[#047857] font-semibold mt-1">{{ $rateHadir }}% dari total</p>
            </div>
            <div class="w-full bg-surface-container-low h-1.5 rounded-full overflow-hidden">
                <div class="bg-[#047857] h-full rounded-full" style="width: {{ $rateHadir }}%;"></div>
            </div>
        </div>

        <!-- 3. Terlambat -->
        <div class="rounded-xl bg-surface-container-lowest border border-surface-container p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between gap-space-sm relative overflow-hidden">
            <div class="flex items-start justify-between">
                <span class="font-bold text-label-md text-on-surface-variant">Terlambat</span>
                <div class="w-8 h-8 rounded-lg bg-[#fffbeb] flex items-center justify-center text-[#b45309]">
                    <span class="material-symbols-outlined text-[18px] filled">schedule</span>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-xl text-[#b45309]">{{ $summary['terlambat'] }}</span>
                    <span class="font-bold text-label-sm text-on-surface-variant">Hari</span>
                </div>
                <p class="text-body-sm text-[#b45309] font-medium mt-1">Toleransi kedinasan</p>
            </div>
            <div class="w-full bg-surface-container-low h-1.5 rounded-full overflow-hidden">
                <div class="bg-[#b45309] h-full rounded-full" style="width: 30%;"></div>
            </div>
        </div>

        <!-- 4. Izin -->
        <div class="rounded-xl bg-surface-container-lowest border border-surface-container p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between gap-space-sm relative overflow-hidden">
            <div class="flex items-start justify-between">
                <span class="font-bold text-label-md text-on-surface-variant">Izin</span>
                <div class="w-8 h-8 rounded-lg bg-[#eff6ff] flex items-center justify-center text-[#1d4ed8]">
                    <span class="material-symbols-outlined text-[18px] filled">assignment_late</span>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-xl text-[#1d4ed8]">{{ $summary['izin'] }}</span>
                    <span class="font-bold text-label-sm text-on-surface-variant">Hari</span>
                </div>
                <p class="text-body-sm text-on-surface-variant mt-1">Keperluan dinas / studi</p>
            </div>
            <div class="w-full bg-surface-container-low h-1.5 rounded-full overflow-hidden">
                <div class="bg-[#1d4ed8] h-full rounded-full" style="width: 20%;"></div>
            </div>
        </div>

        <!-- 5. Sakit -->
        <div class="rounded-xl bg-surface-container-lowest border border-surface-container p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between gap-space-sm relative overflow-hidden">
            <div class="flex items-start justify-between">
                <span class="font-bold text-label-md text-on-surface-variant">Sakit</span>
                <div class="w-8 h-8 rounded-lg bg-[#fef2f2] flex items-center justify-center text-[#ba1a1a]">
                    <span class="material-symbols-outlined text-[18px] filled">medical_services</span>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-xl text-[#ba1a1a]">{{ $summary['sakit'] }}</span>
                    <span class="font-bold text-label-sm text-on-surface-variant">Hari</span>
                </div>
                <p class="text-body-sm text-on-surface-variant mt-1">Dispensasi faskes</p>
            </div>
            <div class="w-full bg-surface-container-low h-1.5 rounded-full overflow-hidden">
                <div class="bg-[#ba1a1a] h-full rounded-full" style="width: 10%;"></div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs pb-space-md border-b border-surface-container">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">description</span>
                <h3 class="font-bold text-headline-sm text-primary">Detail Log Laporan Presensi</h3>
            </div>
            <span class="text-body-sm text-on-surface-variant font-medium">
                Total <strong>{{ $records->count() }}</strong> data catatan tervalidasi
            </span>
        </div>

        <div class="overflow-x-auto mt-space-md">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant font-bold text-label-sm uppercase tracking-wider">
                        <th class="py-space-sm px-space-md rounded-l-lg w-12 text-center" scope="col">No</th>
                        <th class="py-space-sm px-space-md" scope="col">Nama Peserta</th>
                        <th class="py-space-sm px-space-md" scope="col">Tanggal</th>
                        <th class="py-space-sm px-space-md" scope="col">Jam Masuk</th>
                        <th class="py-space-sm px-space-md" scope="col">Jam Pulang</th>
                        <th class="py-space-sm px-space-md" scope="col">Status</th>
                        <th class="py-space-sm px-space-md rounded-r-lg" scope="col">Keterangan / Validasi</th>
                    </tr>
                </thead>
                <tbody class="text-body-md text-on-surface divide-y divide-surface-container">
                    @forelse($records as $index => $item)
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
                            <td class="py-space-md px-space-md whitespace-nowrap">
                                <span class="font-bold text-label-md text-primary">
                                    {{ $item->user?->name ?? 'User #' . $item->user_id }}
                                </span>
                            </td>
                            <td class="py-space-md px-space-md font-medium text-primary whitespace-nowrap">
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
                                {{ $item->notes ?? ($item->status === 'Hadir' ? 'Tepat waktu - Balai Kota Blok G' : ($item->status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Surat keterangan diajukan')) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-space-xl text-center text-on-surface-variant text-body-md">
                                Tidak ada rekaman data presensi untuk periode tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
