
<x-app-layout>
    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Sales History</h1>
                <p class="text-muted mb-0">
                    Review your recorded sales, revenue, and payment methods.
                </p>
            </div>

            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <span class="me-1">+</span> Record New Sale
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        {{-- Sales summary --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Total Sales</div>
                        <div class="h3 fw-bold mb-0">
                            {{ $totalSales }}
                        </div>
                        <div class="small text-muted mt-2">Recorded transactions</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Total Revenue</div>
                        <div class="h3 fw-bold text-success mb-0">
                            BWP {{ number_format((float) $totalRevenue, 2) }}
                        </div>
                        <div class="small text-muted mt-2">Revenue from recorded sales</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Sales Today</div>
                        <div class="h3 fw-bold text-primary mb-0">
                            {{ $salesToday }}
                        </div>
                        <div class="small text-muted mt-2">Transactions recorded today</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sales table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-4 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold mb-1">Recent Transactions</h2>
                        <p class="text-muted small mb-0">
                            Browse your sales history and open individual records.
                        </p>
                    </div>
                    <span class="badge text-bg-light">
                        {{ $sales->total() }} records
                    </span>
                </div>

                @if ($sales->isEmpty())
                    <div class="text-center py-5 px-3">
                        <h3 class="h5 fw-semibold">No sales recorded yet</h3>
                        <p class="text-muted mb-3">
                            Your sales will appear here after you record your first transaction.
                        </p>
                        <a href="{{ route('sales.create') }}" class="btn btn-primary">
                            Record Your First Sale
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Sale Number</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3 text-center">Items</th>
                                    <th class="py-3">Payment Method</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-end">Total</th>
                                    <th class="px-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td class="px-4 fw-semibold">
                                            {{ $sale->sale_number }}
                                        </td>
                                        <td>
                                            <span class="text-nowrap">
                                                {{ $sale->sale_date->format('d M Y') }}
                                            </span>
                                            <div class="small text-muted">
                                                {{ $sale->sale_date->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $sale->items->count() }}
                                        </td>
                                        <td>
                                            {{ $sale->payment_method ?? 'Not specified' }}
                                        </td>
                                        <td>
                                            <span class="badge text-bg-success">
                                                {{ ucfirst($sale->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-semibold text-nowrap">
                                            BWP {{ number_format((float) $sale->total_amount, 2) }}
                                        </td>
                                        <td class="px-4 text-end">
                                            <a href="{{ route('sales.show', $sale) }}"
                                                class="btn btn-sm btn-outline-primary text-nowrap">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-top">
                        {{ $sales->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
