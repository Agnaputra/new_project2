<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function showForm()
    {
        return view('products.import');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:5120' // Naikkan ke 5MB jika perlu
    ]);

    try {
        Excel::import(new ProductsImport, $request->file('file'));
        
        // Gunakan toast atau sweetalert (opsional) melalui session
        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil diimport!');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        return back()->with('import_errors', $failures);
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    }
}
}