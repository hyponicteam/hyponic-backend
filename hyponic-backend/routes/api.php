<?php

use App\Http\Controllers\API\ArticleCategoryController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DailyActivityController;
use App\Http\Controllers\API\DayController;
use App\Http\Controllers\API\GrowthController;
use App\Http\Controllers\API\PlantaController;
use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\TodoController;
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

// Route::get('/articles', [ArticleController::class, 'index']);
// Route::get('/articles/{article}', [ArticleController::class, 'show']);

// Route::get('/article-categories', [ArticleCategoryController::class, 'index']);
// Route::get('/article-categories/{article_category}', [ArticleCategoryController::class, 'show']);

// Route::get('/videos', [VideoController::class, 'index']);
// Route::get('/videos/{video}', [VideoController::class, 'show']);

// Route::get('/video-categories', [VideoCategoryController::class, 'index']);
// Route::get('/video-categories/{video_category}', [VideoCategoryController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    Route::get('/plants', [PlantController::class, 'index']);
    Route::get('/plants/{plant}', [PlantController::class, 'show']);
    Route::post('/plants', [PlantController::class, 'store']);
    Route::patch('/plants/{plant}', [PlantController::class, 'update']);
    Route::delete('/plants/{plant}', [PlantController::class, 'destroy']);
    
    Route::get('/latest-plants', [PlantController::class, 'latest']);
    Route::get('/top-plants', [PlantController::class, 'top']);

    Route::get('/growths/{growth}', [GrowthController::class, 'show']);
    Route::post('/growths/', [GrowthController::class, 'store']);
    Route::patch('/growths/{growth}', [GrowthController::class, 'update']);
    Route::delete('/growths/{growth}', [GrowthController::class, 'destroy']);
    
    Route::get('/top-growths', [GrowthController::class, 'top']);

    // Route::post('/articles', [ArticleController::class, 'store']);
    // Route::patch('/articles/{article}', [ArticleController::class, 'update']);
    // Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
    
    // Route::post('/article-categories', [ArticleCategoryController::class, 'store']);
    // Route::patch('/article-categories/{article_category}', [ArticleCategoryController::class, 'update']);
    // Route::delete('/article-categories/{article_category}', [ArticleCategoryController::class, 'destroy']);
    
    // Route::post('/videos', [VideoController::class, 'store']);
    // Route::patch('/videos/{video}', [VideoController::class, 'update']);
    // Route::delete('/videos/{video}', [VideoController::class, 'destroy']);

    // Route::post('/video-categories', [VideoCategoryController::class, 'store']);
    // Route::patch('/video-categories/{video_category}', [VideoCategoryController::class, 'update']);
    // Route::delete('/video-categories/{video_category}', [VideoCategoryController::class, 'destroy']);

    // Route::get('/plantas', [PlantaController::class, 'index']);
    // Route::get('/plantas/{planta}', [PlantaController::class, 'show']);
    // Route::post('/plantas', [PlantaController::class, 'store']);
    // Route::patch('/plantas/{planta}', [PlantaController::class, 'update']);
    // Route::delete('/plantas/{planta}', [PlantaController::class, 'destroy']);

    // Route::get('/days', [DayController::class, 'index']);
    // Route::get('/days/{day}', [DayController::class, 'show']);
    // Route::post('/days', [DayController::class, 'store']);
    // Route::patch('/days/{day}', [DayController::class, 'update']);
    // Route::delete('/days/{day}', [DayController::class, 'destroy']);

    // Route::get('/todos', [TodoController::class, 'index']);
    // Route::get('/todos/{todo}', [TodoController::class, 'show']);
    // Route::post('/todos', [TodoController::class, 'store']);
    // Route::patch('/todos/{todo}', [TodoController::class, 'update']);
    // Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);

    // Route::get('/daily-activities', [DailyActivityController::class, 'index']);
    // Route::get('/daily-activities/{id}', [DailyActivityController::class, 'show']);
    // Route::post('/daily-activities', [DailyActivityController::class, 'store']);
    // Route::patch('/daily-activities/{id}', [DailyActivityController::class, 'update']);
    // Route::patch('/daily-activities/check/{id}', [DailyActivityController::class, 'check']);
    // Route::delete('/daily-activities/{id}', [DailyActivityController::class, 'destroy']);
});