@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" enctype="multipart/form-data"  id="employee-form"
        action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}">
        @csrf
        @if(isset($employee)) @method('PUT') @endif

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $employee->name ?? '') }}" class="form-control" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}" class="form-control" required>
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="form-control">
            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Position --}}
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" id="position" value="{{ old('position', $employee->position ?? '') }}" class="form-control" required>
            @error('position')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Salary --}}
        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" name="salary" id="salary" step="0.01" min="0" value="{{ old('salary', $employee->salary ?? '') }}" class="form-control" required>
            @error('salary')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Hired At --}}
        <div class="mb-3">
            <label for="hired_at" class="form-label">Hired At</label>
            <input type="date" name="hired_at" id="hired_at" value="{{ old('hired_at', isset($employee) ? $employee->hired_at->format('Y-m-d') : '') }}" class="form-control" required>
            @error('hired_at')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ old('status', $employee->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $employee->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Department --}}
        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <select name="department_id" id="department_id" class="form-control" required>
                <option value="">-- Select Department --</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
                @endforeach
            </select>
            @error('department_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Photo --}}
        <div class="mb-3">
            <label for="photo" class="form-label d-block">Photo</label>
            @if(isset($employee) && $employee->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo"
                        class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @else
                <div class="mb-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(old('name', $employee->name ?? '')) }}&background=ccc&color=333&rounded=true"
                        alt="Avatar" class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            @error('photo')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
        </div>

        {{-- Submit --}}
        <button class="btn btn-primary" id="submit-btn">
            {{ isset($employee) ? 'Update' : 'Create' }}
        </button>
    </form>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('employee-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerText = 'Please wait...';
    });
</script>
@endpush