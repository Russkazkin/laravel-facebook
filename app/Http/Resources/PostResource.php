<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Post $this */

        return [
            'data' => [
                'type' => 'posts',
                'post_id' => $this->id,
                'attributes' => [
                    'posted_by' => new UserResource($this->user),
                    'likes' => new LikeResourceCollection($this->likes),
                    'comments' => new CommentResourceCollection($this->comments),
                    'body' => $this->body,
                    'image' => $this->image,
                    'posted_at' => $this->created_at->diffForHumans(),
                ],
            ],
            'links' => [
                'self' => url('/posts/' . $this->id),
            ],
        ];
    }
}
