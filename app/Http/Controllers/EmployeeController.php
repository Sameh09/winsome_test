<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $cacheKey = 'employees_' . md5(json_encode($request->all()));

        $employees = Cache::remember($cacheKey, 60, function () use ($request) {
            return Employee::with('department')
                ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->when($request->status, fn($q) => $q->where('status', $request->status))
                ->when($request->hire_date, fn($q) => $q->whereDate('hired_at', $request->hire_date))
                ->orderByDesc('id')
                ->cursorPaginate(10);
        });

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Employee::create($data);
        Cache::flush();
        return redirect()->route('employees.index')->with('success', 'Employee created');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($employee->photo) Storage::disk('public')->delete($employee->photo);
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $employee->update($data);
        Cache::flush();
        return redirect()->route('employees.index')->with('success', 'Employee updated');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        Cache::flush();
        return back()->with('success', 'Employee soft deleted');
    }

    public function restore($id)
    {
        Employee::withTrashed()->findOrFail($id)->restore();
        Cache::flush();
        return back()->with('success', 'Employee restored');
    }

    public function exportCsv(Request $request)
    {
        $employees = Employee::with('department')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->hire_date, fn($q) => $q->whereDate('hired_at', $request->hire_date))
            ->orderByDesc('id')
            ->take(100) 
            ->get();
        $filename = 'employees.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name', 'Email', 'Phone', 'Department', 'Salary']);

        foreach ($employees as $emp) {
            fputcsv($handle, [$emp->name, $emp->email, $emp->phone, $emp->department->name ?? '', $emp->salary]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function exportPdf(Request $request)
    {
        $employees = Employee::with('department')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->hire_date, fn($q) => $q->whereDate('hired_at', $request->hire_date))
            ->orderByDesc('id')
            ->take(100) 
            ->get();
        $pdf = Pdf::loadView('employees.pdf', compact('employees'));
        return $pdf->download('employees.pdf');
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        Employee::whereIn('id', $ids)->delete();
        Cache::flush();
        return back()->with('success', count($ids) . ' employees deleted');
    }
}
