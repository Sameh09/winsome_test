<?php
use App\Http\Controllers\Api\EmployeeApiController;
use Illuminate\Support\Facades\Route;


Route::prefix('api/employees')->group(function () {
    Route::get('/', [EmployeeApiController::class, 'index']);
    Route::get('/{employee}', [EmployeeApiController::class, 'show']);
    Route::post('/', [EmployeeApiController::class, 'store']);
    Route::put('/{employee}', [EmployeeApiController::class, 'update']);
    Route::delete('/{employee}', [EmployeeApiController::class, 'destroy']);
});