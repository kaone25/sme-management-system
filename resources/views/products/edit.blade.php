<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="h4 fw-bold mb-1">Edit Product</h2>
            <p class="text-muted mb-0">Update your product information and inventory settings.</p>
        </div>
    </x-slot>

    <div class="container-fluid px-0">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h4 fw-bold mb-1">Update Product Details</h1>
                <p class="text-muted mb-0">
                    Editing: <span class="fw-semibold text-dark">{{ $product->name }}</span>
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                &larr; Back to Inventory
            </a>
        </div>

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

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Basic information --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white p-4">
                    <h2 class="h5 fw-bold mb-1">Basic Information</h2>
                    <p class="small text-muted mb-0">Update the product name, code and description.</p>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="sku" class="form-label fw-semibold">SKU / Product Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                   id="sku" name="sku"
                                   value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="category" class="form-label fw-semibold">Category</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror"
                                   id="category" name="category"
                                   value="{{ old('category', $product->category) }}">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white p-4">
                    <h2 class="h5 fw-bold mb-1">Pricing</h2>
                    <p class="small text-muted mb-0">Review or update prices in Botswana pula.</p>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="cost_price" class="form-label fw-semibold">Cost Price (BWP) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">P</span>
                                <input type="number" class="form-control @error('cost_price') is-invalid @enderror"
                                       id="cost_price" name="cost_price" min="0" step="0.01"
                                       value="{{ old('cost_price', $product->cost_price) }}" required>
                                @error('cost_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="selling_price" class="form-label fw-semibold">Selling Price (BWP) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">P</span>
                                <input type="number" class="form-control @error('selling_price') is-invalid @enderror"
                                       id="selling_price" name="selling_price" min="0" step="0.01"
                                       value="{{ old('selling_price', $product->selling_price) }}" required>
                                @error('selling_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inventory --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white p-4">
                    <h2 class="h5 fw-bold mb-1">Inventory Settings</h2>
                    <p class="small text-muted mb-0">Update the available quantity and low-stock alert.</p>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label for="quantity_in_stock" class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_in_stock') is-invalid @enderror"
                                   id="quantity_in_stock" name="quantity_in_stock"
                                   min="0" step="0.001"
                                   value="{{ old('quantity_in_stock', $product->quantity_in_stock) }}" required>
                            @error('quantity_in_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="low_stock_threshold" class="form-label fw-semibold">Low Stock Alert At <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                   id="low_stock_threshold" name="low_stock_threshold"
                                   min="0" step="0.001"
                                   value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required>
                            @error('low_stock_threshold')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="unit_of_measure" class="form-label fw-semibold">Unit of Measure <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('unit_of_measure') is-invalid @enderror"
                                   id="unit_of_measure" name="unit_of_measure"
                                   maxlength="30"
                                   value="{{ old('unit_of_measure', $product->unit_of_measure) }}" required>
                            @error('unit_of_measure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-end flex-wrap gap-2 mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>