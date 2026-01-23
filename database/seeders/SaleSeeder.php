<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $sales = [
            [
                'invoice_number' => 'INV-20260105-0001',
                'customer_name' => 'Budi Santoso',
                'total' => 13800000,
                'profit' => 1800000,
                'payment_method' => 'cash',
                'notes' => 'Pembelian laptop',
                'created_at' => Carbon::parse('2026-01-05 10:30:00'),
            ],
            [
                'invoice_number' => 'INV-20260108-0001',
                'customer_name' => 'Siti Nurhaliza',
                'total' => 780000,
                'profit' => 180000,
                'payment_method' => 'cash',
                'notes' => 'Pembelian mouse',
                'created_at' => Carbon::parse('2026-01-08 14:20:00'),
            ],
            [
                'invoice_number' => 'INV-20260110-0001',
                'customer_name' => 'Ahmad Dahlan',
                'total' => 1000000,
                'profit' => 200000,
                'payment_method' => 'cash',
                'notes' => 'Pembelian keyboard',
                'created_at' => Carbon::parse('2026-01-10 09:15:00'),
            ],
            [
                'invoice_number' => 'INV-20260115-0001',
                'customer_name' => 'Guest',
                'total' => 3000000,
                'profit' => 500000,
                'payment_method' => 'cash',
                'notes' => null,
                'created_at' => Carbon::parse('2026-01-15 16:45:00'),
            ],
            [
                'invoice_number' => 'INV-20260120-0001',
                'customer_name' => 'Dewi Sartika',
                'total' => 607500,
                'profit' => 157500,
                'payment_method' => 'cash',
                'notes' => 'Pembelian headset',
                'created_at' => Carbon::parse('2026-01-20 11:00:00'),
            ],
            [
                'invoice_number' => 'INV-20260121-0001',
                'customer_name' => 'Joko Widodo',
                'total' => 2500000,
                'profit' => 400000,
                'payment_method' => 'cash',
                'notes' => 'Pembelian berbagai item',
                'created_at' => Carbon::parse('2026-01-21 13:25:00'),
            ],
            [
                'invoice_number' => 'INV-20260122-0001',
                'customer_name' => 'Guest',
                'total' => 1850000,
                'profit' => 350000,
                'payment_method' => 'cash',
                'notes' => null,
                'created_at' => Carbon::parse('2026-01-22 15:50:00'),
            ],
            [
                'invoice_number' => 'INV-20260123-0001',
                'customer_name' => 'Mega Wati',
                'total' => 950000,
                'profit' => 190000,
                'payment_method' => 'cash',
                'notes' => 'Pembelian aksesoris komputer',
                'created_at' => Carbon::parse('2026-01-23 09:10:00'),
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create($sale);
        }
    }
}