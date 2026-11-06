<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesReportController extends Controller
{
    public function index(Request $request): View
    {
        $range = $request->input('range', 'month');

        switch ($range) {
            case 'today':
                $from = Carbon::today()->toDateString();
                $to = Carbon::today()->toDateString();
                break;

            case 'week':
                $from = Carbon::now()->startOfWeek()->toDateString();
                $to = Carbon::now()->endOfWeek()->toDateString();
                break;

            case 'custom':
                $request->validate([
                    'from' => ['required', 'date'],
                    'to' => ['required', 'date', 'after_or_equal:from'],
                ]);

                $from = $request->input('from');
                $to = $request->input('to');
                break;

            default:
                $from = Carbon::now()->startOfMonth()->toDateString();
                $to = Carbon::now()->endOfMonth()->toDateString();
                $range = 'month';
                break;
        }

        $sales = Sale::where('status', 'completed')
            ->whereBetween('sale_date', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ])
            ->orderByDesc('sale_date')
            ->get();

        $totalSales = (float) $sales->sum('total_amount');

        $saleIds = $sales->pluck('id');

        $costOfGoodsSold = (float) SaleItem::whereIn('sale_id', $saleIds)
            ->sum(\DB::raw('quantity * cost_price'));

        $totalExpenses = (float) Expense::whereBetween('expense_date', [
            $from,
            $to,
        ])->sum('amount');

        $grossProfit = $totalSales - $costOfGoodsSold;
        $netProfit = $grossProfit - $totalExpenses;

        return view('reports.sales', compact(
            'sales',
            'from',
            'to',
            'range',
            'totalSales',
            'costOfGoodsSold',
            'grossProfit',
            'totalExpenses',
            'netProfit'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        $from = $request->input('from');
        $to = $request->input('to');

        $sales = Sale::where('status', 'completed')
            ->whereBetween('sale_date', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ])
            ->orderBy('sale_date')
            ->get();

        $filename = 'sales-report-' . $from . '-to-' . $to . '.csv';

        return response()->streamDownload(function () use ($sales) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Sale Number',
                'Sale Date',
                'Payment Method',
                'Total Amount (BWP)',
            ]);

            foreach ($sales as $sale) {
                fputcsv($handle, [
                    $sale->sale_number,
                    $sale->sale_date,
                    $sale->payment_method ?? 'Not specified',
                    $sale->total_amount,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
