@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employees</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
        <a href="{{ route('employees.export.csv') }}" class="btn btn-secondary">Export CSV</a>
        <a href="{{ route('employees.export.pdf') }}" class="btn btn-secondary">Export PDF</a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Search by name">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="hire_date" value="{{ request('hire_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
        </div>
    </form>

    {{-- Bulk Delete Form --}}
    <form method="POST" action="{{ route('employees.bulk-delete') }}">
        @csrf
        @method('DELETE')

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Hired At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $emp->id }}"></td>
                    <td class="d-flex align-items-center gap-2">
                        @if($emp->photo)
                        <img src="{{ asset('storage/' . $emp->photo) }}" alt="Photo" class="rounded-circle border"
                            style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=ccc&color=333&rounded=true"
                            alt="Avatar" class="rounded-circle border"
                            style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                        <span>{{ $emp->name }}</span>
                    </td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->department->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $emp->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($emp->status) }}
                        </span>
                    </td>
                    <td>{{ $emp->hired_at->format('Y-m-d') }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('employees.edit', $emp) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('employees.destroy', $emp) }}" class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this employee?')">
                            Delete
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No employees found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Delete selected employees?')">
            Bulk Delete
        </button>
    </form>

    <div class="mt-4">
        {{ $employees->withQueryString()->links() }}
    </div>
</div>
@endsection