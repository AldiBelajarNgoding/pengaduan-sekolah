<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Aspiration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display dashboard admin
     */
    public function dashboard()
    {
        // Hitung statistik
        $totalAspirasi = Aspiration::count();
        $perluReview = Aspiration::where('status', 'menunggu')->count();
        $diproses = Aspiration::where('status', 'proses')->count();
        $selesai = Aspiration::where('status', 'selesai')->count();

        // Ambil 5 aspirasi terbaru
        $recentAspirasi = Aspiration::with(['pelapor', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard-admin', compact(
            'totalAspirasi',
            'perluReview',
            'diproses',
            'selesai',
            'recentAspirasi'
        ));
    }
}
