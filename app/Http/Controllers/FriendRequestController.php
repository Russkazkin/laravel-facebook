<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
   public function store()
   {
        $data = request()->validate([
            'friend_id' => '',
        ]);

        User::find($data['friend_id'])->friends()->attach(auth()->user());
   }
}
