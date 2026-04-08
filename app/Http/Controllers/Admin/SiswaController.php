<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa')->withCount('aspirations');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tingkat')) {
            $tingkat = $request->tingkat;
            $query->where(function($q) use ($tingkat) {
                $q->where('kelas', $tingkat)
                ->orWhere('kelas', 'like', $tingkat . ' %')
                ->orWhere('kelas', 'like', $tingkat . '-%')
                ->orWhere('kelas', 'regexp', '^' . $tingkat . '[^I]')
                ->orWhere('kelas', 'regexp', '^' . $tingkat . '$');
            });
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.siswa.index', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nisn'     => 'required|digits:10|unique:users,nisn',
            'kelas'    => 'required|string|max:50',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'nisn'     => $request->nisn,
            'kelas'    => $request->kelas,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(User $siswa)
    {
        return response()->json($siswa);
    }

    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nisn'     => 'required|digits:10|unique:users,nisn,' . $siswa->id,
            'kelas'    => 'required|string|max:50',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'  => $request->name,
            'nisn'  => $request->nisn,
            'kelas' => $request->kelas,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(User $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil dihapus');
    }
}
