<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'buy_price',
        'profit_margin',
        'stock',
        'min_stock'
    ];

    protected $casts = [
        'buy_price' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer'
    ];

    protected $appends = ['sell_price'];

    public function getSellPriceAttribute()
    {
        return $this->buy_price * (1 + $this->profit_margin / 100);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}