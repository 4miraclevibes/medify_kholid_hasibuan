<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $items = Category::all();  // Menampilkan semua kategori
        return view('pages.backend.categories.index', compact('items'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255|unique:categories,code',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Mengupdate kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255|unique:categories,code,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
