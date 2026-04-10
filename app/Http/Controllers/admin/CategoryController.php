<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        // ✅ LOG TAMBAH
        logAktivitas('Tambah Kategori', 'Menambahkan kategori: ' . $category->name);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $oldName = $category->name;

        $category->update([
            'name' => $request->name
        ]);

        // ✅ LOG UPDATE
        logAktivitas(
            'Update Kategori',
            'Dari: ' . $oldName . ' → Menjadi: ' . $category->name
        );

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $nama = $category->name;

        $category->delete();

        // ✅ LOG DELETE
        logAktivitas('Hapus Kategori', 'Menghapus kategori: ' . $nama);

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}
