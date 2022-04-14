<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HouseworkController;
use App\Http\Controllers\Api\HouseworkOrderController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    // ログインユーザー情報
    Route::get('/profile', ProfileController::class);
    // 家事
    Route::get('/houseworks', [HouseworkController::class, 'index']);
    // 家事表示順
    Route::get('/housework_orders', [HouseworkOrderController::class, 'index']);
    Route::patch('/housework_orders', [HouseworkOrderController::class, 'update']);
    // カテゴリ
    Route::get('/categories', [CategoryController::class, 'index']);
});
