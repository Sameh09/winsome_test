@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" enctype="multipart/form-data"
        action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}">
        @csrf
        @if(isset($employee)) @method('PUT') @endif
        <!-- Input fields: name, email, phone, position, salary, hired_at, status -->
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $employee->name ?? '') }}" class="form-control"
                required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <!-- Repeat for other fields -->
        <div class="mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
            @if(isset($employee) && $employee->photo)
            <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" width="60" class="mt-2">
            @endif
            @error('photo')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <button class="btn btn-primary">{{ isset($employee) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection