<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_name',
        'quantity',
        'sell_price',
        'buy_price',
        'total_sell',
        'total_buy',
        'profit'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'sell_price' => 'decimal:2',
        'buy_price' => 'decimal:2',
        'total_sell' => 'decimal:2',
        'total_buy' => 'decimal:2',
        'profit' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}