<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DspController;
use App\Http\Controllers\Api\SspController;
use App\Http\Controllers\Api\OrganisationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('dsp', DspController::class);
    Route::apiResource('ssp', SspController::class);
    Route::apiResource('organisation', OrganisationController::class);
});
