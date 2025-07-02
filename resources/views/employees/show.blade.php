@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employee Details</h1>

    <div class="mb-3">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
    </div>

    <div class="row">
        {{-- Photo --}}
        <div class="col-md-3 mb-3">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" class="img-thumbnail w-100">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=ccc&color=333&rounded=true" alt="Avatar" class="img-thumbnail w-100">
            @endif
        </div>

        {{-- Details --}}
        <div class="col-md-9">
            <div class="mb-2"><strong>Name:</strong> {{ $employee->name }}</div>
            <div class="mb-2"><strong>Email:</strong> {{ $employee->email }}</div>
            <div class="mb-2"><strong>Phone:</strong> {{ $employee->phone ?? '-' }}</div>
            <div class="mb-2"><strong>Position:</strong> {{ $employee->position }}</div>
            <div class="mb-2"><strong>Salary:</strong> ${{ number_format($employee->salary, 2) }}</div>
            <div class="mb-2"><strong>Hired At:</strong> {{ $employee->hired_at->format('Y-m-d') }}</div>
            <div class="mb-2">
                <strong>Status:</strong>
                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($employee->status) }}
                </span>
            </div>
            <div class="mb-2"><strong>Department:</strong> {{ $employee->department->name ?? '-' }}</div>
        </div>
    </div>
</div>
@endsection
