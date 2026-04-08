<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAspirasi = Aspiration::count();
        $perluReview   = Aspiration::where('status', 'menunggu')->count();
        $diproses      = Aspiration::where('status', 'proses')->count();
        $selesai       = Aspiration::where('status', 'selesai')->count();

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
