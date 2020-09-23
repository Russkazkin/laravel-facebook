<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Resources\FriendResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class FriendRequestController extends Controller
{
   public function store()
   {
       try {
           $data = request()->validate([
               'friend_id' => 'required',
           ]);
       } catch (ValidationException $e) {
           return response()->json([
               'errors' => [
                   'code' => 422,
                   'title' => 'Validation Error',
                   'detail' => 'Your request is malformed or missing fields.',
                   'meta' => $e->errors(),
               ],
           ], 422);
       }

       try {
           User::findOrFail($data['friend_id'])->friends()->attach(auth()->user());
       } catch (ModelNotFoundException $exception) {
           throw new UserNotFoundException();
       }

       return new FriendResource(Friend::where([
            'user_id' => auth()->user()->id,
            'friend_id' => $data['friend_id'],
            ])->first()
        );
   }
}
