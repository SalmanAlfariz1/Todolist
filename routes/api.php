<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ChecklistController;

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

/**
 * Checklist routes
 * Items routes
 */
Route::middleware('auth:api')->group(function () {
    Route::post('/checklists', [ChecklistController::class, 'store']);
    Route::delete('/checklists/{id}', [ChecklistController::class, 'destroy']);
    Route::get('/checklists', [ChecklistController::class, 'index']);
    Route::get('/checklists/{id}', [ChecklistController::class, 'show']);

    Route::post('/checklists/{checklistId}/items', [ItemController::class, 'store']);
    Route::get('/items/{id}', [ItemController::class, 'show']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::patch('/items/{id}/toggle', [ItemController::class, 'toggleStatus']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
});

