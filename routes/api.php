<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/test', function () {
    return response()->json(['message' => 'API OK!']);
});

Route::post('/employees/import', [\App\Http\Controllers\EmployeeController::class, 'import']);
