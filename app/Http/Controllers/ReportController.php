<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $records = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $summary = [
            'hadir' => $records->where('status', 'Hadir')->count(),
            'terlambat' => $records->where('status', 'Terlambat')->count(),
            'izin' => $records->where('status', 'Izin')->count(),
            'sakit' => $records->where('status', 'Sakit')->count(),
            'total' => $records->count(),
        ];

        return view('reports.index', compact('records', 'summary', 'startDate', 'endDate'));
    }

    public function previewPdf(Request $request)
    {
        $startDate = $request->input('start_date', '2026-07-13');
        $endDate = $request->input('end_date', '2026-10-24');

        $query = Attendance::with('user');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $summary = [
            'total'     => $attendances->count(),
            'hadir'     => $attendances->where('status', 'Hadir')->count(),
            'terlambat' => $attendances->where('status', 'Terlambat')->count(),
            'izin'      => $attendances->where('status', 'Izin')->count(),
            'sakit'     => $attendances->where('status', 'Sakit')->count(),
        ];

        return view('reports.preview', compact('attendances', 'summary', 'startDate', 'endDate'));
    }

    public function userDetail(User $user, Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $records = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $summary = [
            'hadir' => $records->where('status', 'Hadir')->count(),
            'terlambat' => $records->where('status', 'Terlambat')->count(),
            'izin' => $records->where('status', 'Izin')->count(),
            'sakit' => $records->where('status', 'Sakit')->count(),
            'total' => $records->count(),
        ];

        return view('reports.user', compact('user', 'records', 'summary', 'startDate', 'endDate'));
    }
}
