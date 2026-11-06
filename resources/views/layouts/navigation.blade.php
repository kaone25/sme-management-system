```blade
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-3 px-md-4">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <span class="text-info">SM</span> Business Manager
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Dashboard: owner and staff --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}"
                       href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                {{-- Management links: owner only --}}
                @if (Auth::user()->role === 'owner')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('products.index') }}">
                            Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sales.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('sales.index') }}">
                            Sales
                        </a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('staff.index') ? 'active fw-semibold' : '' }}"
       href="{{ route('staff.index') }}">
        Manage Staff
    </a>
</li>
@endrole

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customers.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('customers.index') }}">
                            Customers
                        </a>
                    </li>

                                        <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('expenses.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('expenses.index') }}">
                            Expenses
                        </a>
                    </li>

                    {{-- Staff registration: owner only --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('staff.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('staff.create') }}">
                            Register Staff
                        </a>
                    </li>

                @endif

                {{-- Reports: owner and staff --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active fw-semibold' : '' }}"
                       href="#"
                       id="reportsDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Reports
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('reports.sales') }}">
                                Sales Report
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('reports.inventory') }}">
                                Inventory Report
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            {{-- Account menu --}}
            <div class="dropdown">
                <button
                    class="btn btn-outline-light dropdown-toggle"
                    type="button"
                    id="accountDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="accountDropdown">
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
    </div>
</nav>
