<x-app-layout>
    <div class="container-fluid px-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Manage Staff</h1>
                <p class="text-muted mb-0">
                    View and manage staff accounts for your business.
                </p>
            </div>

            <a href="{{ route('staff.create') }}" class="btn btn-primary">
                + Register Staff
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Date Registered</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($staff as $member)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $member->name }}
                                    </td>
                                    <td>{{ $member->email }}</td>
                                    <td>
                                        {{ $member->created_at?->format('d M Y') ?? 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        <form
                                            action="{{ route('staff.destroy', $member) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this staff account?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No staff accounts found. Register a staff member to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="text-muted small mt-3 mb-0">
                    Total staff accounts: {{ $staff->count() }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
