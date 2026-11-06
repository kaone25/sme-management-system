
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Customer</h2>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            Back to Customers
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('customers.store') }}" method="POST">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div class="mb-3">
                    <label for="customer_number" class="form-label">
                        Customer Number
                    </label>
                    <input type="text" class="form-control"
                           id="customer_number" name="customer_number"
                           placeholder="e.g. CUST-001">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control"
                           id="name" name="name"
                           placeholder="Enter customer's full name">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control"
                           id="phone" name="phone"
                           placeholder="Enter phone number">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control"
                           id="email" name="email"
                           placeholder="Enter email address">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control"
                              id="address" name="address"
                              rows="3"
                              placeholder="Enter customer's address"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Customer
                </button>

                <a href="{{ route('customers.index') }}"
                   class="btn btn-outline-secondary">
                    Cancel
                </a>
            </form>

        </div>
    </div>

</div>

</body>
</html>
