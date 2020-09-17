<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function (){

    Route::get('auth-user', 'AuthUserController@show');

    Route::apiResources([
        'posts' => 'PostController',
        'users' => 'UserController',
        'users/{user}/posts' => 'UserPostController',
        'friend-request' => 'FriendRequestController',
        'friend-request-response' => 'FriendRequestResponseController',
    ]);
});
