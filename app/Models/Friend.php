<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Friend
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Friend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Friend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Friend query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend whereUserId($value)
 */
class Friend extends Model
{
    protected $guarded = [];

    protected $dates = ['confirmed_at'];

    public static function friendship($userId)
    {
        return (new static())
            ->where(function ($query) use ($userId) {
                return $query->where([
                    'user_id' => auth()->user()->id,
                    'friend_id' => $userId,
                ]);
            })
            ->orWhere(function ($query) use ($userId) {
                return $query->where([
                    'user_id' => $userId,
                    'friend_id' => auth()->user()->id,
                ]);
            })->first();
    }

    public static function friendships()
    {
        return (new static())
            ->whereNotNull('confirmed_at')
            ->where(function($query){
                return $query->where('user_id', auth()->user()->id)->orWhere('friend_id', auth()->user()->id);
            })->get();
    }
}
