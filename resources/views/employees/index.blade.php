@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employees</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="mb-3">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
        <a href="{{ route('employees.export.csv') }}" class="btn btn-secondary">Export CSV</a>
        <a href="{{ route('employees.export.pdf') }}" class="btn btn-secondary">Export PDF</a>
    </div>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="hire_date" value="{{ request('hire_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Status</th>
                <th>Hired At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
                <tr>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->department->name ?? '' }}</td>
                    <td><span class="badge bg-{{ $emp->status == 'active' ? 'success' : 'secondary' }}">{{ $emp->status }}</span></td>
                    <td>{{ $emp->hired_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $emp) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('employees.destroy', $emp) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this employee?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}
</div>
@endsection