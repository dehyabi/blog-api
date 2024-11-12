<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});

Route::middleware('token.login')->group(function () {
    Route::get('/protected-route', function () {
        return response()->json(['message' => 'You are authenticated!']);
    });
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    Route::get('/users', function () {
        return response()->json(User::all());
    });
    Route::get('/posts', function () {
        return response()->json(Post::all());
    });
});