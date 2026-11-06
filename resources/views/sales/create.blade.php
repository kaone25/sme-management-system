
<x-app-layout>
    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Record a Sale</h1>
                <p class="text-muted mb-0">
                    Record a transaction and update your inventory.
                </p>
            </div>

            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                &larr; Back to Sales
            </a>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please correct the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        @if ($products->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 px-4">
                    <h2 class="h5 fw-bold">No products available for sale</h2>
                    <p class="text-muted">
                        Add a product with available stock before recording a sale.
                    </p>
                    @if (Auth::user()->role === 'owner')
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        Add a Product
    </a>
@else
    <p class="text-muted small">
        Please contact the business owner to add stock before recording a sale.
    </p>
@endif
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary ms-2">
                        Back to Sales
                    </a>
                </div>
            </div>
        @else
            <div class="row g-4">

                {{-- Sale form --}}
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-1">Sale Information</h2>
                                <p class="text-muted small mb-0">
                                    Complete the details below to record the transaction.
                                </p>
                            </div>

                            <form action="{{ route('sales.store') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label for="product_id" class="form-label fw-semibold">
                                        Product <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        name="product_id"
                                        id="product_id"
                                        class="form-select @error('product_id') is-invalid @enderror"
                                        required
                                    >
                                        <option value="">Select a product</option>

                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product->id }}"
                                                @selected(old('product_id') == $product->id)
                                            >
                                                {{ $product->name }}
                                                — Stock: {{ $product->quantity_in_stock }}
                                                — Price: BWP {{ number_format((float) $product->selling_price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="form-text">
                                        Available stock and selling price are shown for each product.
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="quantity" class="form-label fw-semibold">
                                        Quantity Sold <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        name="quantity"
                                        id="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        min="0.001"
                                        step="0.001"
                                        value="{{ old('quantity', 1) }}"
                                        required
                                    >

                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="form-text">
                                        The system checks available stock when you submit the sale.
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="payment_method" class="form-label fw-semibold">
                                        Payment Method
                                    </label>

                                    <select
                                        name="payment_method"
                                        id="payment_method"
                                        class="form-select @error('payment_method') is-invalid @enderror"
                                    >
                                        <option value="">Select payment method</option>
                                        <option value="Cash" @selected(old('payment_method') == 'Cash')>
                                            Cash
                                        </option>
                                        <option value="Card" @selected(old('payment_method') == 'Card')>
                                            Card
                                        </option>
                                        <option value="Mobile Money" @selected(old('payment_method') == 'Mobile Money')>
                                            Mobile Money
                                        </option>
                                        <option value="Bank Transfer" @selected(old('payment_method') == 'Bank Transfer')>
                                            Bank Transfer
                                        </option>
                                    </select>

                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary">
                                        Record Sale
                                    </button>

                                    <a href="{{ route('sales.index') }}"
                                        class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Helpful information --}}
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h6 fw-bold mb-3">Before Recording a Sale</h2>

                            <div class="d-flex gap-3 mb-3">
                                <div>
                                    <div class="fw-semibold">Select a product</div>
                                    <p class="text-muted small mb-0">
                                        Check its selling price and available stock.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex gap-3 mb-3">
                                <div>
                                    <div class="fw-semibold">Enter the quantity</div>
                                    <p class="text-muted small mb-0">
                                        Enter the amount sold. It must not exceed available stock.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex gap-3">
                                <div>
                                    <div class="fw-semibold">Choose payment method</div>
                                    <p class="text-muted small mb-0">
                                        Record how the customer paid, if known.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h6 fw-bold mb-2">Inventory Protection</h2>
                            <p class="text-muted small mb-0">
                                When a sale is accepted, the system updates the product's stock.
                                Transactions that exceed available stock are rejected.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>
