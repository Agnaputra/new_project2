<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;

class ProductForm extends Component
{
    public $productId = null;
    public $nama = '';
    public $kategori = '';
    public $harga_beli = 0;
    public $margin = 30;
    public $harga_jual = 0;
    public $stok = 0;
    public $stok_minimum = 5;
    public $sku = '';
    public $deskripsi = '';
    public $isEdit = false;

    protected function rules()
    {
        $skuRule = $this->isEdit && $this->productId 
            ? 'nullable|string|max:100|unique:products,sku,' . $this->productId
            : 'nullable|string|max:100|unique:products,sku';

        return [
            'nama' => 'required|min:3|max:255',
            'kategori' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0|max:1000',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'sku' => $skuRule,
            'deskripsi' => 'nullable|string',
        ];
    }

    protected $messages = [
        'nama.required' => 'Nama produk harus diisi',
        'nama.min' => 'Nama produk minimal 3 karakter',
        'kategori.required' => 'Kategori harus dipilih',
        'harga_beli.required' => 'Harga beli harus diisi',
        'harga_beli.numeric' => 'Harga beli harus berupa angka',
        'harga_beli.min' => 'Harga beli tidak boleh negatif',
        'margin.required' => 'Margin harus diisi',
        'margin.numeric' => 'Margin harus berupa angka',
        'stok.required' => 'Stok harus diisi',
        'stok.integer' => 'Stok harus berupa angka bulat',
        'stok_minimum.required' => 'Stok minimum harus diisi',
        'sku.unique' => 'SKU sudah digunakan produk lain',
    ];

    public function mount($id = null)
    {
        \Log::info('=== PRODUCT FORM MOUNTED ===', ['id' => $id]);
        
        if ($id) {
            $this->isEdit = true;
            $this->productId = $id;
            
            $product = Product::find($id);
            
            if (!$product) {
                session()->flash('error', '❌ Produk tidak ditemukan!');
                return redirect()->route('products.index');
            }
            
            // Langsung isi semua field tanpa reactive loading
            $this->nama = $product->nama;
            $this->kategori = $product->kategori;
            $this->harga_beli = (float) $product->harga_beli;
            $this->margin = (float) $product->margin;
            $this->harga_jual = (float) $product->harga_jual;
            $this->stok = (int) $product->stok;
            $this->stok_minimum = (int) $product->stok_minimum;
            $this->sku = $product->sku ?? '';
            $this->deskripsi = $product->deskripsi ?? '';
            
            \Log::info('Product loaded for edit', ['product' => $product->toArray()]);
        } else {
            // Set default values untuk produk baru
            $this->margin = 30;
            $this->stok = 0;
            $this->stok_minimum = 5;
        }
        
        $this->calculateHargaJual();
    }

    public function updatedHargaBeli()
    {
        $this->calculateHargaJual();
    }

    public function updatedMargin()
    {
        $this->calculateHargaJual();
    }

    public function calculateHargaJual()
    {
        $hargaBeli = (float) $this->harga_beli;
        $margin = (float) $this->margin;
        
        if ($hargaBeli > 0 && $margin >= 0) {
            $this->harga_jual = $hargaBeli * (1 + ($margin / 100));
        } else {
            $this->harga_jual = 0;
        }
    }

    public function save()
    {
        \Log::info('=== SAVE METHOD CALLED ===');
        \Log::info('Form data:', [
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'harga_beli' => $this->harga_beli,
            'margin' => $this->margin,
            'stok' => $this->stok,
            'isEdit' => $this->isEdit,
            'productId' => $this->productId,
        ]);

        // Validate
        $this->validate();

        // Prepare data
        $data = [
            'nama' => trim($this->nama),
            'kategori' => $this->kategori,
            'harga_beli' => (float) $this->harga_beli,
            'margin' => (float) $this->margin,
            'stok' => (int) $this->stok,
            'stok_minimum' => (int) $this->stok_minimum,
            'sku' => $this->sku ? trim($this->sku) : null,
            'deskripsi' => $this->deskripsi ? trim($this->deskripsi) : null,
        ];

        \Log::info('Data to save:', $data);

        try {
            if ($this->isEdit && $this->productId) {
                // UPDATE
                $product = Product::findOrFail($this->productId);
                $product->update($data);
                
                \Log::info('Product updated', [
                    'id' => $product->id,
                    'harga_jual' => $product->harga_jual,
                ]);
                
                session()->flash('success', '✅ Produk "' . $this->nama . '" berhasil diupdate!');
            } else {
                // CREATE
                $product = Product::create($data);
                
                \Log::info('Product created', [
                    'id' => $product->id,
                    'harga_jual' => $product->harga_jual,
                ]);
                
                session()->flash('success', '✅ Produk "' . $this->nama . '" berhasil ditambahkan!');
            }

            \Log::info('Redirecting to products.index');
            
            // PENTING: Gunakan redirect() tanpa wire:navigate untuk force refresh
            return redirect()->route('products.index');
            
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                session()->flash('error', '❌ SKU sudah digunakan produk lain!');
            } else {
                session()->flash('error', '❌ Error database: ' . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            \Log::error('Unexpected error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            session()->flash('error', '❌ Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product-form')
            ->layout('layouts.app', ['title' => $this->isEdit ? 'Edit Produk' : 'Tambah Produk']);
    }
}