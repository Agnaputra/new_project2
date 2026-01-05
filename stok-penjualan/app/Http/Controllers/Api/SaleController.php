<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::orderBy('created_at', 'desc')->get();
        return response()->json($sales);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'sell_price' => 'required|numeric|min:0'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $sale = Sale::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $validated['quantity'],
            'sell_price' => $validated['sell_price'],
            'buy_price' => $product->buy_price,
            'total_sell' => $validated['quantity'] * $validated['sell_price'],
            'total_buy' => $validated['quantity'] * $product->buy_price,
            'profit' => ($validated['sell_price'] - $product->buy_price) * $validated['quantity']
        ]);

        $product->decrement('stock', $validated['quantity']);

        return response()->json($sale, 201);
    }

    public function show(Sale $sale)
    {
        return response()->json($sale);
    }
}