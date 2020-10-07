<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function (){

    Route::get('auth-user', 'AuthUserController@show');

    Route::apiResources([
        'posts' => 'PostController',
        '/posts/{post}/like' => 'PostLikeController',
        'users' => 'UserController',
        'users/{user}/posts' => 'UserPostController',
        'friend-request' => 'FriendRequestController',
        'friend-request-response' => 'FriendRequestResponseController',
    ]);
});
