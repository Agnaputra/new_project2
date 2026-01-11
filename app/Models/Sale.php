<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'total_harga',
        'total_profit',
        'customer_name',
        'notes',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'total_profit' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            // Generate invoice number otomatis
            $sale->invoice_number = 'INV-' . date('Ymd') . '-' . str_pad(Sale::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Calculate totals dari details
     */
    public function calculateTotals()
    {
        $this->total_harga = $this->details->sum('subtotal');
        $this->total_profit = $this->details->sum('total_profit');
        $this->save();
    }
}