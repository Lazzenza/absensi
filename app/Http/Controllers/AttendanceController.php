<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman daftar presensi dengan filter, sorting, pagination, dan summary.
     */
    public function index(Request $request)
    {
        // Validasi parameter filter (Requirement 5.6)
        $request->validate([
            'search'          => 'nullable|string|max:100',
            'user_id'         => 'nullable|exists:users,id',
            'date'            => 'nullable|date',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'month'           => 'nullable|integer|between:1,12',
            'year'            => 'nullable|integer|between:2000,2100',
            'status'          => 'nullable|in:Hadir,Terlambat,Izin,Sakit',
            'approval_status' => 'nullable|in:pending,approved,rejected',
            'sort_by'         => 'nullable|in:date,name,time_in,time_out,status',
            'sort_direction'  => 'nullable|in:asc,desc',
        ]);

        // Ringkasan (Summary) dihitung mengikuti hasil filter yang sedang aktif (Requirement 5.7)
        $summaryBase = $this->buildFilteredQuery($request, false);
        $summary = [
            'total'     => (clone $summaryBase)->count(),
            'hadir'     => (clone $summaryBase)->where('attendances.status', 'Hadir')->count(),
            'terlambat' => (clone $summaryBase)->where('attendances.status', 'Terlambat')->count(),
            'izin'      => (clone $summaryBase)->where('attendances.status', 'Izin')->count(),
            'sakit'     => (clone $summaryBase)->where('attendances.status', 'Sakit')->count(),
        ];

        // Data presensi dengan Pagination & Query String terbawa (Requirement 5.5)
        $attendances = $this->buildFilteredQuery($request, true)
            ->paginate(10)
            ->withQueryString();

        $users = User::orderBy('name')->get();

        return view('attendances.index', compact('attendances', 'users', 'summary'));
    }

    /**
     * Menampilkan halaman presensi harian (Check-in, Check-out, dan Form Presensi Khusus).
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        $users = User::orderBy('name')->get();

        return view('attendances.create', compact('todayAttendance', 'users'));
    }

    /**
     * Menyimpan presensi baru atau update check-out (Requirement 5.2).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type'    => 'required|in:check_in,check_out,izin,sakit',
            'notes'   => 'nullable|string|max:255',
        ]);

        $userId = $request->user_id;
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $attendance = Attendance::where('user_id', $userId)
            ->where('date', $today)
            ->first();

        switch ($request->type) {
            case 'check_in':
                if ($attendance) {
                    return back()->with('error', 'Gagal: User sudah memiliki catatan presensi untuk hari ini.');
                }

                // Penentuan status Hadir / Terlambat (Batas waktu 08:00)
                $status = Carbon::now()->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir';

                Attendance::create([
                    'user_id'         => $userId,
                    'date'            => $today,
                    'time_in'         => $currentTime,
                    'time_out'        => null,
                    'status'          => $status,
                    'approval_status' => 'approved',
                    'notes'           => $request->notes ?? ($status === 'Terlambat' ? 'Terlambat masuk presensi' : 'Tepat waktu'),
                ]);

                return back()->with('success', 'Berhasil melakukan Check-in (Status: ' . $status . ').');

            case 'check_out':
                if (!$attendance) {
                    return back()->with('error', 'Gagal Check-out! User belum melakukan Check-in hari ini.');
                }

                if ($attendance->time_out) {
                    return back()->with('error', 'Gagal: User sudah melakukan Check-out sebelumnya hari ini.');
                }

                if (in_array($attendance->status, ['Izin', 'Sakit'])) {
                    return back()->with('error', 'Gagal: Status ' . $attendance->status . ' tidak memerlukan Check-out.');
                }

                $attendance->update([
                    'time_out' => $currentTime,
                    'notes'    => $request->notes ?? $attendance->notes ?? 'Presensi pulang tercatat',
                ]);

                return back()->with('success', 'Berhasil melakukan Check-out.');

            case 'izin':
            case 'sakit':
                if ($attendance) {
                    return back()->with('error', 'Gagal: User sudah memiliki catatan presensi hari ini.');
                }

                $statusName = ucfirst($request->type);
                Attendance::create([
                    'user_id'         => $userId,
                    'date'            => $today,
                    'time_in'         => null,
                    'time_out'        => null,
                    'status'          => $statusName,
                    'approval_status' => 'pending',
                    'notes'           => $request->notes ?? ($statusName === 'Izin' ? 'Izin keperluan akademik / kedinasan' : 'Dispensasi sakit terlampir'),
                ]);

                return back()->with('success', 'Pengajuan ' . $statusName . ' berhasil dikirim dan sedang menunggu persetujuan administrator.');

            default:
                return back()->with('error', 'Tipe presensi tidak valid.');
        }
    }

    /**
     * Menyetujui pengajuan izin / sakit oleh Administrator.
     */
    public function approve(Attendance $attendance)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang memiliki wewenang untuk menyetujui presensi.');
        }

        $attendance->update([
            'approval_status' => 'approved',
            'approved_by'     => auth()->id(),
            'approval_note'   => null,
        ]);

        return back()->with('success', "Pengajuan {$attendance->status} untuk {$attendance->user->name} berhasil disetujui.");
    }

    /**
     * Menolak pengajuan izin / sakit oleh Administrator.
     */
    public function reject(Request $request, Attendance $attendance)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang memiliki wewenang untuk menolak presensi.');
        }

        $request->validate([
            'approval_note' => 'nullable|string|max:255',
            'notes'         => 'nullable|string|max:255',
        ]);

        $note = $request->approval_note ?? $request->notes ?? 'Pengajuan ditolak oleh administrator.';

        $attendance->update([
            'approval_status' => 'rejected',
            'approved_by'     => auth()->id(),
            'approval_note'   => $note,
        ]);

        return back()->with('success', "Pengajuan {$attendance->status} untuk {$attendance->user->name} telah ditolak.");
    }

    /**
     * Export laporan presensi ke PDF sesuai filter aktif (Requirement 5.8).
     * Khusus Administrator (Requirement Penyetujuan & Akses PDF).
     */
    public function downloadReport(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengunduh laporan PDF presensi.');
        }

        $attendances = $this->buildFilteredQuery($request, true)->get();

        $summary = [
            'total'     => $attendances->count(),
            'hadir'     => $attendances->where('status', 'Hadir')->count(),
            'terlambat' => $attendances->where('status', 'Terlambat')->count(),
            'izin'      => $attendances->where('status', 'Izin')->count(),
            'sakit'     => $attendances->where('status', 'Sakit')->count(),
        ];

        $appliedFilters = $this->extractAppliedFilters($request);

        $pdf = Pdf::loadView('pdf.attendance_report', compact('attendances', 'summary', 'appliedFilters'))
            ->setPaper('A4', 'landscape');

        $filename = 'laporan-presensi-' . Carbon::now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export laporan presensi ke format CSV sesuai filter aktif (Requirement Bonus 6).
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $attendances = $this->buildFilteredQuery($request, true)->get();
        $filename = 'laporan-presensi-' . Carbon::now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');

            // BOM untuk kompatibilitas Microsoft Excel (UTF-8)
            fputs($file, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($file, [
                'No',
                'ID Presensi',
                'Nama User',
                'Email User',
                'Tanggal',
                'Jam Masuk (Check-in)',
                'Jam Keluar (Check-out)',
                'Status Presensi',
            ]);

            foreach ($attendances as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->id,
                    $item->user?->name ?? 'User #' . $item->user_id,
                    $item->user?->email ?? '-',
                    $item->date,
                    $item->time_in ?? '-',
                    $item->time_out ?? '-',
                    $item->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper query builder untuk reusable filter dan sorting logic.
     */
    protected function buildFilteredQuery(Request $request, bool $withOrder = true)
    {
        $query = Attendance::with('user');

        // 1. Pencarian berdasarkan nama user (Requirement 5.4)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // 2. Filter berdasarkan user_id spesifik
        if ($request->filled('user_id')) {
            $query->where('attendances.user_id', $request->user_id);
        }

        // 3. Filter berdasarkan tanggal tertentu
        if ($request->filled('date')) {
            $query->whereDate('attendances.date', $request->date);
        }

        // 4. Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('attendances.date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('attendances.date', '<=', $request->end_date);
        }

        // 5. Filter berdasarkan bulan dan tahun
        if ($request->filled('month')) {
            $query->whereMonth('attendances.date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('attendances.date', $request->year);
        }

        // 6. Filter berdasarkan status presensi
        if ($request->filled('status') && in_array($request->status, ['Hadir', 'Terlambat', 'Izin', 'Sakit'])) {
            $query->where('attendances.status', $request->status);
        }

        // 7. Filter berdasarkan status persetujuan (Pending / Approved / Rejected)
        if ($request->filled('approval_status') && in_array($request->approval_status, ['pending', 'approved', 'rejected'])) {
            $query->where('attendances.approval_status', $request->approval_status);
        }

        // 7. Dynamic Sorting (Requirement 5.4)
        if ($withOrder) {
            $sortBy = $request->input('sort_by', 'date');
            $sortDirection = strtolower($request->input('sort_direction', 'desc')) === 'asc' ? 'asc' : 'desc';

            if ($sortBy === 'name') {
                $query->join('users', 'attendances.user_id', '=', 'users.id')
                    ->select('attendances.*')
                    ->orderBy('users.name', $sortDirection)
                    ->orderBy('attendances.date', 'desc');
            } elseif (in_array($sortBy, ['date', 'time_in', 'time_out', 'status'])) {
                $query->orderBy('attendances.' . $sortBy, $sortDirection)
                    ->orderBy('attendances.id', 'desc');
            } else {
                $query->orderBy('attendances.date', 'desc')
                    ->orderBy('attendances.id', 'desc');
            }
        }

        return $query;
    }

    /**
     * Ekstrak teks deskriptif filter yang sedang aktif untuk laporan PDF.
     */
    protected function extractAppliedFilters(Request $request): array
    {
        $filters = [];

        if ($request->filled('search')) {
            $filters['Pencarian Nama'] = $request->search;
        }

        if ($request->filled('user_id')) {
            $user = User::find($request->user_id);
            $filters['User'] = $user?->name ?? 'User #' . $request->user_id;
        }

        if ($request->filled('date')) {
            $filters['Tanggal Spesifik'] = Carbon::parse($request->date)->format('d-m-Y');
        }

        if ($request->filled('start_date') || $request->filled('end_date')) {
            $start = $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d-m-Y') : 'Awal';
            $end = $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d-m-Y') : 'Sekarang';
            $filters['Rentang Periode'] = "{$start} s/d {$end}";
        }

        if ($request->filled('month')) {
            $bulanNames = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $monthNum = (int)$request->month;
            $filters['Bulan'] = $bulanNames[$monthNum] ?? $monthNum;
        }

        if ($request->filled('year')) {
            $filters['Tahun'] = $request->year;
        }

        if ($request->filled('status')) {
            $filters['Status Presensi'] = $request->status;
        }

        return $filters;
    }
}
