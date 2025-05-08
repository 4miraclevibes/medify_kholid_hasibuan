<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            'Tokopaedi',
            'Bukulapuk',
            'TokoBagas',
            'E Commurz',
            'Blublu',
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create([
                'name' => $supplier,
                'email' => $supplier . '@gmail.com',
                'phone' => '081234567890',
                'address' => 'Jl. ' . $supplier . ' No. 1, Jakarta',
            ]);
        }
    }
}
