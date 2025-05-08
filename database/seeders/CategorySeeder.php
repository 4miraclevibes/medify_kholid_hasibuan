<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MasterItem;
use App\Models\Supplier;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Obat',
                'code' => 'OBAT',
            ],
            [
                'name' => 'Alkes',
                'code' => 'ALKES',
            ],
            [
                'name' => 'Matkes',
                'code' => 'MATKES',
            ],
            [
                'name' => 'Umum',
                'code' => 'UMUM',
            ],
            [
                'name' => 'ATK',
                'code' => 'ATK',
            ],
        ];

        $supplier = Supplier::all();
        foreach ($categories as $category) {
            $ct = Category::create($category);
            MasterItem::create([
                'user_id' => 1,
                'category_id' => $ct->id,
                'supplier_id' => $supplier->random()->id,
                'kode' => $category['code'] . $ct->id,
                'nama' => $category['name'],
                'harga_beli' => 50000,
                'laba' => 5,
                'jenis' => 'Obat',
            ]);
        }
    }
}
