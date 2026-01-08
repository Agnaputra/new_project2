<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

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

    // Validation messages untuk bahasa Indonesia
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

    public function rules()
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

    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->productId = $id;
            
            $product = Product::find($id);
            
            if (!$product) {
                session()->flash('error', '❌ Produk tidak ditemukan!');
                return redirect()->route('products.index');
            }
            
            $this->nama = $product->nama;
            $this->kategori = $product->kategori;
            $this->harga_beli = (float) $product->harga_beli;
            $this->margin = (float) $product->margin;
            $this->harga_jual = (float) $product->harga_jual;
            $this->stok = (int) $product->stok;
            $this->stok_minimum = (int) $product->stok_minimum;
            $this->sku = $product->sku ?? '';
            $this->deskripsi = $product->deskripsi ?? '';
        } else {
            $this->calculateHargaJual();
        }
    }

    public function updatedHargaBeli($value)
    {
        $this->calculateHargaJual();
    }

    public function updatedMargin($value)
    {
        $this->calculateHargaJual();
    }

    public function calculateHargaJual()
    {
        $hargaBeli = (float) $this->harga_beli;
        $margin = (float) $this->margin;
        
        if ($hargaBeli > 0) {
            $this->harga_jual = $hargaBeli * (1 + ($margin / 100));
        } else {
            $this->harga_jual = 0;
        }
    }

    public function save()
    {
        // Log untuk debugging
        \Log::info('Save method called', [
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'isEdit' => $this->isEdit,
        ]);

        // Calculate ulang sebelum validate
        $this->calculateHargaJual();

        // Validate
        try {
            $validated = $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            
            // Set flash message untuk error validasi
            $errorMessages = collect($e->errors())->flatten()->implode(', ');
            session()->flash('error', '❌ Validasi gagal: ' . $errorMessages);
            return;
        }

        $data = [
            'nama' => trim($this->nama),
            'kategori' => $this->kategori,
            'harga_beli' => (float) $this->harga_beli,
            'margin' => (float) $this->margin,
            'harga_jual' => (float) $this->harga_jual,
            'stok' => (int) $this->stok,
            'stok_minimum' => (int) $this->stok_minimum,
            'sku' => $this->sku ? trim($this->sku) : null,
            'deskripsi' => $this->deskripsi ? trim($this->deskripsi) : null,
        ];

        try {
            if ($this->isEdit && $this->productId) {
                $product = Product::findOrFail($this->productId);
                $product->update($data);
                
                \Log::info('Product updated successfully', ['id' => $this->productId]);
                
                session()->flash('success', '✅ Produk "' . $this->nama . '" berhasil diupdate!');
            } else {
                $product = Product::create($data);
                
                \Log::info('Product created successfully', ['id' => $product->id]);
                
                session()->flash('success', '✅ Produk "' . $this->nama . '" berhasil ditambahkan!');
            }

            // PENTING: Gunakan redirect dengan return
            return $this->redirect(route('products.index'), navigate: true);
            
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error', ['message' => $e->getMessage()]);
            
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                session()->flash('error', '❌ SKU sudah digunakan produk lain!');
            } else {
                session()->flash('error', '❌ Database Error: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('General error', ['message' => $e->getMessage()]);
            session()->flash('error', '❌ Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}