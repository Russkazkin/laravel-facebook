<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function (){

    Route::get('auth-user', 'AuthUserController@show');
    Route::post('friend-request/{user}', 'FriendRequestController');

    Route::resources([
        'posts' => 'PostController',
        'users' => 'UserController',
        'users/{user}/posts' => 'UserPostController',
    ]);
});
