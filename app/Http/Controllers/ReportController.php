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
