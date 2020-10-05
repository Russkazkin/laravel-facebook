<?php

namespace Tests\Feature;

use App\Models\Friend;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrievePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_retrieve_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create(['user_id' => $anotherUser->id]);

        Friend::create([
            'user_id' => $user->id,
            'friend_id' => $anotherUser->id,
            'status' => 1,
            'confirmed_at' => now(),
        ]);

        $response = $this->get('/api/posts');

        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'posts',
                        'post_id' => $posts->last()->id,
                        'attributes' => [
                            'body' => $posts->last()->body,
                            'image' => $posts->last()->image,
                            'posted_at' => $posts->last()->created_at->diffForHumans(),
                        ]
                    ],
                ],
                [
                    'data' => [
                        'type' => 'posts',
                        'post_id' => $posts->first()->id,
                        'attributes' => [
                            'body' => $posts->first()->body,
                            'image' => $posts->first()->image,
                            'posted_at' => $posts->first()->created_at->diffForHumans(),
                        ]
                    ],
                ],
            ],
            'links' => [
                'self' => url('/posts'),
            ]
        ]);
    }

    /** @test */
    public function a_users_can_only_retrieve_their_posts()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $post = factory(Post::class)->make();
        factory(User::class)->create()->posts()->save($post);

        $response = $this->get('/api/posts');

        $response->assertStatus(200)->assertExactJson([
            'data' => [],
            'links' => [
                'self' => url('/posts'),
            ],
        ]);
    }
}
