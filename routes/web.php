```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;

// Public homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// All business pages require login
Route::middleware('auth')->group(function () {

    // Dashboard: owner and staff
    Route::middleware('role:owner,staff')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Sales reports: owner and staff
        Route::get('/reports/sales', [SalesReportController::class, 'index'])
            ->name('reports.sales');

        Route::get('/reports/sales/export', [SalesReportController::class, 'export'])
            ->name('reports.sales.export');

        // Inventory reports and low-stock information: owner and staff
        Route::get('/reports/inventory', [InventoryReportController::class, 'index'])
            ->name('reports.inventory');

        Route::get('/reports/inventory/export', [InventoryReportController::class, 'export'])
            ->name('reports.inventory.export');

                // Sales: owner and staff
        Route::get('/sales', [SaleController::class, 'index'])
            ->name('sales.index');

        Route::get('/sales/create', [SaleController::class, 'create'])
            ->name('sales.create');

        Route::post('/sales', [SaleController::class, 'store'])
            ->name('sales.store');

        Route::get('/sales/{sale}', [SaleController::class, 'show'])
            ->name('sales.show');
    });

    // Management features: owner only
    Route::middleware('role:owner')->group(function () {

    // Staff management
    Route::get('/staff', [StaffController::class, 'index'])
        ->name('staff.index');

    Route::get('/staff/create', [StaffController::class, 'create'])
        ->name('staff.create');

    Route::post('/staff', [StaffController::class, 'store'])
        ->name('staff.store');

    Route::delete('/staff/{user}', [StaffController::class, 'destroy'])
        ->name('staff.destroy');

        // Products
        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');


        // Expenses
        Route::get('/expenses', [ExpenseController::class, 'index'])
            ->name('expenses.index');

        Route::get('/expenses/create', function () {
            return view('expenses.create');
        })->name('expenses.create');

        Route::post('/expenses', [ExpenseController::class, 'store'])
            ->name('expenses.store');

        Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])
            ->name('expenses.edit');

        Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])
            ->name('expenses.update');

        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])
            ->name('expenses.destroy');

        // Customers
        Route::get('/customers', [CustomerController::class, 'index'])
            ->name('customers.index');

        Route::get('/customers/create', [CustomerController::class, 'create'])
            ->name('customers.create');

        Route::post('/customers', [CustomerController::class, 'store'])
            ->name('customers.store');

        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
            ->name('customers.edit');

        Route::put('/customers/{customer}', [CustomerController::class, 'update'])
            ->name('customers.update');

        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
            ->name('customers.destroy');
    });

    // User profile: any authenticated user
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Breeze login, registration, password reset and logout routes
require __DIR__.'/auth.php';
