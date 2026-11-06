
<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-dark">Customer Management</h2>
    </x-slot>

    <div class="container-fluid px-0">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-4">
                <div class="d-flex flex-column flex-md-row
                            justify-content-between align-items-md-center gap-3">
                    <div>
                        <h3 class="h5 mb-1">Customers</h3>
                        <p class="text-muted mb-0">
                            Manage your business customers and their contact details.
                        </p>
                    </div>

                    <a href="{{ route('customers.create') }}"
                       class="btn btn-primary">
                        + Add Customer
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                @endif

                @if($customers->isEmpty())
                    <div class="text-center py-5">
                        <h5 class="text-muted">No customers yet</h5>
                        <p class="text-muted mb-3">
                            Add your first customer to get started.
                        </p>
                        <a href="{{ route('customers.create') }}"
                           class="btn btn-primary">
                            + Add First Customer
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="py-3">Customer Number</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Address</th>
                                    <th class="py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->customer_number }}</td>
                                        <td class="fw-semibold">
                                            {{ $customer->name }}
                                        </td>
                                        <td>{{ $customer->phone ?: '—' }}</td>
                                        <td>{{ $customer->email ?: '—' }}</td>
                                        <td>{{ $customer->address ?: '—' }}</td>
                                        <td class="text-end text-nowrap">
                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Edit
                                            </a>

                                            <form action="{{ route('customers.destroy', $customer->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            </form>
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
