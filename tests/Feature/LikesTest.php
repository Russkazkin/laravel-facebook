<?php

use App\Models\Post;
use App\Models\User;

test('a_user_can_like_a_post', function () {
    /* @var \Tests\TestCase $this */

    $this->actingAs($user = factory(User::class)->create());
    $post = factory(Post::class)->create(['id' => 123]);
    $response = $this->post('/api/post/' . $post->id . '/like/');
    $response->assertOk();
    $this->assertCount(1, $user->likedPosts);
    $response->assertJson([
        'data' => [
            [
                'data' => [
                    'type' => 'likes',
                    'like_id' => 1,
                    'attributes' => [],
                ],
                'links' => [
                    'self' => url('/posts'),
                ]
            ]
        ],
        'links' => [
            'self' => url('/posts'),
        ]
    ]);
});
