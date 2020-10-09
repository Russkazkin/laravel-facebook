<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('a_user_can_comment_on_a_post', function () {
    /* @var \Tests\TestCase $this */

    $this->withoutExceptionHandling();
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);

    $response = $this->post('/api/posts/' . $post->id . '/comment', [
        'body' => 'A great comment here'
    ]);
    $response->assertOk();

    $comment = Comment::first();

    $this->assertCount(1, Comment::all());
    $this->assertEquals($user->id, $comment->user_id);
    $this->assertEquals('A great comment here', $comment->body);
    $response->assertJson([
        'data' => [
            [
                'data' => [
                    'type' => 'comments',
                    'comment' => 1,
                    'attributes' => [
                        'commented_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name,
                                    'user_id' => $user->id,
                                ]
                            ]
                        ],
                        'body' => 'A great comment here',
                        'commented_at' => $comment->created_at->diffForHumans(),
                    ],
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
