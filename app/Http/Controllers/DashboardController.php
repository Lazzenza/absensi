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

        return view('dashboard.index', compact(
            'totalUsers',
            'totalPresensi',
            'hadir',
            'terlambat',
            'izin',
            'sakit',
            'todayRecords'
        ));
    }
}
