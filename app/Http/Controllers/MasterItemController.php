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

    // Menyimpan Master Item baru
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'laba' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'jenis' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
        }

        MasterItem::create($data);

        return redirect()->route('master-items.index')->with('success', 'Master Item berhasil ditambahkan');
    }

    // Memperbarui Master Item
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'image' => 'nullable',
            'harga_beli' => 'required|numeric',
            'laba' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'jenis' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
        }

        $item = MasterItem::findOrFail($id);
        $item->update($request->all());
        $item->update([
            'image' => $data['image']
        ]);

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
