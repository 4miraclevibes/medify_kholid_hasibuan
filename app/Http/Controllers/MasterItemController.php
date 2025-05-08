<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MasterItemController extends Controller
{
    // Menampilkan daftar Master Items
    public function index(Request $request)
    {
        $query = MasterItem::query();

    // Menambahkan filter harga min dan max jika ada
    if ($request->filled('min_price')) {
        $query->where('harga_beli', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('harga_beli', '<=', $request->max_price);
    }

    // Mengambil data yang sudah difilter
    $items = $query->with('category', 'supplier')->get();
    $categories = Category::all();
    $suppliers = Supplier::all();

        return view('pages.backend.master_item.index', compact('items', 'categories', 'suppliers'));
    }

    // Menampilkan form untuk membuat Master Item baru
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('master_item.create', compact('categories', 'suppliers'));
    }

    // Menyimpan Master Item baru
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'laba' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'jenis' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        MasterItem::create($request->all());

        return redirect()->route('master-items.index')->with('success', 'Master Item berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit Master Item
    public function edit($id)
    {
        $item = MasterItem::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('master_item.edit', compact('item', 'categories', 'suppliers'));
    }

    // Memperbarui Master Item
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'laba' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'jenis' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $item = MasterItem::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('master-items.index')->with('success', 'Master Item berhasil diperbarui');
    }

    // Menampilkan detail Master Item
    public function show($id)
    {
        $item = MasterItem::with('category', 'supplier')->findOrFail($id);

        return view('master_item.show', compact('item'));
    }

    // Menghapus Master Item
    public function destroy($id)
    {
        $item = MasterItem::findOrFail($id);
        $item->delete();

        return redirect()->route('master-items.index')->with('success', 'Master Item berhasil dihapus');
    }
}
