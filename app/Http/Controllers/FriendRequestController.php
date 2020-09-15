<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
   public function store()
   {
        $data = request()->validate([
            'friend_id' => '',
        ]);

        Friend::create($data);
   }
}
