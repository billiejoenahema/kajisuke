<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\HouseworkController;
use App\Http\Controllers\Api\ArchiveController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    // ログインユーザー
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'store']);
    Route::get('/profile/{profile}', [ProfileController::class, 'show']);
    Route::put('/profile/{profile}', [ProfileController::class, 'update']);
    Route::delete('/profile/{profile}', [ProfileController::class, 'delete']);
    // 家事
    Route::get('/houseworks', [HouseworkController::class, 'index']);
    Route::post('/houseworks', [HouseworkController::class, 'store']);
    Route::get('/houseworks/{housework}', [HouseworkController::class, 'show']);
    Route::put('/houseworks/{housework}', [HouseworkController::class, 'update']);
    Route::delete('/houseworks/{housework}', [HouseworkController::class, 'delete']);
    // 家事履歴
    Route::get('/archives', [ArchiveController::class, 'index']);
    Route::post('/archives', [ArchiveController::class, 'store']);
    Route::get('/archives/{archive}', [ArchiveController::class, 'show']);
    Route::put('/archives/{archive}', [ArchiveController::class, 'update']);
    Route::delete('/archives/{archive}', [ArchiveController::class, 'delete']);
    // カテゴリ
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'delete']);
});
