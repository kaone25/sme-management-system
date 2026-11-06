<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Expense;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();

        $lowStockProducts = Product::whereColumn(
            'quantity_in_stock',
            '<=',
            'low_stock_threshold'
        )->count();

        $totalSales = Sale::where('status', 'completed')
            ->sum('total_amount');

        $costOfGoodsSold = (float) SaleItem::whereHas(
            'sale',
            function ($query) {
                $query->where('status', 'completed');
            }
        )->selectRaw(
            'COALESCE(SUM(quantity * cost_price), 0) as total_cost'
        )->value('total_cost');

        $totalExpenses = Expense::sum('amount');

        $grossProfit = $totalSales - (float) $costOfGoodsSold;

        $netProfit = $grossProfit - (float) $totalExpenses;
        
        // Compare sales this week with sales last week.
        $thisWeekStart = Carbon::now()->startOfWeek();
        $lastWeekStart = $thisWeekStart->copy()->subWeek();
        $nextWeekStart = $thisWeekStart->copy()->addWeek();

        $thisWeekSales = (float) Sale::where('status', 'completed')
            ->where('sale_date', '>=', $thisWeekStart)
            ->where('sale_date', '<', $nextWeekStart)
            ->sum('total_amount');

        $lastWeekSales = (float) Sale::where('status', 'completed')
            ->where('sale_date', '>=', $lastWeekStart)
            ->where('sale_date', '<', $thisWeekStart)
            ->sum('total_amount');

        
        if ($lastWeekSales > 0) {
            $salesChangePercentage = (
                ($thisWeekSales - $lastWeekSales) / $lastWeekSales
            ) * 100;
        } else {
            $salesChangePercentage = null;
        }


        
        // Generate business insights from current business figures.
        $businessInsights = [];

        // Inventory insight.
        if ($lowStockProducts > 0) {
            $businessInsights[] = [
                'type' => 'warning',
                'title' => 'Restock products',
                'message' => $lowStockProducts
                    . ' product(s) have reached or fallen below their low-stock threshold. Review inventory and plan replenishment.',
                'action' => 'Check inventory',
                'url' => route('reports.inventory'),
            ];
        } else {
            $businessInsights[] = [
                'type' => 'success',
                'title' => 'Stock levels look good',
                'message' => 'No products are currently at or below their low-stock thresholds. Continue monitoring stock levels.',
                'action' => 'View inventory',
               'url' => auth()->user()->role === 'owner'
    ? route('products.index')
    : route('reports.inventory'),
            ];
        }

        // Profitability insight.
       
        // Profitability insight.
        if ($netProfit < 0) {
            $businessInsights[] = [
                'type' => 'danger',
                'title' => 'Review profitability',
                'message' => 'Recorded expenses and product costs exceed sales revenue. Review costs, expenses, and pricing.',
                'action' => auth()->user()->role === 'owner'
                    ? 'Review expenses'
                    : 'Review sales report',
                'url' => auth()->user()->role === 'owner'
                    ? route('expenses.index')
                    : route('reports.sales'),
            ];
        } elseif ($netProfit == 0) {
            $businessInsights[] = [
                'type' => 'warning',
                'title' => 'Break-even position',
                'message' => 'Your calculated net profit is zero. Review costs and expenses to identify opportunities to improve profitability.',
                'action' => auth()->user()->role === 'owner'
                    ? 'Review expenses'
                    : 'Review sales report',
                'url' => auth()->user()->role === 'owner'
                    ? route('expenses.index')
                    : route('reports.sales'),
            ];
        } else {
            $businessInsights[] = [
                'type' => 'success',
                'title' => 'Positive net profit',
                'message' => 'Your recorded sales currently exceed product costs and recorded expenses. Monitor these figures to sustain profitability.',
                'action' => auth()->user()->role === 'owner'
                    ? 'View sales'
                    : 'View sales report',
                'url' => auth()->user()->role === 'owner'
                    ? route('sales.index')
                    : route('reports.sales'),
            ];
        }


        
        // Expense insight.
        if ($totalExpenses > $grossProfit) {
            $businessInsights[] = [
                'type' => 'warning',
                'title' => 'Expenses exceed gross profit',
                'message' => 'Recorded expenses are greater than gross profit. Review spending and look for costs that can be reduced.',
                'action' => auth()->user()->role === 'owner'
                    ? 'Review expenses'
                    : 'View sales report',
                'url' => auth()->user()->role === 'owner'
                    ? route('expenses.index')
                    : route('reports.sales'),
            ];
        }



        // Get completed sales revenue for the last seven days.
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::tomorrow();

        $dailySales = Sale::where('status', 'completed')
            ->where('sale_date', '>=', $startDate)
            ->where('sale_date', '<', $endDate)
            ->selectRaw(
                'DATE(sale_date) as sales_day, SUM(total_amount) as revenue'
            )
            ->groupByRaw('DATE(sale_date)')
            ->pluck('revenue', 'sales_day');

        $salesTrendLabels = [];
        $salesTrendValues = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateKey = $date->toDateString();

            $salesTrendLabels[] = $date->format('D, d M');

            $salesTrendValues[] = round(
                (float) ($dailySales[$dateKey] ?? 0),
                2
            );
        }

        return view('dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'totalSales',
            'costOfGoodsSold',
            'totalExpenses',
            'grossProfit',
            'netProfit',
            'salesTrendLabels',
            'salesTrendValues',
            'businessInsights',
            'thisWeekSales',
            'lastWeekSales',
            'salesChangePercentage'
        ));
    }
}
