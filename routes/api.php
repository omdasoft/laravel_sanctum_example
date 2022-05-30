<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;
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
//signup and login routes
Route::post('/signup', [AuthController::class, 'sign_up']);
Route::post('/login', [AuthController::class, 'login']);

//public post route
Route::get('/posts/search/{title}', [PostController::class, 'search']);
Route::get('/post/{id}/author', [PostController::class, 'getAuthor']);

//public author route
Route::get('/author/{id}/posts', [AuthorController::class, 'getPosts']);

//private posts and authors routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    //posts
    Route::apiResource('posts', PostController::class);
    //authors
    Route::apiResource('authors', AuthorController::class);
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
});


