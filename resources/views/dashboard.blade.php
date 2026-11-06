 
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="h4 fw-bold mb-1">Business Dashboard</h2>
            <p class="text-muted mb-0">Monitor your business performance at a glance.</p>
        </div>
    </x-slot>

    <div class="container-fluid px-0">

        {{-- Welcome section --}}
        <div class="p-4 p-md-5 mb-4 rounded-4 text-white"
             style="background: linear-gradient(120deg, #172554, #1e40af);">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <p class="text-uppercase small fw-semibold mb-2"
                       style="color: #99f6e4; letter-spacing: 1.5px;">
                        BUSINESS OVERVIEW
                    </p>
                    <h1 class="h3 fw-bold mb-2">Welcome to your dashboard</h1>
                    <p class="mb-0" style="color: #dbeafe;">
                        Manage your products, track sales, monitor expenses and understand your business performance.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('sales.create') }}"
                       class="btn btn-light fw-semibold px-4 py-2">
                        + Record a Sale
                    </a>
                </div>
            </div>
        </div>

        {{-- Key business figures --}}
        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-muted fw-medium">Total Products</span>
                            <span class="rounded-3 px-2 py-1"
                                  style="background:#dbeafe;color:#1d4ed8;">▦</span>
                        </div>
                        <h2 class="fw-bold mb-1">{{ number_format($totalProducts) }}</h2>
                        <p class="text-muted small mb-0">Products recorded</p>
                        <a href="{{ route('products.index') }}"
                           class="small text-decoration-none mt-3 d-inline-block">View inventory →</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-muted fw-medium">Low Stock</span>
                            <span class="rounded-3 px-2 py-1"
                                  style="background:#fef3c7;color:#92400e;">!</span>
                        </div>
                        <h2 class="fw-bold mb-1 {{ $lowStockProducts > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($lowStockProducts) }}
                        </h2>
                        <p class="text-muted small mb-0">Products needing attention</p>
                        <a href="{{ route('reports.inventory') }}"
                           class="small text-decoration-none mt-3 d-inline-block">Check inventory →</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-muted fw-medium">Total Sales</span>
                            <span class="rounded-3 px-2 py-1"
                                  style="background:#d1fae5;color:#047857;">↗</span>
                        </div>
                        <h2 class="fw-bold mb-1">P {{ number_format((float) $totalSales, 2) }}</h2>
                        <p class="text-muted small mb-0">Recorded sales revenue</p>
                        <a href="{{ route('sales.index') }}"
                           class="small text-decoration-none mt-3 d-inline-block">View sales →</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-muted fw-medium">Total Expenses</span>
                            <span class="rounded-3 px-2 py-1"
                                  style="background:#fee2e2;color:#b91c1c;">−</span>
                        </div>
                        <h2 class="fw-bold mb-1">P {{ number_format((float) $totalExpenses, 2) }}</h2>
                        <p class="text-muted small mb-0">Recorded business expenses</p>
                        <a href="{{ route('expenses.index') }}"
                           class="small text-decoration-none mt-3 d-inline-block">View expenses →</a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Financial performance --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h3 class="h5 fw-bold mb-1">Financial Performance</h3>
                <p class="text-muted small mb-0">A summary of your recorded business finances.</p>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <p class="text-muted mb-2">Cost of Goods Sold</p>
                        <h3 class="h4 fw-bold mb-1">
                            P {{ number_format((float) $costOfGoodsSold, 2) }}
                        </h3>
                        <p class="small text-muted mb-0">Cost of products sold</p>
                    </div>

                    <div class="col-12 col-md-4 border-start-md">
                        <p class="text-muted mb-2">Gross Profit</p>
                        <h3 class="h4 fw-bold mb-1 {{ $grossProfit < 0 ? 'text-danger' : 'text-success' }}">
                            P {{ number_format((float) $grossProfit, 2) }}
                        </h3>
                        <p class="small text-muted mb-0">Sales minus cost of goods sold</p>
                    </div>

                    <div class="col-12 col-md-4">
                        <p class="text-muted mb-2">Net Profit</p>
                        <h3 class="h4 fw-bold mb-1 {{ $netProfit < 0 ? 'text-danger' : 'text-success' }}">
                            P {{ number_format((float) $netProfit, 2) }}
                        </h3>
                        <p class="small text-muted mb-0">Gross profit minus expenses</p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Weekly Sales Performance Comparison --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h3 class="h5 fw-bold mb-1">Weekly Sales Performance</h3>
                <p class="text-muted small mb-0">
                    Compare completed sales this week with last week.
                </p>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border h-100">
                            <p class="text-muted small mb-1">This Week</p>
                            <h4 class="h4 fw-bold mb-0">
                                BWP {{ number_format($thisWeekSales, 2) }}
                            </h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border h-100">
                            <p class="text-muted small mb-1">Last Week</p>
                            <h4 class="h4 fw-bold mb-0">
                                BWP {{ number_format($lastWeekSales, 2) }}
                            </h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border h-100">
                            <p class="text-muted small mb-1">Change in Sales</p>

                           
                            @if ($salesChangePercentage === null)
                                <h4 class="h4 fw-bold mb-0 text-secondary">
                                    {{ $thisWeekSales > 0 ? 'New sales' : 'No sales' }}
                                </h4>
                                <p class="small text-muted mb-0 mt-1">
                                    {{ $thisWeekSales > 0
                                        ? 'Sales recorded this week; no sales were recorded last week.'
                                        : 'No sales were recorded in either week.' }}
                                </p>
                            @else
                                <h4 class="h4 fw-bold mb-0
                                    {{ $salesChangePercentage > 0 ? 'text-success' : ($salesChangePercentage < 0 ? 'text-danger' : 'text-secondary') }}">
                                    {{ $salesChangePercentage > 0 ? '+' : '' }}{{ number_format($salesChangePercentage, 1) }}%
                                </h4>
                                <p class="small text-muted mb-0 mt-1">
                                    {{ $salesChangePercentage > 0
                                        ? 'Sales have increased.'
                                        : ($salesChangePercentage < 0
                                            ? 'Sales have decreased.'
                                            : 'No percentage change.') }}
                                </p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Business Insights --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h3 class="h5 fw-bold mb-1">Business Insights & Recommendations</h3>
                <p class="text-muted small mb-0">
                    Practical guidance based on your recorded business data.
                </p>
            </div>

            <div class="card-body p-4">
                
                @forelse ($businessInsights as $insight)
                    @php
                        $alertClass = match ($insight['type']) {
                            'danger' => 'alert-danger',
                            'warning' => 'alert-warning',
                            'success' => 'alert-success',
                            default => 'alert-info',
                        };
                    @endphp

                    <div class="alert {{ $alertClass }} d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3"
                         role="status">
                        <div>
                            <h4 class="h6 fw-bold mb-1">
                                {{ $insight['title'] }}
                            </h4>
                            <p class="mb-0">
                                {{ $insight['message'] }}
                            </p>
                        </div>

                        <a href="{{ $insight['url'] }}"
                           class="btn btn-outline-dark btn-sm flex-shrink-0">
                            {{ $insight['action'] }} →
                        </a>
                    </div>
                @empty
                    <p class="text-muted mb-0">
                        No business insights are available yet.
                    </p>
                @endforelse

            </div>
        </div>

        {{-- Sales Trends --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h3 class="h5 fw-bold mb-1">Sales Trends</h3>
                <p class="text-muted small mb-0">
                    Daily sales revenue over the last seven days.
                </p>
            </div>

            <div class="card-body p-4">
                <div style="position: relative; height: 320px;">
                    <canvas id="salesTrendChart"
                            role="img"
                            aria-label="Bar chart showing daily sales revenue for the last seven days">
                        Sales revenue for the last seven days.
                    </canvas>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const canvas = document.getElementById('salesTrendChart');

                    if (!canvas || typeof window.Chart === 'undefined') {
                        return;
                    }

                    new window.Chart(canvas, {
                        type: 'bar',
                        data: {
                            labels: @json($salesTrendLabels),
                            datasets: [{
                                label: 'Sales Revenue (P)',
                                data: @json($salesTrendValues),
                                backgroundColor: 'rgba(37, 99, 235, 0.75)',
                                borderColor: 'rgb(29, 78, 216)',
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Revenue (P)'
                                    },
                                    ticks: {
                                        callback: function (value) {
                                            return 'P ' + Number(value).toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return 'Revenue: P ' +
                                                Number(context.parsed.y).toLocaleString(
                                                    undefined,
                                                    {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2
                                                    }
                                                );
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endpush

        {{-- Quick actions --}}
        <div class="mb-4">
            <div class="mb-3">
                <h3 class="h5 fw-bold mb-1">Quick Actions</h3>
                <p class="text-muted small mb-0">Shortcuts to common business tasks.</p>
            </div>

            <div class="row g-3">
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('products.index') }}"
                       class="card h-100 text-decoration-none shadow-sm">
                        <div class="card-body p-3">
                            <span class="fw-bold d-block mb-1">Products & Inventory</span>
                            <span class="small text-muted">Manage products and stock levels →</span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('sales.create') }}"
                       class="card h-100 text-decoration-none shadow-sm">
                        <div class="card-body p-3">
                            <span class="fw-bold d-block mb-1">Record a Sale</span>
                            <span class="small text-muted">Register a customer purchase →</span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('customers.index') }}"
                       class="card h-100 text-decoration-none shadow-sm">
                        <div class="card-body p-3">
                            <span class="fw-bold d-block mb-1">Customers</span>
                            <span class="small text-muted">Manage customer records →</span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('reports.sales') }}"
                       class="card h-100 text-decoration-none shadow-sm">
                        <div class="card-body p-3">
                            <span class="fw-bold d-block mb-1">Sales Report</span>
                            <span class="small text-muted">Review recorded sales →</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
