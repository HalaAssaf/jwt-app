<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'index');
    Route::post('category', 'store');
    Route::get('category/{id}', 'show');
    Route::put('category/{id}', 'update');
    Route::delete('category/{id}', 'destroy');
}); 

Route::controller(PostController::class)->group(function () {
    Route::post('post', 'store');
    Route::get('post/{id}', 'show');
    Route::put('post/{id}', 'update');
    Route::delete('post/{id}', 'destroy');
}); 
Route::controller(CommentController::class)->group(function () {
    Route::get('posts/{postId}/comments', 'index');
    Route::post('comment', 'store');
    Route::get('comment/{id}', 'show');
    Route::put('comment/{id}', 'update');
    Route::delete('comment/{id}', 'destroy');
}); 



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
