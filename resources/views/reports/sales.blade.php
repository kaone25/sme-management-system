
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="h4 fw-bold mb-1">Sales &amp; Profit Reports</h2>
            <p class="text-muted mb-0">Track revenue, product costs, expenses and business profitability.</p>
        </div>
    </x-slot>

    <div class="container-fluid px-0">

        {{-- Page introduction --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h4 fw-bold mb-1">Financial Overview</h1>
                <p class="text-muted mb-0">Review your business performance for the selected period.</p>
            </div>

            <form method="GET" action="{{ route('reports.sales.export') }}">
                <input type="hidden" name="from" value="{{ $from }}">
                <input type="hidden" name="to" value="{{ $to }}">

                <button type="submit" class="btn btn-outline-success px-4 py-2">
                    Export CSV
                </button>
            </form>
        </div>

        {{-- Date filters --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white p-4">
                <h2 class="h5 fw-bold mb-1">Report Period</h2>
                <p class="text-muted small mb-0">Choose a quick range or specify your own dates.</p>
            </div>

            <div class="card-body p-4">
                <form method="GET" action="{{ route('reports.sales') }}">
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <button type="submit" name="range" value="today"
                            class="btn {{ $range === 'today' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Today
                        </button>

                        <button type="submit" name="range" value="week"
                            class="btn {{ $range === 'week' ? 'btn-primary' : 'btn-outline-primary' }}">
                            This Week
                        </button>

                        <button type="submit" name="range" value="month"
                            class="btn {{ $range === 'month' ? 'btn-primary' : 'btn-outline-primary' }}">
                            This Month
                        </button>
                    </div>

                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="from" class="form-label fw-semibold">From date</label>
                            <input type="date" id="from" name="from"
                                class="form-control @error('from') is-invalid @enderror"
                                value="{{ $from }}" required>
                            @error('from')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="to" class="form-label fw-semibold">To date</label>
                            <input type="date" id="to" name="to"
                                class="form-control @error('to') is-invalid @enderror"
                                value="{{ $to }}" min="{{ $from }}" required>
                            @error('to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4">
                            <button type="submit" name="range" value="custom"
                                class="btn btn-primary w-100 py-2">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Selected period --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <h2 class="h5 fw-bold mb-1">Financial Summary</h2>
                <p class="text-muted small mb-0">
                    {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
                    – {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
                </p>
            </div>

            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                Currency: BWP
            </span>
        </div>

        {{-- Summary cards --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Sales Revenue</p>
                        <h3 class="h4 fw-bold mb-2">P {{ number_format($totalSales, 2) }}</h3>
                        <small class="text-muted">Completed sales in this period</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Cost of Goods Sold</p>
                        <h3 class="h4 fw-bold mb-2">P {{ number_format($costOfGoodsSold, 2) }}</h3>
                        <small class="text-muted">Recorded cost of products sold</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Gross Profit</p>
                        <h3 class="h4 fw-bold mb-2 {{ $grossProfit < 0 ? 'text-danger' : 'text-success' }}">
                            P {{ number_format($grossProfit, 2) }}
                        </h3>
                        <small class="text-muted">Revenue minus product costs</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Total Expenses</p>
                        <h3 class="h4 fw-bold mb-2">P {{ number_format($totalExpenses, 2) }}</h3>
                        <small class="text-muted">Expenses recorded during this period</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Net Profit</p>
                        <h3 class="h4 fw-bold mb-2 {{ $netProfit < 0 ? 'text-danger' : 'text-success' }}">
                            P {{ number_format($netProfit, 2) }}
                        </h3>
                        <small class="text-muted">Gross profit minus expenses</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sales transactions --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h2 class="h5 fw-bold mb-1">Sales Transactions</h2>
                        <p class="text-muted small mb-0">Completed sales within the selected period.</p>
                    </div>

                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                        {{ $sales->count() }} {{ $sales->count() === 1 ? 'transaction' : 'transactions' }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($sales->isEmpty())
                    <div class="p-4">
                        <div class="alert alert-info mb-0">
                            No completed sales were found for this period.
                            Try selecting another date range.
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th class="px-4 py-3">Sale Number</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Payment Method</th>
                                    <th class="py-3 text-end pe-4">Total (BWP)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td class="px-4 fw-semibold">
                                            {{ $sale->sale_number ?? ('Sale #' . $sale->id) }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                                        <td>{{ $sale->payment_method ?: 'Not specified' }}</td>
                                        <td class="text-end pe-4 fw-semibold">
                                            P {{ number_format((float) $sale->total_amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
