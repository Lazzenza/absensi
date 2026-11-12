@extends('layouts.app')

@section('title', 'Daftar Presensi - Sistem Presensi Bappeda DKI Jakarta')
@section('breadcrumb', 'Daftar Presensi')

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- Top Navigation & Action Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
        <div class="flex flex-col gap-space-xs">
            <div class="flex items-center gap-space-xs text-on-surface-variant font-bold text-label-sm uppercase tracking-wider">
                <span class="text-secondary">Bappeda Provinsi DKI Jakarta</span>
                <span class="text-outline-variant">•</span>
                <span>Portal Magang</span>
                <span class="text-outline-variant">•</span>
                <span class="text-primary font-semibold">Data Presensi</span>
            </div>
            <h1 class="font-bold text-headline-xl text-primary tracking-tight">Daftar Presensi</h1>
            <p class="text-body-md text-on-surface-variant">
                Pencarian dan penapisan rekapitulasi data kehadiran peserta magang Bappeda Provinsi DKI Jakarta.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <button type="button" onclick="window.print()" 
                    class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-lowest border border-surface-container text-primary shadow-sm hover:bg-surface-container transition font-bold text-label-md">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span>Cetak Rekap</span>
            </button>
            <a href="{{ route('attendances.report.csv', request()->query()) }}" 
               class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-low border border-surface-container text-primary shadow-sm hover:bg-surface-container transition font-bold text-label-md">
                <span class="material-symbols-outlined text-[18px] text-secondary">table_view</span>
                <span>Unduh Excel / CSV</span>
            </a>
            <a href="{{ route('attendances.report.pdf', request()->query()) }}" target="_blank"
               class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary shadow-sm hover:bg-primary transition font-bold text-label-md">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Export PDF</span>
            </a>
        </div>
    </div>

    <!-- Metric Statistics Cards (Civic Horizon 4 Cols) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
        <!-- Card 1: Hadir Tepat Waktu -->
        <div class="p-space-lg rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex flex-col gap-1">
                <span class="font-bold text-label-sm uppercase tracking-wider text-on-surface-variant">Hadir Tepat Waktu</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-lg text-primary">{{ $summary['hadir'] }}</span>
                    <span class="text-body-sm text-on-surface-variant">Hari</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#ecfdf5] flex items-center justify-center text-[#047857]">
                <span class="material-symbols-outlined text-[24px] filled">task_alt</span>
            </div>
        </div>

        <!-- Card 2: Terlambat Masuk -->
        <div class="p-space-lg rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex flex-col gap-1">
                <span class="font-bold text-label-sm uppercase tracking-wider text-on-surface-variant">Terlambat Masuk</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-lg text-primary">{{ $summary['terlambat'] }}</span>
                    <span class="text-body-sm text-on-surface-variant">Hari</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#fffbeb] flex items-center justify-center text-[#b45309]">
                <span class="material-symbols-outlined text-[24px] filled">schedule</span>
            </div>
        </div>

        <!-- Card 3: Izin Akademik -->
        <div class="p-space-lg rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex flex-col gap-1">
                <span class="font-bold text-label-sm uppercase tracking-wider text-on-surface-variant">Izin Akademik</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-lg text-primary">{{ $summary['izin'] }}</span>
                    <span class="text-body-sm text-on-surface-variant">Hari</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#eff6ff] flex items-center justify-center text-[#0051d5]">
                <span class="material-symbols-outlined text-[24px] filled">description</span>
            </div>
        </div>

        <!-- Card 4: Dispensasi Sakit -->
        <div class="p-space-lg rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex flex-col gap-1">
                <span class="font-bold text-label-sm uppercase tracking-wider text-on-surface-variant">Dispensasi Sakit</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-bold text-headline-lg text-primary">{{ $summary['sakit'] }}</span>
                    <span class="text-body-sm text-on-surface-variant">Hari</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#fef2f2] flex items-center justify-center text-[#ba1a1a]">
                <span class="material-symbols-outlined text-[24px] filled">medical_services</span>
            </div>
        </div>
    </div>

    <!-- Main Filter and Search Module -->
    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg flex flex-col gap-space-md">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-xs pb-space-xs border-b border-surface-container">
            <div class="flex items-center gap-space-sm">
                <div class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">filter_alt</span>
                </div>
                <div>
                    <h2 class="font-bold text-headline-sm text-primary">Filter & Pencarian Data Presensi</h2>
                    <p class="text-body-sm text-on-surface-variant">
                        Semua filter dapat dikombinasikan secara bersamaan untuk mempersempit hasil pencarian.
                    </p>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('attendances.index') }}" class="flex flex-col gap-space-md">
            <!-- Filter Inputs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md pt-space-xs">
                <!-- 1. Search by Name -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-label-md text-primary" for="search-name">Nama Peserta Magang</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline">search</span>
                        <input type="text" name="search" id="search-name" value="{{ request('search') }}" 
                               placeholder="Cari nama peserta..."
                               class="w-full h-11 pl-9 pr-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors">
                    </div>
                </div>

                <!-- 2. Specific Date Picker -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-label-md text-primary" for="filter-date">Tanggal Spesifik</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline">calendar_today</span>
                        <input type="date" name="date" id="filter-date" value="{{ request('date') }}"
                               class="w-full h-11 pl-9 pr-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors">
                    </div>
                </div>

                <!-- 3. Rentang Tanggal: Dari -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-label-md text-primary" for="start_date">Dari Tanggal</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline">date_range</span>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                               class="w-full h-11 pl-9 pr-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors">
                    </div>
                </div>

                <!-- 4. Rentang Tanggal: Sampai -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-label-md text-primary" for="end_date">Sampai Tanggal</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline">date_range</span>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                               class="w-full h-11 pl-9 pr-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors">
                    </div>
                </div>

                <!-- 5. Month Select -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-label-md text-primary" for="filter-month">Bulan</label>
                    <div class="relative flex items-center">
                        <select name="month" id="filter-month" 
                                class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors appearance-none cursor-pointer">
                            <option value="">Semua Bulan</option>
                            <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                            <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 pointer-events-none text-[18px] text-outline">expand_more</span>
                    </div>
                </div>

                <!-- 6. Status Select -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-label-md text-primary" for="filter-status">Status Kehadiran</label>
                    <div class="relative flex items-center">
                        <select name="status" id="filter-status"
                                class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest transition-colors appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir Saja</option>
                            <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat Saja</option>
                            <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin Saja</option>
                            <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit Saja</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 pointer-events-none text-[18px] text-outline">expand_more</span>
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center justify-end gap-space-sm pt-space-xs border-t border-surface-container">
                <a href="{{ route('attendances.index') }}" 
                   class="inline-flex items-center gap-1.5 px-space-md py-2.5 rounded-lg bg-surface-container-low border border-surface-container text-on-surface-variant hover:text-primary font-bold text-label-md transition-colors">
                    <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    <span>Reset Filter</span>
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-1.5 px-space-lg py-2.5 rounded-lg bg-primary-container hover:bg-primary text-on-primary font-bold text-label-md shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table Presensi -->
    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs pb-space-md border-b border-surface-container">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">table_rows</span>
                <h3 class="font-bold text-headline-sm text-primary">Rekapitulasi Data Kehadiran</h3>
            </div>
            <span class="text-body-sm text-on-surface-variant font-medium">
                Menampilkan <strong>{{ $attendances->firstItem() ?? 0 }}</strong> - <strong>{{ $attendances->lastItem() ?? 0 }}</strong> dari <strong>{{ $attendances->total() }}</strong> total log
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
                        <th class="py-space-sm px-space-md rounded-r-lg" scope="col">Keterangan / Catatan</th>
                    </tr>
                </thead>
                <tbody class="text-body-md text-on-surface divide-y divide-surface-container">
                    @forelse($attendances as $index => $item)
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
                                {{ $attendances->firstItem() + $index }}
                            </td>
                            <td class="py-space-md px-space-md whitespace-nowrap">
                                <div class="flex items-center gap-space-xs">
                                    <div class="w-7 h-7 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($item->user?->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-label-md text-primary">
                                            {{ $item->user?->name ?? 'User #' . $item->user_id }}
                                        </span>
                                        <span class="text-body-sm text-on-surface-variant">
                                            {{ $item->user?->email ?? '-' }}
                                        </span>
                                    </div>
                                </div>
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
                                {{ $item->notes ?? ($item->status === 'Hadir' ? 'Tepat waktu' : ($item->status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Surat keterangan diajukan')) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-space-xl text-center text-on-surface-variant text-body-md">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[36px] text-outline">search_off</span>
                                    <span>Tidak ada data presensi yang sesuai dengan kriteria filter pencarian.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="mt-space-lg pt-space-md border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-space-sm">
            <span class="text-body-sm text-on-surface-variant">
                Menampilkan halaman <strong>{{ $attendances->currentPage() }}</strong> dari <strong>{{ $attendances->lastPage() }}</strong>
            </span>
            <div>
                {{ $attendances->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

</div>
@endsection
