<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(): View
{
    $sales = Sale::with('items.product')
        ->latest('sale_date')
        ->paginate(10);

    $totalSales = Sale::count();

    $totalRevenue = Sale::where('status', 'completed')
        ->sum('total_amount');

    $salesToday = Sale::whereDate('sale_date', today())
        ->count();

    return view('sales.index', compact(
        'sales',
        'totalSales',
        'totalRevenue',
        'salesToday'
    ));
}
    
public function create(): View
{
    $products = \App\Models\Product::where('quantity_in_stock', '>', 0)
        ->orderBy('name')
        ->get();

    return view('sales.create', compact('products'));
}

public function store(\Illuminate\Http\Request $request)
{
    $validated = $request->validate([
        'product_id' => ['required', 'integer', 'exists:products,id'],
        'quantity' => ['required', 'numeric', 'gt:0', 'decimal:0,3'],
        'payment_method' => [
            'nullable',
            'in:Cash,Card,Mobile Money,Bank Transfer',
        ],
    ]);

    $sale = DB::transaction(function () use ($validated) {
        $product = Product::whereKey($validated['product_id'])
            ->lockForUpdate()
            ->firstOrFail();

        $quantity = (float) $validated['quantity'];
        $availableStock = (float) $product->quantity_in_stock;

        if ($quantity > $availableStock) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'quantity' => 'Insufficient stock. Available quantity: '
                    . $product->quantity_in_stock,
            ]);
        }

        $unitPrice = (float) $product->selling_price;
        $lineTotal = round($quantity * $unitPrice, 2);

        $sale = Sale::create([
            'sale_number' => 'SALE-' . now()->format('YmdHis')
                . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
            'sale_date' => now(),
            'total_amount' => $lineTotal,
            'payment_method' => $validated['payment_method'] ?? null,
            'status' => 'completed',
        ]);

        SaleItem::create([
    'sale_id' => $sale->id,
    'product_id' => $product->id,
    'quantity' => $quantity,
    'unit_price' => $unitPrice,
    'cost_price' => (float) $product->cost_price,
    'line_total' => $lineTotal,
]);

        $product->quantity_in_stock = round(
            $availableStock - $quantity,
            3
        );
        $product->save();

        return $sale;
    });

    return redirect()
        ->route('sales.index')
        ->with('success', 'Sale ' . $sale->sale_number . ' recorded successfully.');
}

public function show(Sale $sale): View
{
    $sale->load('items.product');

    return view('sales.show', compact('sale'));
}


}
