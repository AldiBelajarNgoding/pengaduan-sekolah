<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $total    = Aspiration::count();
        $baru     = Aspiration::where('status', 'menunggu')->count();
        $diproses = Aspiration::where('status', 'proses')->count();
        $selesai  = Aspiration::where('status', 'selesai')->count();
        $recent   = Aspiration::with('pelapor')->latest()->take(5)->get();

        return view('admin.dashboard-admin', compact('total', 'baru', 'diproses', 'selesai', 'recent'));
    }

    public function siswa()
    {
        $user     = Auth::user();
        $aspirasi = Aspiration::where('user_id', $user->id)->latest()->get();

        return view('siswa.dashboard-siswa', [
            'aspirasi'      => $aspirasi,
            'totalAspirasi' => $aspirasi->count(),
            'menunggu'      => $aspirasi->where('status', 'menunggu')->count(),
            'diproses'      => $aspirasi->where('status', 'proses')->count(),
            'selesai'       => $aspirasi->where('status', 'selesai')->count(),
        ]);
    }
}
