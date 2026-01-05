<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'buy_price' => 'required|numeric|min:0',
            'profit_margin' => 'required|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0'
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'category' => 'string|max:255',
            'buy_price' => 'numeric|min:0',
            'profit_margin' => 'numeric|min:0|max:100',
            'stock' => 'integer|min:0',
            'min_stock' => 'integer|min:0'
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function lowStock()
    {
        $products = Product::whereColumn('stock', '<=', 'min_stock')->get();
        return response()->json($products);
    }

    public function categories()
    {
        $categories = Product::distinct()->pluck('category');
        return response()->json($categories);
    }
}