<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    public $productId = null;
    public $nama;
    public $kategori;
    public $harga_beli;
    public $margin = 30; // Default margin 30%
    public $harga_jual;
    public $stok = 0;
    public $stok_minimum = 5;
    public $sku;
    public $deskripsi;

    public $isEdit = false;

    protected $rules = [
        'nama' => 'required|min:3',
        'kategori' => 'required',
        'harga_beli' => 'required|numeric|min:0',
        'margin' => 'required|numeric|min:0|max:1000',
        'stok' => 'required|integer|min:0',
        'stok_minimum' => 'required|integer|min:0',
        'sku' => 'nullable|unique:products,sku',
        'deskripsi' => 'nullable',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->productId = $id;
            $product = Product::findOrFail($id);
            $this->fill($product->toArray());
        }
    }

    // Real-time calculation saat harga_beli atau margin berubah
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['harga_beli', 'margin'])) {
            $this->calculateHargaJual();
        }
    }

    public function calculateHargaJual()
    {
        if ($this->harga_beli && $this->margin) {
            $this->harga_jual = $this->harga_beli * (1 + ($this->margin / 100));
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'harga_beli' => $this->harga_beli,
            'margin' => $this->margin,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'stok_minimum' => $this->stok_minimum,
            'sku' => $this->sku,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->isEdit) {
            $product = Product::find($this->productId);
            $product->update($data);
            session()->flash('success', 'Produk berhasil diupdate!');
        } else {
            Product::create($data);
            session()->flash('success', 'Produk berhasil ditambahkan!');
        }

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}