
<x-app-layout>
    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Expense History</h1>
                <p class="text-muted mb-0">
                    Track and manage your business expenses in one place.
                </p>
            </div>

            <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                + Record New Expense
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

        {{-- Expense summary --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Total Expenses</div>
                        <div class="h3 fw-bold text-primary mb-1">
                            BWP {{ number_format((float) $totalExpenses, 2) }}
                        </div>
                        <div class="small text-muted">
                            All recorded business expenses
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Expense table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-4 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold mb-1">Recorded Expenses</h2>
                        <p class="text-muted small mb-0">
                            Review expense details and manage existing records.
                        </p>
                    </div>

                    <span class="badge text-bg-light">
                        {{ $expenses->total() }} records
                    </span>
                </div>

                @if ($expenses->isEmpty())
                    <div class="text-center py-5 px-3">
                        <h3 class="h5 fw-bold">No expenses recorded yet</h3>
                        <p class="text-muted mb-3">
                            Your business expenses will appear here after they are recorded.
                        </p>
                        <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                            Record Your First Expense
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Expense Number</th>
                                    <th class="py-3">Title</th>
                                    <th class="py-3">Category</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Payment Method</th>
                                    <th class="py-3 text-end">Amount (BWP)</th>
                                    <th class="px-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td class="px-4 fw-semibold">
                                            {{ $expense->expense_number }}
                                        </td>
                                        <td>
                                            {{ $expense->title }}
                                        </td>
                                        <td>
                                            <span class="badge text-bg-light">
                                                {{ $expense->category }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $expense->expense_date->format('d M Y') }}
                                        </td>
                                        <td>
                                            {{ $expense->payment_method ?? 'Not specified' }}
                                        </td>
                                        <td class="text-end fw-semibold text-nowrap">
                                            {{ number_format((float) $expense->amount, 2) }}
                                        </td>
                                        <td class="px-4 text-end">
                                            <div class="d-inline-flex gap-2">
                                                <a href="{{ route('expenses.edit', $expense) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Edit
                                                </a>

                                                <form action="{{ route('expenses.destroy', $expense) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-top">
                        {{ $expenses->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>
