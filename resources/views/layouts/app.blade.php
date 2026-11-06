
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Small Business Management System') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="sbm-app">

    <!-- Mobile navigation toggle -->
    <button class="btn btn-primary sbm-mobile-toggle d-lg-none"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sbmSidebar"
            aria-controls="sbmSidebar"
            aria-label="Open navigation">
        <span class="fs-4">&#9776;</span>
    </button>

    <!-- Sidebar -->
    <aside class="offcanvas-lg offcanvas-start sbm-sidebar"
           tabindex="-1"
           id="sbmSidebar"
           aria-labelledby="sbmSidebarLabel">

        <div class="sbm-brand">
            <div class="sbm-brand-icon">SM</div>
            <div>
                <div class="sbm-brand-name" id="sbmSidebarLabel">Business Manager</div>
                <div class="sbm-brand-caption">MANAGEMENT SYSTEM</div>
            </div>

            <button type="button"
                    class="btn-close btn-close-white d-lg-none ms-auto"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close navigation"></button>
        </div>

        <div class="sbm-nav-label">WORKSPACE</div>

        <nav class="sbm-nav">
            <a href="{{ route('dashboard') }}"
               class="sbm-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#9632;</span>
                <span>Dashboard</span>
            </a>
                @if (Auth::user()->role === 'owner')
            <a href="{{ route('products.index') }}"
               class="sbm-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#9638;</span>
                <span>Products & Inventory</span>
            </a>

            <a href="{{ route('sales.index') }}"
               class="sbm-nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#8644;</span>
                <span>Sales</span>
            </a>

            <a href="{{ route('customers.index') }}"
               class="sbm-nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#9787;</span>
                <span>Customers</span>
            </a>

            <a href="{{ route('expenses.index') }}"
               class="sbm-nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#8722;</span>
                <span>Expenses</span>
            </a>
  <a href="{{ route('staff.index') }}"
   class="sbm-nav-link {{ request()->routeIs('staff.index') ? 'active' : '' }}">
    <span class="sbm-nav-icon">&#128101;</span>
    <span>Manage Staff</span>
</a>          
<a href="{{ route('staff.create') }}"
   class="sbm-nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
    <span class="sbm-nav-icon">&#128100;</span>
    <span>Register Staff</span>
</a>

                        @endif
        </nav>

        <div class="sbm-nav-label mt-4">ANALYTICS</div>
                    

        <nav class="sbm-nav">
            <a href="{{ route('reports.sales') }}"
               class="sbm-nav-link {{ request()->routeIs('reports.sales*') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#9636;</span>
                <span>Sales Report</span>
            </a>

            <a href="{{ route('reports.inventory') }}"
               class="sbm-nav-link {{ request()->routeIs('reports.inventory*') ? 'active' : '' }}">
                <span class="sbm-nav-icon">&#9776;</span>
                <span>Inventory Report</span>
            </a>
        </nav>

        <div class="sbm-sidebar-footer">
            <div class="sbm-user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <div class="sbm-user-details">
                <div class="sbm-user-name">{{ Auth::user()->name }}</div>
                <div class="sbm-user-email">{{ Auth::user()->email }}</div>
            </div>

            <div class="dropdown">
                <button class="btn sbm-user-menu"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="Account options">
                    &#8942;
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            My Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Main workspace -->
    <div class="sbm-main">

        <header class="sbm-topbar">
            <div>
                <div class="sbm-topbar-title">
                    @isset($header)
                        {{ strip_tags($header) }}
                    @else
                        Business Overview
                    @endisset
                </div>
                <div class="sbm-topbar-subtitle">
                    Manage your business in one place
                </div>
            </div>

            <div class="sbm-topbar-status">
                <span class="sbm-status-dot"></span>
                System workspace
            </div>
        </header>

        <main class="sbm-content">
            {{ $slot }}
        </main>

        <footer class="sbm-footer">
            Small Business Management System
            <span>&copy; {{ date('Y') }}</span>
        </footer>

    </div>

</div>

@stack('scripts')

</body>
</html>

