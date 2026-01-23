<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductImportController;
use App\Livewire\Dashboard;
use App\Livewire\ProductForm;
use App\Livewire\ProductList;
use App\Livewire\SalesTransaction;
use App\Livewire\SalesReport;
use App\Livewire\ProfitReport;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Products Routes
    Route::get('/products', ProductList::class)->name('products.index');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');
    
    // Import Products
    Route::get('/products/import', [ProductImportController::class, 'showForm'])->name('products.import');
    Route::post('/products/import', [ProductImportController::class, 'import'])->name('products.import.store');
    
    // Sales Transaction
    Route::get('/sales/transaction', SalesTransaction::class)->name('sales.transaction');
    Route::get('/sales/{id}', SalesTransaction::class)->name('sales.show'); // Route yang missing
    
    // Reports Routes
    Route::get('/reports/sales', SalesReport::class)->name('reports.sales');
    Route::get('/reports/profit', ProfitReport::class)->name('reports.profit');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Export Routes
Route::get('/reports/sales/export', [ReportController::class, 'exportSales'])->name('reports.sales.export');
Route::get('/reports/profit/export', [ReportController::class, 'exportProfit'])->name('reports.profit.export');

// Logout Route
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

});

require __DIR__.'/auth.php';