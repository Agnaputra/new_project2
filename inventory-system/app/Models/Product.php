<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'harga_beli',
        'margin',
        'harga_jual',
        'stok',
        'stok_minimum',
        'sku',
        'deskripsi',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'margin' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'stok_minimum' => 'integer',
    ];

    // Accessor untuk calculated attributes
    protected $appends = ['is_low_stock', 'profit_per_unit'];

    /**
     * Check apakah stok rendah
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }

    /**
     * Hitung profit per unit
     */
    public function getProfitPerUnitAttribute(): float
    {
        return (float) ($this->harga_jual - $this->harga_beli);
    }

    /**
     * Auto-calculate harga jual saat saving
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            // Auto-calculate harga_jual dari harga_beli dan margin
            if ($product->harga_beli && $product->margin !== null) {
                $product->harga_jual = $product->harga_beli * (1 + ($product->margin / 100));
            }
        });
    }

    /**
     * Relationships
     */
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Scopes untuk query optimization
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stok <= stok_minimum');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }
}