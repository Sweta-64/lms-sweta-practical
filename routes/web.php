<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('leaves.index');
    }
    return redirect()->route('login');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Leave management routes
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('index');
        Route::get('create', [LeaveController::class, 'create'])->name('create');
        Route::post('/', [LeaveController::class, 'store'])->name('store');
        Route::get('{leave}', [LeaveController::class, 'show'])->name('show');
        Route::get('{leave}/edit', [LeaveController::class, 'edit'])->name('edit');
        Route::put('{leave}', [LeaveController::class, 'update'])->name('update');
        Route::delete('{leave}', [LeaveController::class, 'destroy'])->name('destroy');
    });

    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::post('leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    });
});

