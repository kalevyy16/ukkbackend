<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\SavingController;
use App\Http\Controllers\Api\AccessoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user', [UserController::class, 'update']);
    Route::post('/onboarding', [UserController::class, 'onboarding']);

    Route::get('/incomes', [IncomeController::class, 'show']);
    Route::put('/incomes', [IncomeController::class, 'update']);

    Route::apiResource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('goals', GoalController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::post('/savings', [SavingController::class, 'store']);
    Route::get('/saving-histories', [SavingController::class, 'history']);
    Route::delete('/saving-histories/{history}', [SavingController::class, 'destroy']);

    Route::get('/accessories', [AccessoryController::class, 'index']);
    Route::post('/accessories/{accessory}/buy', [AccessoryController::class, 'buy']);
    Route::post('/accessories/{accessory}/equip', [AccessoryController::class, 'equip']);
    Route::post('/accessories/unequip', [AccessoryController::class, 'unequip']);
});