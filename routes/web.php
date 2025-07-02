<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('employees.index');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::resource('/employees', EmployeeController::class);
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{employee}/update', [EmployeeController::class, 'update'])->name('employees.update');
        Route::get('/{employee}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::get('/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
        Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
        Route::delete('/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('employees.bulk-delete');

        Route::get('/export/csv', [EmployeeController::class, 'exportCsv'])->name('employees.export.csv');
        Route::get('/export/pdf', [EmployeeController::class, 'exportPdf'])->name('employees.export.pdf');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
