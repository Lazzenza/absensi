<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalUsers = User::count();
        $totalPresensi = Attendance::count();
        $hadir = Attendance::where('status', 'Hadir')->count();
        $terlambat = Attendance::where('status', 'Terlambat')->count();
        $izin = Attendance::where('status', 'Izin')->count();
        $sakit = Attendance::where('status', 'Sakit')->count();

        $todayRecords = Attendance::with('user')
            ->whereDate('date', $today)
            ->orderBy('id', 'desc')
            ->get();

        $latestAttendances = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $user = auth()->user();
        $todayAttendance = $user ? Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first() : null;

        // Daftar pengajuan izin & sakit yang menunggu persetujuan admin
        $pendingApprovals = Attendance::with('user')
            ->where('approval_status', 'pending')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Perhitungan hari kerja magang (13 Juli - 30 Des 2026: 119 hari)
        $totalWorkDays = 119;
        $workDaysPassed = 73;
        $workDaysRemaining = 46;

        return view('dashboard.index', compact(
            'totalUsers',
            'totalPresensi',
            'hadir',
            'terlambat',
            'izin',
            'sakit',
            'todayRecords',
            'latestAttendances',
            'todayAttendance',
            'pendingApprovals',
            'totalWorkDays',
            'workDaysPassed',
            'workDaysRemaining'
        ));
    }
}
