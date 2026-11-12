@extends('layouts.app')

@section('title', 'Detail Riwayat Presensi - ' . $user->name)
@section('breadcrumb', 'Detail Presensi ' . $user->name)

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- Back Button & Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('reports.index') }}" 
               class="w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container text-primary flex items-center justify-center transition-colors border border-surface-container"
               title="Kembali ke Rekap Laporan">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div class="flex flex-col">
                <h2 class="font-bold text-headline-sm lg:text-headline-lg text-primary leading-tight">
                    {{ $user->name }}
                </h2>
                <p class="text-body-sm text-on-surface-variant">
                    {{ $user->email }} • Peserta Magang - Bidang PPIP
                </p>
            </div>
        </div>

        <a href="{{ route('attendances.report.pdf', ['user_id' => $user->id, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" 
           class="inline-flex items-center gap-1.5 px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary font-bold text-label-md shadow-sm hover:bg-primary transition-all">
            <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
            <span>Cetak PDF Peserta Ini</span>
        </a>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-space-md">
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-surface-container shadow-sm flex flex-col justify-between">
            <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Total Presensi</span>
            <span class="font-bold text-headline-lg text-primary mt-2">{{ $summary['total'] }}</span>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-surface-container shadow-sm flex flex-col justify-between">
            <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Hadir Tepat</span>
            <span class="font-bold text-headline-lg text-[#047857] mt-2">{{ $summary['hadir'] }}</span>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-surface-container shadow-sm flex flex-col justify-between">
            <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Terlambat</span>
            <span class="font-bold text-headline-lg text-[#b45309] mt-2">{{ $summary['terlambat'] }}</span>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-surface-container shadow-sm flex flex-col justify-between">
            <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Izin</span>
            <span class="font-bold text-headline-lg text-[#0051d5] mt-2">{{ $summary['izin'] }}</span>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-surface-container shadow-sm flex flex-col justify-between col-span-2 sm:col-span-1">
            <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Sakit</span>
            <span class="font-bold text-headline-lg text-[#ba1a1a] mt-2">{{ $summary['sakit'] }}</span>
        </div>
    </div>

    <!-- Filter Periode -->
    <section class="p-space-lg rounded-xl bg-surface-container-lowest border border-surface-container shadow-sm flex flex-col gap-space-md">
        <div class="flex items-center gap-2 pb-space-xs border-b border-surface-container">
            <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
            <h3 class="font-bold text-headline-sm text-primary">Filter Periode Presensi Peserta</h3>
        </div>

        <form method="GET" action="{{ route('reports.user.detail', $user) }}" class="grid grid-cols-1 sm:grid-cols-12 gap-space-md items-end">
            <div class="sm:col-span-5 flex flex-col gap-1.5">
                <label for="start_date" class="font-bold text-label-md text-primary">Tanggal Awal</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" 
                       class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest">
            </div>

            <div class="sm:col-span-5 flex flex-col gap-1.5">
                <label for="end_date" class="font-bold text-label-md text-primary">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" 
                       class="w-full h-11 px-3 rounded-lg bg-surface-container-low border border-surface-container text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-surface-container-lowest">
            </div>

            <div class="sm:col-span-2">
                <button type="submit" 
                        class="w-full h-11 flex items-center justify-center gap-1.5 px-space-md rounded-lg bg-primary-container text-on-primary font-bold text-label-md hover:bg-primary transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    <span>Tampilkan</span>
                </button>
            </div>
        </form>
    </section>

    <!-- Table Section -->
    <div class="bg-surface-container-lowest rounded-xl border border-surface-container shadow-sm p-space-lg">
        <div class="flex items-center justify-between pb-space-md border-b border-surface-container">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[20px] filled">history</span>
                <h3 class="font-bold text-headline-sm text-primary">Log Kehadiran Individual</h3>
            </div>
            <span class="text-body-sm font-semibold text-on-surface-variant">
                {{ $records->count() }} Hari Terdata
            </span>
        </div>

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
                    @forelse($records as $index => $item)
                        @php
                            $statusStyle = match(strtolower($item->status)) {
                                'hadir' => ['bg' => 'bg-[#ecfdf5]', 'text' => 'text-[#047857]', 'dot' => 'bg-[#047857]'],
                                'terlambat' => ['bg' => 'bg-[#fffbeb]', 'text' => 'text-[#b45309]', 'dot' => 'bg-[#b45309]'],
                                'izin' => ['bg' => 'bg-[#eff6ff]', 'text' => 'text-[#0051d5]', 'dot' => 'bg-[#0051d5]'],
                                'sakit' => ['bg' => 'bg-[#fef2f2]', 'text' => 'text-[#ba1a1a]', 'dot' => 'bg-[#ba1a1a]'],
                                default => ['bg' => 'bg-surface-container', 'text' => 'text-primary', 'dot' => 'bg-primary'],
                            };
                        @endphp
                        <tr class="hover:bg-surface-container-low/60 transition-colors">
                            <td class="py-space-md px-space-md text-center font-bold text-label-md text-on-surface-variant">
                                {{ $index + 1 }}
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
                                {{ $item->notes ?? ($item->status === 'Hadir' ? 'Tepat waktu - Balai Kota' : ($item->status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Surat keterangan diajukan')) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-space-xl text-center text-on-surface-variant text-body-md">
                                Belum ada riwayat kehadiran tercatat untuk rentang tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
