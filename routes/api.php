<?php

use App\Http\Controllers\API\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/questions', [QuestionController::class, 'index']);

Route::get('/questions/{id}', [QuestionController::class, 'show']);

Route::post('/questions', [QuestionController::class, 'store']);

Route::put('/questions/{id}', [QuestionController::class, 'update']);
Route::patch('/questions/{id}', [QuestionController::class, 'update']);

Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
