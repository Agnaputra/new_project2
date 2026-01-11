<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama' => 'Laptop ASUS ROG',
                'kategori' => 'Elektronik',
                'harga_beli' => 12000000,
                'margin' => 15,
                'stok' => 5,
                'stok_minimum' => 2,
                'sku' => 'LAP-001',
            ],
            [
                'nama' => 'Mouse Logitech G502',
                'kategori' => 'Elektronik',
                'harga_beli' => 500000,
                'margin' => 30,
                'stok' => 15,
                'stok_minimum' => 5,
                'sku' => 'MOU-001',
            ],
            [
                'nama' => 'Kemeja Batik Premium',
                'kategori' => 'Fashion',
                'harga_beli' => 250000,
                'margin' => 40,
                'stok' => 3,
                'stok_minimum' => 5,
                'sku' => 'BTK-001',
            ],
            [
                'nama' => 'Kopi Arabica 500g',
                'kategori' => 'Makanan',
                'harga_beli' => 85000,
                'margin' => 35,
                'stok' => 50,
                'stok_minimum' => 10,
                'sku' => 'KOP-001',
            ],
            [
                'nama' => 'Meja Kantor Minimalis',
                'kategori' => 'Furniture',
                'harga_beli' => 1500000,
                'margin' => 25,
                'stok' => 2,
                'stok_minimum' => 3,
                'sku' => 'FUR-001',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}