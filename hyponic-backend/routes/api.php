<?php

use App\Http\Controllers\API\ArticleCategoryController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/articles', [ArticleController::class, 'all']);
Route::get('/articles/categories', [ArticleCategoryController::class, 'all']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/articles', [ArticleController::class, 'store']);
    Route::patch('/articles', [ArticleController::class, 'update']);
    Route::delete('/articles', [ArticleController::class, 'destroy']);

    Route::post('/articles/categories', [ArticleCategoryController::class, 'store']);
    Route::patch('/articles/categories', [ArticleCategoryController::class, 'update']);
    Route::delete('/articles/categories', [ArticleCategoryController::class, 'destroy']);
});

