<?php

use App\Http\Controllers\API\ArticleCategoryController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\VideoCategoryController;
use App\Http\Controllers\API\VideoController;
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

Route::get('/videos', [VideoController::class, 'all']);
Route::get('/videos/categories', [VideoCategoryController::class, 'all']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::patch('/articles', [ArticleController::class, 'update']);
    Route::delete('/articles', [ArticleController::class, 'destroy']);
    
    Route::post('/articles/categories', [ArticleCategoryController::class, 'store']);
    Route::patch('/articles/categories', [ArticleCategoryController::class, 'update']);
    Route::delete('/articles/categories', [ArticleCategoryController::class, 'destroy']);
    
    Route::post('/videos', [VideoController::class, 'store']);
    Route::patch('/videos', [VideoController::class, 'update']);
    Route::delete('/videos', [VideoController::class, 'destroy']);

    Route::post('/videos/categories', [VideoCategoryController::class, 'store']);
    Route::patch('/videos/categories', [VideoCategoryController::class, 'update']);
    Route::delete('/videos/categories', [VideoCategoryController::class, 'destroy']);

    Route::get('/plants', [PlantController::class, 'index']);
    Route::get('/plants/{plant}', [PlantController::class, 'show']);
    Route::post('/plants', [PlantController::class, 'store']);
    Route::patch('/plants/{plant}', [PlantController::class, 'update']);
    Route::delete('/plants/{plant}', [PlantController::class, 'destroy']);
});

