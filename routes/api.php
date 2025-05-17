<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\TestQuestionController;
use App\Http\Controllers\API\HistoryTestController;
use App\Http\Controllers\API\HistoryTestQuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/tests', [TestController::class, 'index']);

    // Route::get('/tests/{test}', [TestController::class, 'show']);

    // Route::post('/tests', [TestController::class, 'store']);

    // Route::put('/tests/{test}', [TestController::class, 'update']);
    // Route::patch('/tests/{test}', [TestController::class, 'update']);

    // Route::delete('/tests/{test}', [TestController::class, 'destroy']);
    Route::apiResource('tests', TestController::class);
    Route::apiResource(
        'tests.questions',
        TestQuestionController::class
    )->scoped([
        'test'     => 'id',
        'question' => 'id',
    ])->parameters([
        'tests'     => 'test',
        'questions' => 'question'
    ]);

    Route::apiResource('user-tests', HistoryTestController::class)
        ->parameters(['user-tests' => 'history_test']);

    Route::apiResource('user-tests.questions', HistoryTestQuestionController::class)
        ->shallow()
        ->parameters(['user-tests' => 'history_test', 'questions' => 'question']);

    Route::get('/questions', [QuestionController::class, 'index']);

    Route::get('/questions/{id}', [QuestionController::class, 'show']);

    Route::post('/questions', [QuestionController::class, 'store']);

    Route::put('/questions/{id}', [QuestionController::class, 'update']);
    Route::patch('/questions/{id}', [QuestionController::class, 'update']);

    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
