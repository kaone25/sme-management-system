
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Report | Small Business Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

<nav class="navbar navbar-dark shadow-sm"
     style="background: linear-gradient(120deg, #0f172a, #164e63);">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            Small Business Management System
        </a>

        <a href="{{ route('dashboard') }}"
           class="btn btn-outline-light btn-sm">
            Dashboard
        </a>
    </div>
</nav>

<main class="container-fluid px-4 px-lg-5 py-4">

    {{-- Page heading and actions --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <p class="text-uppercase small fw-semibold mb-2"
               style="color: #0f766e; letter-spacing: 1.5px;">
                REPORTS & ANALYTICS
            </p>

            <h1 class="h2 fw-bold text-dark mb-2">Inventory Report</h1>

            <p class="text-secondary mb-0">
                Monitor stock levels, inventory value and potential sales.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('reports.sales') }}"
               class="btn btn-outline-secondary">
                Sales & Profit Reports
            </a>

            <a href="{{ route('reports.inventory.export') }}"
               class="btn btn-success fw-semibold">
                Export CSV
            </a>
        </div>
    </div>

    {{-- Inventory summary cards --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <p class="text-secondary small fw-semibold mb-2">
                        TOTAL PRODUCTS
                    </p>
                    <div class="d-flex align-items-end justify-content-between">
                        <h2 class="h3 fw-bold mb-0">
                            {{ number_format($totalProducts) }}
                        </h2>
                        <span class="badge rounded-pill bg-primary-subtle text-primary">
                            Products
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <p class="text-secondary small fw-semibold mb-2">
                        LOW-STOCK PRODUCTS
                    </p>
                    <div class="d-flex align-items-end justify-content-between">
                        <h2 class="h3 fw-bold mb-0 {{ $lowStockProducts > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($lowStockProducts) }}
                        </h2>
                        <span class="badge rounded-pill {{ $lowStockProducts > 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
                            {{ $lowStockProducts > 0 ? 'Attention' : 'All good' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <p class="text-secondary small fw-semibold mb-2">
                        UNITS IN STOCK
                    </p>
                    <h2 class="h3 fw-bold mb-0">
                        {{ number_format($totalUnitsInStock) }}
                    </h2>
                    <p class="small text-secondary mb-0 mt-2">
                        Total available quantity
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <p class="text-secondary small fw-semibold mb-2">
                        INVENTORY COST VALUE
                    </p>
                    <h2 class="h4 fw-bold mb-0">
                        BWP {{ number_format($totalCostValue, 2) }}
                    </h2>
                    <p class="small text-secondary mb-0 mt-2">
                        Cost of current stock
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <p class="text-secondary small fw-semibold mb-2">
                        POTENTIAL SALES VALUE
                    </p>
                    <h2 class="h4 fw-bold mb-0">
                        BWP {{ number_format($potentialSalesValue, 2) }}
                    </h2>
                    <p class="small text-secondary mb-0 mt-2">
                        Value if all current stock sells
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Stock details table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h2 class="h5 fw-bold mb-1">Product Stock Details</h2>
                    <p class="small text-secondary mb-0">
                        Stock quantities, prices and stock status for each product.
                    </p>
                </div>

                <span class="badge bg-light text-secondary border">
                    {{ number_format($totalProducts) }} products
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f1f5f9;">
                        <tr class="small text-secondary">
                            <th class="px-4 py-3">PRODUCT</th>
                            <th class="py-3">SKU</th>
                            <th class="py-3">CATEGORY</th>
                            <th class="text-end py-3">COST PRICE</th>
                            <th class="text-end py-3">SELLING PRICE</th>
                            <th class="text-end py-3">QUANTITY</th>
                            <th class="text-end py-3">STOCK COST</th>
                            <th class="text-end py-3">POTENTIAL SALES</th>
                            <th class="px-4 py-3">STATUS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            @php
                                $stockQuantity = (int) $product->quantity_in_stock;
                                $stockCost = (float) $product->cost_price * $stockQuantity;
                                $stockSales = (float) $product->selling_price * $stockQuantity;
                                $isLowStock = $stockQuantity <= (int) $product->low_stock_threshold;
                            @endphp

                            <tr>
                                <td class="px-4">
                                    <span class="fw-semibold text-dark">
                                        {{ $product->name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="small text-secondary">
                                        {{ $product->sku ?: '—' }}
                                    </span>
                                </td>

                                <td>{{ $product->category ?: '—' }}</td>

                                <td class="text-end text-nowrap">
                                    BWP {{ number_format((float) $product->cost_price, 2) }}
                                </td>

                                <td class="text-end text-nowrap">
                                    BWP {{ number_format((float) $product->selling_price, 2) }}
                                </td>

                                <td class="text-end fw-semibold">
                                    {{ number_format($stockQuantity) }}
                                </td>

                                <td class="text-end text-nowrap">
                                    BWP {{ number_format($stockCost, 2) }}
                                </td>

                                <td class="text-end text-nowrap">
                                    BWP {{ number_format($stockSales, 2) }}
                                </td>

                                <td class="px-4">
                                    @if ($stockQuantity === 0)
                                        <span class="badge rounded-pill bg-danger-subtle text-danger">
                                            Out of Stock
                                        </span>
                                    @elseif ($isLowStock)
                                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-success-subtle text-success">
                                            In Stock
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <p class="fw-semibold text-dark mb-1">
                                        No products found
                                    </p>
                                    <p class="small text-secondary mb-0">
                                        Add products to your inventory to see their stock report here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0 px-4 py-3">
            <p class="small text-secondary mb-0">
                Stock status is based on each product's low-stock threshold.
            </p>
        </div>
    </div>

</main>

<footer class="py-4 mt-4">
    <div class="container-fluid text-center">
        <small class="text-secondary">
            Small Business Management and Growth Support System
        </small>
    </div>
</footer>

</body>
</html>
