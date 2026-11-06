<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="h4 fw-bold mb-1">Products & Inventory</h2>
            <p class="text-muted mb-0">Manage your products, pricing and stock levels.</p>
        </div>
    </x-slot>

    <div class="container-fluid px-0">

        {{-- Page introduction --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h4 fw-bold mb-1">Product Inventory</h1>
                <p class="text-muted mb-0">View and manage all products recorded in your business.</p>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary px-4 py-2">
                + Add Product
            </a>
        </div>

        {{-- Notifications --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif

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

        {{-- Inventory summary --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Products Listed</p>
                        <h3 class="fw-bold mb-0">{{ $products->count() }}</h3>
                        <small class="text-muted">Products shown on this page</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Low Stock Items</p>
                        <h3 class="fw-bold mb-0 text-danger">
                            {{ $products->filter(fn ($product) => $product->quantity_in_stock <= $product->low_stock_threshold)->count() }}
                        </h3>
                        <small class="text-muted">Items at or below their stock threshold</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Inventory Status</p>
                        <h3 class="fw-bold mb-0 text-success">
                            {{ $products->filter(fn ($product) => $product->quantity_in_stock > $product->low_stock_threshold)->count() }}
                        </h3>
                        <small class="text-muted">Items currently above their stock threshold</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product table --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white p-4">
                <h2 class="h5 fw-bold mb-1">All Products</h2>
                <p class="text-muted small mb-0">Product details, prices, quantities and available actions.</p>
            </div>

            <div class="card-body p-0">
                @if ($products->isEmpty())
                    <div class="p-4">
                        <div class="alert alert-info mb-0">
                            No products have been added yet. Select <strong>Add Product</strong> to create your first product.
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="py-3">SKU</th>
                                    <th class="py-3">Category</th>
                                    <th class="py-3 text-end">Cost Price</th>
                                    <th class="py-3 text-end">Selling Price</th>
                                    <th class="py-3 text-end">Stock</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 pe-4">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-4">
                                            <span class="fw-semibold">{{ $product->name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $product->sku }}</span>
                                        </td>
                                        <td>{{ $product->category ?? 'Uncategorized' }}</td>
                                        <td class="text-end text-nowrap">
                                            P {{ number_format((float) $product->cost_price, 2) }}
                                        </td>
                                        <td class="text-end text-nowrap fw-semibold">
                                            P {{ number_format((float) $product->selling_price, 2) }}
                                        </td>
                                        <td class="text-end text-nowrap">
                                            {{ $product->quantity_in_stock }} {{ $product->unit_of_measure }}
                                        </td>
                                        <td>
                                            @if ($product->quantity_in_stock <= $product->low_stock_threshold)
                                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                                    Low Stock
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                    In Stock
                                                </span>
                                            @endif
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('products.edit', $product) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    Edit
                                                </a>

                                                <form action="{{ route('products.destroy', $product) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
                @endif
            </div>
        </div>

    </div>
</x-app-layout>