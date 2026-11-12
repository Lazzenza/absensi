<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Dokumen Presensi - Bappeda DKI Jakarta</title>
    
    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CSS -->
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
                        "surface-container-high": "#dce9ff",
                        "surface-container-highest": "#d3e4fe",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#44474f",
                        "outline": "#747780",
                        "outline-variant": "#c4c6d0"
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #eff4ff;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            #a4-document {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="min-h-screen text-on-surface antialiased flex flex-col">

    <!-- Document Viewer Controls Toolbar -->
    <header class="no-print bg-surface-container-lowest px-4 lg:px-8 py-3 border-b border-surface-container sticky top-0 z-50 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('reports.index') }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-primary hover:bg-surface-container-low transition-colors font-bold text-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Laporan</span>
            </a>
            <span class="hidden sm:inline-block w-px h-5 bg-outline-variant/50"></span>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[22px]">picture_as_pdf</span>
                <div class="flex flex-col">
                    <span class="font-bold text-xs lg:text-sm text-primary tracking-tight">LAPORAN_PRESENSI_MAGANG_BAPPEDA_DKI_2026.pdf</span>
                    <span class="text-[11px] text-on-surface-variant">Pratinjau Cetak Formal (Format Kedinasan A4)</span>
                </div>
            </div>
        </div>

        <!-- Viewer Actions & Zoom -->
        <div class="flex items-center gap-2">
            <!-- Zoom Controls -->
            <div class="flex items-center bg-surface-container-low rounded-lg p-1 border border-surface-container">
                <button type="button" id="zoom-out-btn" aria-label="Perkecil" onclick="changeZoom(-10)"
                        class="p-1 text-primary hover:bg-surface-container rounded transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">remove</span>
                </button>
                <span id="zoom-text" class="px-2 font-bold text-xs text-primary select-none">100%</span>
                <button type="button" id="zoom-in-btn" aria-label="Perbesar" onclick="changeZoom(10)"
                        class="p-1 text-primary hover:bg-surface-container rounded transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                </button>
            </div>

            <!-- Action Buttons -->
            <button type="button" onclick="window.print()" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-primary font-bold text-xs transition-colors border border-surface-container shadow-sm">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span class="hidden sm:inline">Cetak Dokumen</span>
            </button>
            @if(Auth::user() && Auth::user()->isAdmin())
                <a href="{{ route('attendances.report.pdf', request()->query()) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-primary hover:bg-primary-container text-white font-bold text-xs transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Download PDF</span>
                </a>
            @else
                <span title="Akses Terbatas: Hanya Administrator yang berwenang mengunduh dokumen PDF resmi"
                      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-container text-outline font-bold text-xs cursor-not-allowed opacity-75 border border-surface-container">
                    <span class="material-symbols-outlined text-[18px]">lock</span>
                    <span>Download PDF (Khusus Admin)</span>
                </span>
            @endif
        </div>
    </header>

    <!-- Document Canvas Container -->
    <main class="w-full flex-1 py-8 px-4 flex justify-center items-start overflow-x-auto">
        <!-- Paper A4 Simulation Container -->
        <article id="a4-document" 
                 class="w-full max-w-[850px] bg-white text-on-surface shadow-lg rounded-xl p-8 sm:p-12 md:p-16 transition-transform duration-200 origin-top border border-surface-container">
            
            <!-- KOP INSTANSI RESMI PEMPROV DKI JAKARTA -->
            <header class="flex items-center justify-between gap-4 pb-3">
                <div class="shrink-0 flex items-center justify-start w-20 sm:w-24">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Coat_of_arms_of_Jakarta.svg" 
                         alt="Lambang Jaya Raya DKI Jakarta" 
                         class="h-20 w-auto object-contain mx-auto"
                         onerror="this.style.display='none'">
                </div>
                <div class="flex-1 text-center px-2">
                    <h2 class="text-[14px] font-bold tracking-wider text-slate-800 uppercase leading-snug">
                        PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA
                    </h2>
                    <h1 class="text-[18px] font-extrabold tracking-wide text-slate-950 uppercase mt-0.5 leading-snug">
                        BADAN PERENCANAAN PEMBANGUNAN DAERAH
                    </h1>
                    <p class="text-[10px] text-slate-700 mt-1">
                        Gedung Balai Kota Blok G Lantai 2, Jl. Medan Merdeka Selatan No. 8–9, Jakarta Pusat 10110
                    </p>
                    <p class="text-[10px] text-slate-700">
                        Telepon: (021) 3822208 • Pos-el: bappeda@jakarta.go.id • Laman: bappeda.jakarta.go.id
                    </p>
                </div>
                <div class="shrink-0 w-20 sm:w-24 hidden sm:block" aria-hidden="true"></div>
            </header>

            <!-- Garis Pemisah Ganda Khas Surat Kedinasan RI -->
            <div class="w-full space-y-[2px] mb-6">
                <div class="w-full h-[3px] bg-black"></div>
                <div class="w-full h-[1px] bg-black"></div>
            </div>

            <!-- JUDUL DOKUMEN & NOMOR REGISTRASI -->
            <div class="text-center mb-6">
                <h2 class="text-base sm:text-lg font-bold tracking-wide text-primary uppercase underline underline-offset-4 decoration-1">
                    LAPORAN PRESENSI PESERTA MAGANG
                </h2>
                <p class="text-xs text-on-surface mt-1 font-semibold">
                    Nomor Registrasi Laporan: 800.1/BAPPEDA-PPIP/PRES/{{ strtoupper(date('M')) }}/2026
                </p>
            </div>

            <!-- INFORMASI PEGAWAI MAGANG & PARAMETER FILTER (2 Kolom Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1.5 p-4 bg-surface-container-low rounded-lg mb-6 border border-surface-container text-xs">
                <!-- Kolom Kiri -->
                <div class="space-y-1.5">
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 font-semibold text-primary">Nama Peserta</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 font-bold text-primary">{{ Auth::user()->name ?? 'Rachmat Akbar' }}</span>
                    </div>
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">NIM / ID Magang</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 font-mono font-medium text-on-surface">102042300209 (MG-2026-0842)</span>
                    </div>
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">Unit Penempatan</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 text-on-surface">Bidang Perencanaan Pembangunan & PPIP</span>
                    </div>
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">Pembimbing Lapangan</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 text-on-surface">Dhayani Ardyan, S.STP, M.Si</span>
                    </div>
                </div>
                <!-- Kolom Kanan -->
                <div class="space-y-1.5">
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">Periode Laporan</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 text-on-surface">13 Juli 2026 s.d. 30 Desember 2026</span>
                    </div>
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">Tahun Anggaran</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 text-on-surface">2026</span>
                    </div>
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">Kriteria Filter</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 text-on-surface">{{ request('status') ? 'Status ' . request('status') : 'Semua Status (Aktif)' }}</span>
                    </div>
                    <div class="grid grid-cols-12">
                        <span class="col-span-5 text-on-surface-variant">Waktu Cetak</span>
                        <span class="col-span-1 text-center">:</span>
                        <span class="col-span-6 text-on-surface">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y – H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- TABEL DATA PRESENSI FORMAL KEDINASAN -->
            <div class="w-full overflow-x-auto mb-6">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="py-2 px-2.5 text-center font-bold w-10 border border-primary">No</th>
                            <th class="py-2 px-3 font-bold border border-primary">Nama Peserta</th>
                            <th class="py-2 px-3 font-bold border border-primary">Tanggal</th>
                            <th class="py-2 px-2.5 text-center font-bold border border-primary">Check-in</th>
                            <th class="py-2 px-2.5 text-center font-bold border border-primary">Check-out</th>
                            <th class="py-2 px-3 text-center font-bold w-24 border border-primary">Status</th>
                            <th class="py-2 px-3 font-bold border border-primary">Keterangan / Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="text-on-surface divide-y divide-slate-200">
                        @forelse($attendances as $index => $item)
                            <tr class="{{ $index % 2 == 1 ? 'bg-slate-50' : 'bg-white' }}">
                                <td class="py-2 px-2.5 text-center border border-slate-200 font-medium">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 font-semibold text-primary border border-slate-200">{{ $item->user?->name ?? 'Peserta' }}</td>
                                <td class="py-2 px-3 text-slate-700 border border-slate-200 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd, D MMM Y') }}</td>
                                <td class="py-2 px-2.5 text-center font-mono font-medium border border-slate-200">{{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('H:i') . ' WIB' : '—' }}</td>
                                <td class="py-2 px-2.5 text-center font-mono font-medium border border-slate-200">{{ $item->time_out ? \Carbon\Carbon::parse($item->time_out)->format('H:i') . ' WIB' : '—' }}</td>
                                <td class="py-2 px-3 text-center border border-slate-200">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        {{ strtolower($item->status) === 'hadir' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ strtolower($item->status) === 'terlambat' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ strtolower($item->status) === 'izin' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ strtolower($item->status) === 'sakit' ? 'bg-rose-100 text-rose-800' : '' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-slate-600 border border-slate-200 text-[11px]">
                                    {{ $item->notes ?? ($item->status === 'Hadir' ? 'Tepat Waktu - Balai Kota Blok G' : ($item->status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Surat keterangan diajukan')) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-slate-500 border border-slate-200">
                                    Tidak ada data presensi yang ditemukan untuk kriteria ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- BAGIAN REKAPITULASI TOTAL PRESENSI -->
            <section class="w-full bg-surface-container-low rounded-lg p-4 mb-8 border border-surface-container">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-xs text-primary tracking-wider uppercase">
                        Ringkasan Akumulasi Kehadiran (Periode Aktif)
                    </h3>
                    <span class="text-[11px] text-on-surface-variant">Metode Validasi Geofencing & Biometrik</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2.5 text-center">
                    <div class="bg-white p-2.5 rounded-lg border border-surface-container">
                        <span class="block text-[10px] text-on-surface-variant font-medium">Total Hari Kerja</span>
                        <span class="block font-bold text-base text-primary mt-0.5">{{ $summary['total'] }}</span>
                        <span class="text-[9px] text-outline">Hari Berjalan</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-surface-container">
                        <span class="block text-[10px] text-on-surface-variant font-medium">Tepat Waktu</span>
                        <span class="block font-bold text-base text-[#047857] mt-0.5">{{ $summary['hadir'] }}</span>
                        @php
                            $rateH = $summary['total'] > 0 ? round(($summary['hadir'] / $summary['total']) * 100, 1) : 0;
                        @endphp
                        <span class="text-[9px] text-[#047857] font-semibold">{{ $rateH }}%</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-surface-container">
                        <span class="block text-[10px] text-on-surface-variant font-medium">Terlambat</span>
                        <span class="block font-bold text-base text-[#b45309] mt-0.5">{{ $summary['terlambat'] }}</span>
                        @php
                            $rateT = $summary['total'] > 0 ? round(($summary['terlambat'] / $summary['total']) * 100, 1) : 0;
                        @endphp
                        <span class="text-[9px] text-[#b45309]">{{ $rateT }}%</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-surface-container">
                        <span class="block text-[10px] text-on-surface-variant font-medium">Izin Resmi</span>
                        <span class="block font-bold text-base text-[#0051d5] mt-0.5">{{ $summary['izin'] }}</span>
                        @php
                            $rateI = $summary['total'] > 0 ? round(($summary['izin'] / $summary['total']) * 100, 1) : 0;
                        @endphp
                        <span class="text-[9px] text-[#0051d5]">{{ $rateI }}%</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-surface-container">
                        <span class="block text-[10px] text-on-surface-variant font-medium">Sakit</span>
                        <span class="block font-bold text-base text-[#ba1a1a] mt-0.5">{{ $summary['sakit'] }}</span>
                        @php
                            $rateS = $summary['total'] > 0 ? round(($summary['sakit'] / $summary['total']) * 100, 1) : 0;
                        @endphp
                        <span class="text-[9px] text-[#ba1a1a]">{{ $rateS }}%</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-surface-container">
                        <span class="block text-[10px] text-secondary font-medium">Skor Disiplin</span>
                        @php
                            $score = $summary['total'] > 0 ? round((($summary['hadir'] + ($summary['terlambat'] * 0.5)) / $summary['total']) * 100, 1) : 100;
                        @endphp
                        <span class="block font-bold text-base text-secondary mt-0.5">{{ $score }}%</span>
                        <span class="text-[9px] text-secondary font-semibold">Sangat Baik</span>
                    </div>
                </div>
            </section>

            <!-- BAGIAN PENGESAHAN & TANDA TANGAN KEDINASAN -->
            <footer class="w-full pt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-xs text-on-surface">
                    <!-- Kiri: Peserta Magang -->
                    <div class="flex flex-col items-center text-center">
                        <p class="mb-1 text-slate-700">Mengetahui,</p>
                        <p class="font-bold text-primary uppercase">PESERTA MAGANG</p>
                        <!-- Ruang Tanda Tangan -->
                        <div class="h-24 flex items-center justify-center relative w-full my-1">
                            <svg class="w-36 h-14 text-primary" fill="none" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 50C35 48 55 25 60 20C65 15 70 30 75 55C80 80 85 30 95 35C105 40 120 45 135 42C150 39 165 48 180 45" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M45 40C60 42 100 45 140 40" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-primary underline underline-offset-2">{{ Auth::user()->name ?? 'Rachmat Akbar' }}</p>
                        <p class="text-[11px] text-on-surface-variant">NIM. 102042300209</p>
                    </div>

                    <!-- Kanan: Pembimbing Lapangan & Stempel Elektronik -->
                    <div class="flex flex-col items-center text-center">
                        <p class="mb-0.5 text-slate-700">Jakarta, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
                        <p class="font-bold text-primary uppercase">PEMBIMBING LAPANGAN</p>
                        <p class="text-[11px] text-on-surface font-medium">Kepala Subbagian Tata Usaha</p>
                        <p class="text-[10px] text-on-surface-variant">Pusat Perencanaan dan Informasi Pembangunan</p>
                        <p class="text-[10px] text-on-surface-variant">Bappeda Provinsi DKI Jakarta</p>
                        
                        <!-- Segel Tanda Tangan Digital BSrE + QR Code -->
                        <div class="h-24 flex items-center justify-center gap-3 relative w-full my-1">
                            <div class="w-14 h-14 rounded-full bg-surface-container-high border border-surface-container flex flex-col items-center justify-center p-1 relative shadow-inner">
                                <span class="material-symbols-outlined text-secondary text-[22px] filled">verified</span>
                                <span class="text-[7px] uppercase font-bold text-primary leading-none mt-0.5">TTE BSrE</span>
                            </div>
                            <div class="w-14 h-14 bg-white border border-surface-container p-1 rounded shadow-xs flex items-center justify-center">
                                <svg class="w-full h-full text-primary" fill="currentColor" viewBox="0 0 48 48">
                                    <path d="M4 4h16v16H4V4zm4 4v8h8V8H8zm20-4h16v16H28V4zm4 4v8h8V8h-8zM4 28h16v16H4V28zm4 4v8h8v-8H8zm24 0h4v4h-4v-4zm8 0h4v4h-4v-4zm-8 8h4v4h-4v-4zm8 0h4v4h-4v-4zm-4-4h4v4h-4v-4zm-16-4h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="font-bold text-primary underline underline-offset-2">Dhayani Ardyan, S.STP, M.Si</p>
                        <p class="text-[11px] text-on-surface-variant">NIP. 199109222014031003</p>
                    </div>
                </div>

                <!-- Catatan Kaki Legalitas Digital Kertas A4 -->
                <div class="w-full pt-4 mt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-outline text-[10px] gap-2">
                    <span>Sistem Presensi Elektronik Terpadu Bappeda Provinsi DKI Jakarta</span>
                    <span class="font-medium">Hal 1 dari 1</span>
                    <span>Dokumen Sah Berbasis Digital UU ITE No. 11/2008</span>
                </div>
            </footer>
        </article>
    </main>

    <!-- Interactive Client Script -->
    <script>
        let currentZoom = 100;
        function changeZoom(delta) {
            currentZoom = Math.min(150, Math.max(70, currentZoom + delta));
            const docEl = document.getElementById('a4-document');
            const zoomText = document.getElementById('zoom-text');
            if (docEl && zoomText) {
                docEl.style.transform = `scale(${currentZoom / 100})`;
                zoomText.textContent = `${currentZoom}%`;
            }
        }
    </script>
</body>
</html>

