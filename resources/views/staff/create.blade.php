
<x-app-layout>
    <div class="container-fluid px-4 px-lg-5 py-4">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <p class="text-uppercase small fw-semibold mb-2"
                   style="color: #0f766e; letter-spacing: 1.5px;">
                    USER MANAGEMENT
                </p>

                <h1 class="h2 fw-bold text-dark mb-2">Register Staff</h1>

                <p class="text-secondary mb-0">
                    Create a staff account for your business.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="btn btn-outline-secondary">
                Back to Dashboard
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-lg-8 col-xl-6">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 px-4 pt-4">
                        <h2 class="h5 fw-bold mb-1">Staff Account Details</h2>
                        <p class="small text-secondary mb-0">
                            Complete the fields below to create the account.
                        </p>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('staff.store') }}">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter staff member's full name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                >

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="staff@example.com"
                                    required
                                    autocomplete="email"
                                >

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    Temporary Password
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Create a strong password"
                                    required
                                    autocomplete="new-password"
                                >

                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Use a strong password that meets the application's password rules.
                                </div>
                            </div>

                            {{-- Confirm password --}}
                            <div class="mb-4">
                                <label for="password_confirmation"
                                       class="form-label fw-semibold">
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Re-enter the password"
                                    required
                                    autocomplete="new-password"
                                >
                            </div>

                            {{-- Role notice --}}
                            <div class="alert alert-info small mb-4">
                                <strong>Assigned role:</strong> Staff.
                                The system assigns this role automatically.
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-success fw-semibold">
                                    Create Staff Account
                                </button>

                                <a href="{{ route('dashboard') }}"
                                   class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
