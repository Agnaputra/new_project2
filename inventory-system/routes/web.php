<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductImportController;
use App\Livewire\Dashboard;
use App\Livewire\ProductForm;
use App\Livewire\ProductList;
use App\Livewire\SalesTransaction;
use App\Livewire\SalesReport; // Akan dibuat
use App\Livewire\ProfitReport; // Akan dibuat
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Products Management
    Route::get('/products', ProductList::class)->name('products.index');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');
    
    // Product Import (Excel/CSV)
    Route::get('/products/import', [ProductImportController::class, 'showForm'])->name('products.import');
    Route::post('/products/import', [ProductImportController::class, 'import'])->name('products.import.store');
    
    // Sales Transactions
    Route::get('/sales/transaction', SalesTransaction::class)->name('sales.transaction');

    // User Profile (Solusi untuk error Route [profile.edit] not defined)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Laporan
    Route::get('/reports/sales', SalesReport::class)->name('reports.sales');
    Route::get('/reports/profit', ProfitReport::class)->name('reports.profit');
});

require __DIR__.'/auth.php';