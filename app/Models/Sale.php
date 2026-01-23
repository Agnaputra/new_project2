<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'total',
        'profit',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}