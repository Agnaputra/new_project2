<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Product([
            'nama' => $row['nama'],
            'kategori' => $row['kategori'],
            'harga_beli' => $row['harga_beli'],
            'margin' => $row['margin'],
            'stok' => $row['stok'] ?? 0,
            'stok_minimum' => $row['stok_minimum'] ?? 5,
            'sku' => $row['sku'] ?? null,
            'deskripsi' => $row['deskripsi'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'kategori' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
        ];
    }
}