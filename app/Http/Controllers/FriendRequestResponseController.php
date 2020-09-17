<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendRequestResponseController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'user_id' => '',
            'status' => ''
        ]);

        $friendRequest = Friend::where(['user_id' => $data['user_id'], 'friend_id' => auth()->user()->id])->firstOrFail();

        $friendRequest->update(array_merge($data, ['confirmed_at' => now()]));
    }
}
