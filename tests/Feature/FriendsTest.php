<?php

namespace Tests\Feature;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FriendsTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function a_user_can_send_a_friend_request()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ]);

        $response->assertStatus(200);

        $friendRequest = Friend::first();

        $this->assertNotNull($friendRequest);
        $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
        $this->assertEquals($user->id, $friendRequest->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => null,
                ],
            ],
            'links' => [
                'self' => '/users/' . $anotherUser->id,
            ],
        ]);
    }

    /** @test  */
    public function only_valid_users_can_be_friend_requested()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 123,
        ]);

        $response->assertStatus(404);

        $this->assertNull(Friend::first());

        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'User Not Found',
                'detail' => 'Unable to locate the user with the given information.',
            ],
        ]);
    }

    /** @test  */
    public function friend_request_can_be_accepted()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);;

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id' => $user->id,
                'status' => 1,
            ]);

        $response->assertStatus(200);

        $friendRequest = Friend::first();

        $this->assertNotNull($friendRequest->confirmed_at);

        $this->assertEquals(now(), $friendRequest->confirmed_at);
        $this->assertEquals(1, $friendRequest->status);
    }
}
