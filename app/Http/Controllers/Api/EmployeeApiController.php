<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Validator;

class EmployeeApiController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Employee list fetched successfully',
            'data' => EmployeeResource::collection($employees),
            'meta' => [
                'current_page' => $employees->currentPage(),
                'next_page_url' => $employees->nextPageUrl(),
                'last_page' => $employees->lastPage(),
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
            ],
        ]);
    }


    public function show(Employee $employee)
    {
        $employee->load('department');
        return response()->json([
            'success' => true,
            'data' => new EmployeeResource($employee),
            'message' => 'Employee details fetched'
        ]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string|max:15',
            'position' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'hired_at' => 'required|date',
            'status' => 'required|in:active,inactive',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $employee = Employee::create($validated->validated());

        return response()->json([
            'success' => true,
            'data' => new EmployeeResource($employee),
            'message' => 'Employee created successfully'
        ], 201);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => "required|email|unique:employees,email,{$employee->id}",
            'phone' => 'nullable|string|max:15',
            'position' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'hired_at' => 'required|date',
            'status' => 'required|in:active,inactive',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $employee->update($validated->validated());

        return response()->json([
            'success' => true,
            'data' => new EmployeeResource($employee),
            'message' => 'Employee updated successfully'
        ]);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully'
        ]);
    }
}
