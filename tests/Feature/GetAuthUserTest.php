<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAuthUserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function authenticated_user_can_be_fetched ()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->get('/api/auth-user');

        $response->assertStatus(200)->assertJson([
            'data' => [
                'attributes' => [
                    'name' => $user->name,
                    'user_id' => $user->id,
                ],
            ],
            'links' => [
                'self' => url('/user/' . $user->id),
            ],
        ]);
    }
}
