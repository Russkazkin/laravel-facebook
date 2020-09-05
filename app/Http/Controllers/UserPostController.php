<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function index(User $user)
    {
        return new PostResourceCollection($user->posts);
    }
}
