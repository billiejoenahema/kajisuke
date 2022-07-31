<?php

use App\Http\Controllers\Api\ArchiveController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HouseworkController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Models\Category;
use App\Models\Housework;
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
    Route::get('/auth_user', UserController::class);
    // ユーザー情報
    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::patch('/profiles', [ProfileController::class, 'update']);

    // 定数
    Route::get('/consts', fn() => config('const'));

    // 家事
    Route::get('/houseworks', [HouseworkController::class, 'index'])->can('viewAny', Housework::class);
    Route::get('/houseworks/{housework}', [HouseworkController::class, 'show'])->can('view', Housework::class);
    Route::post('/houseworks', [HouseworkController::class, 'store'])->can('create', Housework::class);
    Route::patch('/houseworks/{housework}', [HouseworkController::class, 'update'])->can('update', Housework::class);
    Route::delete('/houseworks/{housework}', [HouseworkController::class, 'destroy'])->can('delete', Housework::class);

    // カテゴリ
    Route::get('/categories', [CategoryController::class, 'index'])->can('viewAny', Category::class);
    Route::post('/categories', [CategoryController::class, 'store'])->can('create', Category::class);
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->can('update', Category::class);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->can('delete', Category::class);

    // 履歴
    Route::get('/archives', [ArchiveController::class, 'index']);
    Route::post('/archives', [ArchiveController::class, 'store']);
    Route::patch('/archives/{archive}', [ArchiveController::class, 'update']);
    Route::delete('/archives/{archive}', [ArchiveController::class, 'destroy']);
});
