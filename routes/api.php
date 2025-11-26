<?php

use App\Http\Controllers\Api\V1\HealthCheckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('health', HealthCheckController::class)->name('health');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', function (Request $request) {
            return response()->json([
                'data' => $request->user(),
            ]);
        })->name('me');
    });
});
