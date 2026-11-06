
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Small Business Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                Small Business Management System
            </a>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold">
                    Manage Your Business. Support Your Growth.
                </h1>

                <p class="lead text-secondary mt-3">
                    A central platform for small businesses to manage
                    products, sales, customers, expenses, and business
                    performance.
                </p>

                <a href="#features" class="btn btn-primary btn-lg mt-3">
                    Explore Features
                </a>
                <a href="{{ route('dashboard') }}"
   class="btn btn-dark btn-lg mt-3 ms-2">
    Business Dashboard
</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg mt-3 ms-2">
    Product Inventory
</a>

<a href="{{ route('expenses.index') }}" class="btn btn-primary btn-lg  mt-3  ms 2">
    Expense Management
</a>


<a href="{{ route('sales.index') }}" class="btn btn-success btn-lg mt-3 ms-2">
    Sales Management
</a>




            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-3">System Overview</h2>

                        <p class="text-secondary">
                            Your business management tools will be
                            available here.
                        </p>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Product and inventory management</li>
                            <li class="list-group-item">Sales tracking</li>
                            <li class="list-group-item">Customer records</li>
                            <li class="list-group-item">Expense management</li>
                            <li class="list-group-item">Reports and dashboards</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <section id="features" class="mt-5">
            <h2 class="h3 fw-bold mb-4">Core Features</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5">Inventory</h3>
                            <p class="text-secondary mb-0">
                                Organise products and monitor stock levels.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5">Sales and Expenses</h3>
                            <p class="text-secondary mb-0">
                                Record transactions and track business costs.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5">Business Reports</h3>
                            <p class="text-secondary mb-0">
                                Review business performance to support
                                informed decisions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-top py-3 mt-5">
        <div class="container text-center text-secondary">
            <small>Small Business Management and Growth Support System</small>
        </div>
    </footer>

</body>
</html>
