<?php

use App\Models\User;

it('a_friend_id_is_required_for_friend_requests', function (){

    $response = $this->actingAs($user = factory(User::class)->create(), 'api')
        ->post('/api/friend-request', [
            'friend_id' => '',
        ]);

    $response->assertStatus(422);

    $responseString = json_decode($response->getContent(), true);

    $this->assertArrayHasKey('friend_id', $responseString['errors']['meta']);
});
