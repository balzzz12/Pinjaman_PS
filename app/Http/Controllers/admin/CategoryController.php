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

        // ✅ FIX PATH
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        // ✅ FIX PATH
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        // ✅ OPTIONAL (biar konsisten admin)
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}