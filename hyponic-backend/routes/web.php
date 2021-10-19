<?php

use App\Http\Controllers\WebArticleController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function() {
    return redirect('/articles');
});

Route::resource('articles', 'WebArticleController');
Route::resource('article-categories', 'WebArticleCategoryController');

Route::resource('videos', 'WebVideoController');
Route::resource('video-categories', 'WebVideoCategoryController');

// Route::get('/articles', [ArticleController::class, 'index']);
// Route::get('/articles/{article}', [ArticleController::class, 'show']);

// Route::get('/articles/create', function() {
//     return "halo";
// });
// Route::post('/articles', [ArticleController::class, 'store']);

// Route::get('/articles/edit/{article}', [ArticleController::class, 'edit']);
// Route::post('/articles/edit/{article}', [ArticleController::class, 'update']);

// Route::get('/articles/delete/{article}', [ArticleController::class, 'destroy']);