<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class InventoryReportController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('name')->get();

        $totalProducts = $products->count();

        $lowStockProducts = $products->filter(function ($product) {
            return $product->quantity_in_stock
                <= $product->low_stock_threshold;
        })->count();

        $totalUnitsInStock = $products->sum('quantity_in_stock');

        $totalCostValue = $products->sum(function ($product) {
            return (float) $product->cost_price
                * (int) $product->quantity_in_stock;
        });

        $potentialSalesValue = $products->sum(function ($product) {
            return (float) $product->selling_price
                * (int) $product->quantity_in_stock;
        });

        return view('reports.inventory', compact(
            'products',
            'totalProducts',
            'lowStockProducts',
            'totalUnitsInStock',
            'totalCostValue',
            'potentialSalesValue'
        ));
    }
    public function export()
{
    $products = Product::orderBy('name')->get();

    $fileName = 'inventory-report-' . now()->format('Y-m-d-His') . '.csv';

    return response()->streamDownload(function () use ($products) {
        $output = fopen('php://output', 'w');

        // Add a UTF-8 BOM so Excel handles the file correctly.
        fwrite($output, "\xEF\xBB\xBF");

        // CSV column headings.
        fputcsv($output, [
            'Product',
            'SKU',
            'Category',
            'Cost Price (BWP)',
            'Selling Price (BWP)',
            'Quantity in Stock',
            'Low Stock Threshold',
            'Stock Cost Value (BWP)',
            'Potential Sales Value (BWP)',
            'Stock Status',
        ]);

        foreach ($products as $product) {
            $quantity = (int) $product->quantity_in_stock;
            $costPrice = (float) $product->cost_price;
            $sellingPrice = (float) $product->selling_price;

            $stockStatus = $quantity <= (int) $product->low_stock_threshold
                ? 'Low Stock'
                : 'In Stock';

            fputcsv($output, [
                $product->name,
                $product->sku,
                $product->category,
                number_format($costPrice, 2, '.', ''),
                number_format($sellingPrice, 2, '.', ''),
                $quantity,
                $product->low_stock_threshold,
                number_format($costPrice * $quantity, 2, '.', ''),
                number_format($sellingPrice * $quantity, 2, '.', ''),
                $stockStatus,
            ]);
        }

        fclose($output);
    }, $fileName, [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}
}
