
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sale Details - Small Business Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Sale Details</h1>
                <p class="text-muted mb-0">
                    Reference: {{ $sale->sale_number }}
                </p>
            </div>

            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                Back to Sales
            </a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <strong>Sale Number</strong>
                        <p class="mb-0">{{ $sale->sale_number }}</p>
                    </div>

                    <div class="col-md-4">
                        <strong>Date</strong>
                        <p class="mb-0">
                            {{ $sale->sale_date->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <strong>Payment Method</strong>
                        <p class="mb-0">
                            {{ $sale->payment_method ?? 'Not specified' }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <strong>Status</strong>
                        <p class="mb-0">{{ ucfirst($sale->status) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Products Sold</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Line Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sale->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">
                                    {{ number_format((float) $item->unit_price, 2) }}
                                </td>
                                <td class="text-end">
                                    {{ number_format((float) $item->line_total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Sale Total</th>
                            <th class="text-end">
                                {{ number_format((float) $sale->total_amount, 2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
