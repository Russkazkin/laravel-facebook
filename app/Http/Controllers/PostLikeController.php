<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResourceCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function store(Post $post)
    {
        $post->likes()->toggle(auth()->user());

        return new LikeResourceCollection($post->likes);
    }
}
