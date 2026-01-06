<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';

    protected $queryString = ['search', 'filterCategory'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            Product::findOrFail($id)->delete();
            session()->flash('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('kategori', $this->filterCategory);
            })
            ->orderBy('nama')
            ->paginate(10);

        $categories = Product::distinct()->pluck('kategori');

        return view('livewire.product-list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}