<?php

use Illuminate\Support\Facades\Route;

// Mengarahkan semua permintaan rute ke app.blade.php agar diproses React Router
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');