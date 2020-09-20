<?php

namespace App\Http\Controllers;

use App\Exceptions\FriendRequestNotFoundException;
use App\Http\Resources\FriendResource;
use App\Models\Friend;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FriendRequestResponseController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'user_id' => '',
            'status' => ''
        ]);

        try {
            $friendRequest = Friend::where(['user_id' => $data['user_id'], 'friend_id' => auth()->user()->id])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new FriendRequestNotFoundException();
        }

        $friendRequest->update(array_merge($data, ['confirmed_at' => now()]));

        return new FriendResource($friendRequest);
    }
}