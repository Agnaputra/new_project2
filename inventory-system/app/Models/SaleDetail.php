<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'profit_per_item',
        'total_profit',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'profit_per_item' => 'decimal:2',
        'total_profit' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            // Auto-calculate subtotal dan profit
            $detail->subtotal = $detail->jumlah * $detail->harga_satuan;
            $detail->total_profit = $detail->jumlah * $detail->profit_per_item;
        });
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}