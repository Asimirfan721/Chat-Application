<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/messages', [MessageController::class, 'sendMessage']);
    Route::get('/messages', [MessageController::class, 'getAllMessages']);
    Route::get('/messages/{user_id}', [MessageController::class, 'getUserMessages']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
