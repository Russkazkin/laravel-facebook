<?php

use App\Models\Post;
use App\Models\User;

test('a_user_can_like_a_post', function () {
    /* @var \Tests\TestCase $this */

    $this->actingAs($user = factory(User::class)->create(), 'api');
    $anotherUser = factory(User::class)->create();
    $post = factory(Post::class)->create(['id' => 123, 'user_id' => $anotherUser->id]);

    $response = $this->post('/api/posts/' . $post->id . '/like/');
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
                    'self' => url('/posts/123'),
                ]
            ]
        ],
        'links' => [
            'self' => url('/posts'),
        ]
    ]);
});

test('posts_are_returned_with_likes', function () {
    /* @var \Tests\TestCase $this */

    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);
    $this->post('/api/posts/' . $post->id . '/like/');

    $response = $this->get('/api/posts');
    $response->assertOk();
    $response->assertJson([
        'data' => [
            [
                'data' => [
                    'type' => 'posts',
                    'attributes' => [
                        'likes' => [
                            'data' => [
                                [
                                    'data' => [
                                        'type' => 'likes',
                                        'like_id' => 1,
                                        'attributes' => [],
                                    ]
                                ]
                            ],
                            'like_count' => 1,
                            'user_likes_post' => true,
                        ],
                    ],
                ]
            ],
        ],
    ]);
});
