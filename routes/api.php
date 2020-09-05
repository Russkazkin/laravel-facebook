<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function (){
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::resources([
        'posts' => 'PostController',
        'users' => 'UserController',
        'users/{user}/posts' => 'UserPostController',
    ]);
});
