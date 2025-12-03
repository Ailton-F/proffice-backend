<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassPlanController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HighlightedLessonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware(['auth:sanctum'])->group(function(){
    Route::post('/', [UserController::class, 'store'])->withoutMiddleware(['auth:sanctum']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::post('/login', [UserController::class, 'authenticate'])->withoutMiddleware(['auth:sanctum']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::prefix('class-plans')->middleware(['auth:sanctum'])->group(function(){
    Route::post('/', [ClassPlanController::class, 'store']);
    Route::get('/{id}', [ClassPlanController::class, 'show']);
    Route::patch('/{id}', [ClassPlanController::class, 'update']);
    Route::delete('/{id}', [ClassPlanController::class, 'destroy']);
});

Route::prefix('events')->middleware(['auth:sanctum'])->group(function(){
    Route::post('/', [EventController::class, 'store']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::patch('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'destroy']);
});

Route::prefix('highlights')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/{id}', [HighlightedLessonController::class, 'show']);
    Route::post('/', [HighlightedLessonController::class, 'store']);
    Route::patch('/{id}', [HighlightedLessonController::class, 'update']);
    Route::delete('/{id}', [HighlightedLessonController::class, 'destroy']);
});

Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthController::class, 'authenticate']);
});