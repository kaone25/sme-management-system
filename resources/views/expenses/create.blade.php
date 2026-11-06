
<x-app-layout>
    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Record New Expense</h1>
                <p class="text-muted mb-0">
                    Capture a business expense to help track your costs.
                </p>
            </div>

            <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                &larr; Back to Expenses
            </a>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please correct the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- Expense form --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">

                        <div class="mb-4">
                            <h2 class="h5 fw-bold mb-1">Expense Details</h2>
                            <p class="text-muted small mb-0">
                                Fields marked with an asterisk (*) are required.
                            </p>
                        </div>

                        <form action="{{ route('expenses.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">
                                    Expense Title <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}"
                                    placeholder="e.g. Office rent"
                                    required
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">
                                    Description
                                    <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Provide additional details"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="amount" class="form-label fw-semibold">
                                        Amount (BWP) <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="amount"
                                        id="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') }}"
                                        min="0.01"
                                        step="0.01"
                                        placeholder="0.00"
                                        required
                                    >
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <label for="category" class="form-label fw-semibold">
                                        Expense Category <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="category"
                                        id="category"
                                        class="form-select @error('category') is-invalid @enderror"
                                        required
                                    >
                                        <option value="">Select a category</option>
                                        @foreach ([
                                            'Rent',
                                            'Utilities',
                                            'Transport',
                                            'Salaries',
                                            'Stock Purchases',
                                            'Marketing',
                                            'Maintenance',
                                            'Office Supplies',
                                            'Other'
                                        ] as $category)
                                            <option
                                                value="{{ $category }}"
                                                @selected(old('category') === $category)
                                            >
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="expense_date" class="form-label fw-semibold">
                                        Expense Date <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="expense_date"
                                        id="expense_date"
                                        class="form-control @error('expense_date') is-invalid @enderror"
                                        value="{{ old('expense_date', date('Y-m-d')) }}"
                                        required
                                    >
                                    @error('expense_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <label for="payment_method" class="form-label fw-semibold">
                                        Payment Method
                                        <span class="text-muted fw-normal">(Optional)</span>
                                    </label>
                                    <select
                                        name="payment_method"
                                        id="payment_method"
                                        class="form-select @error('payment_method') is-invalid @enderror"
                                    >
                                        <option value="">Select payment method</option>
                                        @foreach ([
                                            'Cash',
                                            'Card',
                                            'Mobile Money',
                                            'Bank Transfer'
                                        ] as $method)
                                            <option
                                                value="{{ $method }}"
                                                @selected(old('payment_method') === $method)
                                            >
                                                {{ $method }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary">
                                    Save Expense
                                </button>

                                <a href="{{ route('expenses.index') }}"
                                    class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Guidance panel --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h6 fw-bold mb-3">Expense Recording Tips</h2>

                        <div class="mb-3">
                            <div class="fw-semibold">Use a clear title</div>
                            <p class="text-muted small mb-0">
                                For example, office rent, electricity, or transport.
                            </p>
                        </div>

                        <div class="mb-3">
                            <div class="fw-semibold">Choose the right category</div>
                            <p class="text-muted small mb-0">
                                Categories help you understand where your business money goes.
                            </p>
                        </div>

                        <div>
                            <div class="fw-semibold">Enter the correct amount and date</div>
                            <p class="text-muted small mb-0">
                                Accurate records support better financial reports.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h6 fw-bold mb-2">Currency</h2>
                        <p class="text-muted small mb-0">
                            Record expenses in Botswana pula (BWP) using the actual expense amount.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
