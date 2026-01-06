<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SalesTransaction extends Component
{
    public $search = '';
    public $selectedProduct = null;
    public $quantity = 1;
    public $cart = [];
    public $customerName = '';
    public $notes = '';

    protected $rules = [
        'quantity' => 'required|integer|min:1',
        'customerName' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ];

    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->quantity = 1;
        $this->search = '';
    }

    public function addToCart()
    {
        $this->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (!$this->selectedProduct) {
            session()->flash('error', 'Pilih produk terlebih dahulu!');
            return;
        }

        // Validasi stok
        if ($this->selectedProduct->stok < $this->quantity) {
            session()->flash('error', 'Stok tidak mencukupi! Stok tersedia: ' . $this->selectedProduct->stok);
            return;
        }

        // Cek apakah produk sudah ada di cart
        $existingIndex = collect($this->cart)->search(function ($item) {
            return $item['product_id'] == $this->selectedProduct->id;
        });

        if ($existingIndex !== false) {
            // Update quantity jika sudah ada
            $newQty = $this->cart[$existingIndex]['quantity'] + $this->quantity;
            
            if ($newQty > $this->selectedProduct->stok) {
                session()->flash('error', 'Total quantity melebihi stok!');
                return;
            }

            $this->cart[$existingIndex]['quantity'] = $newQty;
            $this->cart[$existingIndex]['subtotal'] = $newQty * $this->selectedProduct->harga_jual;
            $this->cart[$existingIndex]['total_profit'] = $newQty * $this->selectedProduct->profit_per_unit;
        } else {
            // Tambah item baru
            $this->cart[] = [
                'product_id' => $this->selectedProduct->id,
                'nama' => $this->selectedProduct->nama,
                'harga_satuan' => $this->selectedProduct->harga_jual,
                'profit_per_item' => $this->selectedProduct->profit_per_unit,
                'quantity' => $this->quantity,
                'subtotal' => $this->quantity * $this->selectedProduct->harga_jual,
                'total_profit' => $this->quantity * $this->selectedProduct->profit_per_unit,
            ];
        }

        // Reset selection
        $this->selectedProduct = null;
        $this->quantity = 1;
        session()->flash('success', 'Produk ditambahkan ke keranjang!');
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // Re-index array
    }

    public function updateCartQuantity($index, $newQuantity)
    {
        if ($newQuantity < 1) {
            $this->removeFromCart($index);
            return;
        }

        $product = Product::find($this->cart[$index]['product_id']);
        
        if ($newQuantity > $product->stok) {
            session()->flash('error', 'Quantity melebihi stok tersedia!');
            return;
        }

        $this->cart[$index]['quantity'] = $newQuantity;
        $this->cart[$index]['subtotal'] = $newQuantity * $this->cart[$index]['harga_satuan'];
        $this->cart[$index]['total_profit'] = $newQuantity * $this->cart[$index]['profit_per_item'];
    }

    public function completeSale()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang masih kosong!');
            return;
        }

        DB::beginTransaction();

        try {
            // Buat transaksi Sale
            $sale = Sale::create([
                'total_harga' => collect($this->cart)->sum('subtotal'),
                'total_profit' => collect($this->cart)->sum('total_profit'),
                'customer_name' => $this->customerName,
                'notes' => $this->notes,
            ]);

            // Simpan detail dan kurangi stok
            foreach ($this->cart as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                    'profit_per_item' => $item['profit_per_item'],
                    'total_profit' => $item['total_profit'],
                ]);

                // Kurangi stok produk
                $product = Product::find($item['product_id']);
                $product->decrement('stok', $item['quantity']);
            }

            DB::commit();

            // Reset form
            $this->cart = [];
            $this->customerName = '';
            $this->notes = '';

            session()->flash('success', 'Transaksi berhasil! Invoice: ' . $sale->invoice_number);
            
            return redirect()->route('sales.show', $sale->id);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->where('stok', '>', 0)
            ->orderBy('nama')
            ->limit(10)
            ->get();

        $totalHarga = collect($this->cart)->sum('subtotal');
        $totalProfit = collect($this->cart)->sum('total_profit');

        return view('livewire.sales-transaction', [
            'products' => $products,
            'totalHarga' => $totalHarga,
            'totalProfit' => $totalProfit,
        ]);
    }
}