<?php

use App\Livewire\Dashboard;
use App\Livewire\ProductForm;
use App\Livewire\ProductList;
use App\Livewire\SalesTransaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Products
    Route::get('/products', ProductList::class)->name('products.index');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');
    
    // Sales
    Route::get('/sales/transaction', SalesTransaction::class)->name('sales.transaction');

    Route::get('/products/import', [ProductImportController::class, 'showForm'])->name('products.import');
    Route::post('/products/import', [ProductImportController::class, 'import'])->name('products.import.store');
});

require __DIR__.'/auth.php';