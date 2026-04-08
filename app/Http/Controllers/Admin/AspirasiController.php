<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspiration::with(['pelapor', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pelapor', function ($qq) use ($request) {
                      $qq->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('nisn', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $aspirasis  = $query->latest()->paginate(10)->withQueryString();
        $kategoris  = Category::all();

        return view('admin.aspirasi.index', compact('aspirasis', 'kategoris'));
    }

    public function show($id)
    {
        $aspirasi = Aspiration::with(['pelapor', 'category', 'feedbacks.admin'])->findOrFail($id);
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    public function update(Request $request, $id)
    {
        $aspirasi = Aspiration::findOrFail($id);

        $request->validate([
            'status'   => 'required|in:menunggu,proses,selesai',
            'feedback' => 'nullable|string',
        ]);

        $aspirasi->update(['status' => $request->status]);

        if ($request->filled('feedback')) {
            Feedback::create([
                'aspiration_id' => $aspirasi->id,
                'admin_id'      => Auth::id(),
                'message'       => $request->feedback,
            ]);
        }

        return redirect()->route('admin.aspirasi.show', $aspirasi->id)
                         ->with('success', 'Aspirasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $aspirasi = Aspiration::findOrFail($id);

        if ($aspirasi->photo) {
            Storage::disk('public')->delete($aspirasi->photo);
        }

        $aspirasi->delete();

        return redirect()->route('admin.aspirasi.index')
                         ->with('success', 'Aspirasi berhasil dihapus');
    }
}
