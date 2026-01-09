<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ProductList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $filterKategori = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'filterKategori' => ['except' => ''],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFilterKategori()
    {
        $this->resetPage();
    }
    
    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $productName = $product->nama;
            $product->delete();
            
            session()->flash('success', '✅ Produk "' . $productName . '" berhasil dihapus!');
            
            \Log::info('Product deleted', ['id' => $id, 'name' => $productName]);
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menghapus produk: ' . $e->getMessage());
            \Log::error('Delete product failed', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }
    
    #[Title('Daftar Produk')]
    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterKategori, function ($query) {
                $query->where('kategori', $this->filterKategori);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $kategoris = Product::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');
        
        return view('livewire.product-list', [
            'products' => $products,
            'kategoris' => $kategoris,
        ]);
    }
}