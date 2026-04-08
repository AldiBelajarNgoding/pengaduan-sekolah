<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspiration::where('user_id', Auth::id())
                    ->with(['feedbacks.admin', 'category'])
                    ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirasi = $query->paginate(10)->withQueryString();
        return view('siswa.aspirasi.index', compact('aspirasi'));
    }

    public function create()
    {
        $kategoris = Category::all();
        return view('siswa.aspirasi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'lokasi'      => 'required|in:ruang_kelas,toilet,kantin,perpustakaan,laboratorium,lapangan,mushola,parkiran,koridor,lainnya',
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('aspirasi', 'public');
        }

        Aspiration::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'lokasi'      => $request->lokasi,
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'photo'       => $photoPath,
            'status'      => 'menunggu',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Pengaduan berhasil dikirim!');
    }
}
