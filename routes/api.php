<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\MoviesController;
use \App\Http\Controllers\Api\CategoriesController;
use \App\Http\Controllers\Api\LoginController;
use \App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::ApiResource('/movies', MoviesController::class);
    Route::ApiResource('/categories', CategoriesController::class);
});

Route::post('/login', [LoginController::class, 'store']);
Route::post('/register', [UserController::class, 'store']);
