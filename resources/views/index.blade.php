
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            Small Business Management System
        </a>
        <a href="/" class="btn btn-outline-light btn-sm">Home</a>
    </div>
</nav>

<main class="container py-5">
    <h1 class="fw-bold mb-2">Business Dashboard</h1>
    <p class="text-secondary mb-4">
        An overview of your business performance.
    </p>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Products</p>
                    <h2 class="display-6 fw-bold">{{ $totalProducts }}</h2>
                    <a href="{{ route('products.index') }}"
                       class="btn btn-outline-primary btn-sm">
                        View Products
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Sales Revenue</p>
                    <h2 class="display-6 fw-bold">
                        BWP {{ number_format((float) $totalSales, 2) }}
                    </h2>
                    <a href="{{ route('sales.index') }}"
                       class="btn btn-outline-success btn-sm">
                        View Sales
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Expenses</p>
                    <h2 class="display-6 fw-bold">
                        BWP {{ number_format((float) $totalExpenses, 2) }}
                    </h2>
                    <a href="{{ route('expenses.index') }}"
                       class="btn btn-outline-danger btn-sm">
                        View Expenses
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-white border-top py-3">
    <div class="container text-center text-secondary">
        <small>Small Business Management and Growth Support System</small>
    </div>
</footer>

</body>
</html>
