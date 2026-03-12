<?php

use App\Http\Controllers\Api\ImageTranslateController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ProgressController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);


    // courses (auth users)
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);

    // courses (admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{id}', [CourseController::class, 'update']);
        Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
    });


    // lessons (auth users)
    Route::get('/courses/{courseId}/lessons', [LessonController::class, 'index']);

    // lessons (admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/lessons', [LessonController::class, 'store']);
    });


    // tasks (auth users)
    Route::get('/lessons/{lessonId}/tasks', [TaskController::class, 'index']);

    // tasks (admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::patch('/tasks/{id}', [TaskController::class, 'update']);
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    });


    // progress routes (auth users)
    Route::get('/progress', [ProgressController::class, 'index']);
    Route::get('/progress/chart', [ProgressController::class, 'chart']);
    Route::post('/progress', [ProgressController::class, 'store']);

});