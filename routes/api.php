<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);

Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/post', PostController::class);
    Route::post('/comment', [CommentLikeController::class, 'storeComment']);
    Route::post('/like', [CommentLikeController::class, 'storeLike']);
});