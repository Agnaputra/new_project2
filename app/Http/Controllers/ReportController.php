<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function exportSales(Request $request)
    {
        $start = $request->input('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->input('end', Carbon::now()->format('Y-m-d'));
        
        $sales = Sale::whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $filename = 'Laporan_Penjualan_' . $start . '_to_' . $end . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($sales) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['Invoice', 'Tanggal', 'Customer', 'Total Harga', 'Profit', 'Payment Method']);
            
            // Data
            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->invoice_number,
                    $sale->created_at->format('d/m/Y H:i'),
                    $sale->customer_name ?: 'Guest',
                    'Rp ' . number_format($sale->total, 0, ',', '.'),
                    'Rp ' . number_format($sale->profit, 0, ',', '.'),
                    $sale->payment_method,
                ]);
            }
            
            // Summary
            fputcsv($file, []);
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Penjualan', 'Rp ' . number_format($sales->sum('total'), 0, ',', '.')]);
            fputcsv($file, ['Total Profit', 'Rp ' . number_format($sales->sum('profit'), 0, ',', '.')]);
            fputcsv($file, ['Total Transaksi', $sales->count()]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportProfit(Request $request)
    {
        $start = $request->input('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->input('end', Carbon::now()->format('Y-m-d'));
        
        $sales = Sale::whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalProfit = $sales->sum('profit');
        $totalRevenue = $sales->sum('total');
        $totalCost = $totalRevenue - $totalProfit;
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;
        
        // Daily breakdown
        $dailyData = [];
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $daySales = Sale::whereDate('created_at', $date)->get();
            $dailyData[] = [
                'date' => $date->format('d/m/Y'),
                'revenue' => $daySales->sum('total'),
                'cost' => $daySales->sum('total') - $daySales->sum('profit'),
                'profit' => $daySales->sum('profit'),
            ];
        }
        
        $filename = 'Laporan_Profit_' . $start . '_to_' . $end . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($dailyData, $totalProfit, $totalRevenue, $totalCost, $profitMargin, $start, $end) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Summary Header
            fputcsv($file, ['LAPORAN PROFIT']);
            fputcsv($file, ['Periode', Carbon::parse($start)->format('d/m/Y') . ' - ' . Carbon::parse($end)->format('d/m/Y')]);
            fputcsv($file, []);
            
            // Summary Stats
            fputcsv($file, ['Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.')]);
            fputcsv($file, ['Total Cost', 'Rp ' . number_format($totalCost, 0, ',', '.')]);
            fputcsv($file, ['Total Profit', 'Rp ' . number_format($totalProfit, 0, ',', '.')]);
            fputcsv($file, ['Profit Margin', number_format($profitMargin, 2) . '%']);
            fputcsv($file, []);
            
            // Daily Data Header
            fputcsv($file, ['BREAKDOWN HARIAN']);
            fputcsv($file, ['Tanggal', 'Revenue', 'Cost', 'Profit']);
            
            // Daily Data
            foreach ($dailyData as $day) {
                fputcsv($file, [
                    $day['date'],
                    'Rp ' . number_format($day['revenue'], 0, ',', '.'),
                    'Rp ' . number_format($day['cost'], 0, ',', '.'),
                    'Rp ' . number_format($day['profit'], 0, ',', '.'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}