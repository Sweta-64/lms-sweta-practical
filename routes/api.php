<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

Route::middleware('auth:sanctum')->group(function () {
    // User Info
    Route::get('/user', function (Request $request) {
        return response()->json($request->user(), 200);
    });

    // My Leaves
    Route::prefix('leaves')->group(function () {
        Route::get('/', [LeaveController::class, 'apiMyLeaves']);
        Route::post('/', [LeaveController::class, 'apiStore']);
    });

    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::prefix('admin/leaves')->group(function () {
            Route::get('/', [LeaveController::class, 'apiAllLeaves']);
            Route::get('/pending', [LeaveController::class, 'apiPendingLeaves']);
            Route::post('{leave}/approve', [LeaveController::class, 'apiApprove']);
            Route::post('{leave}/reject', [LeaveController::class, 'apiReject']);
        });
    });
});
