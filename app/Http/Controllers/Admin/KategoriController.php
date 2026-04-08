<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Category::withCount('aspirations')->latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $kategori)
    {
        return response()->json($kategori);
    }

    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $kategori->id,
        ]);

        $kategori->update(['name' => $request->name]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $kategori)
    {
        if ($kategori->aspirations()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Kategori tidak bisa dihapus karena masih ada aspirasi yang menggunakan kategori ini');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus');
    }
}
