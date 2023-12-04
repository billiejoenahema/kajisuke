<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\CookieAuthenticationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/login', [CookieAuthenticationController::class, 'login']);
Route::post('/logout', [CookieAuthenticationController::class, 'logout']);

Route::get('/{any?}', fn () => view('index'))->where('any', '.+');
