<?php

namespace Tests\Feature\Api\V1\User;

use App\Events\Models\User\UserConfirmed;
use App\Events\Models\User\UserDeactivated;
use App\Events\Models\User\UserReactivated;
use App\Events\Models\User\UserUnconfirmed;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\ApiTestCase;

class UserConfirmedAndActiveTest extends ApiTestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginAsAdmin();
        Event::fake();
        $this->user = User::factory()->create([
            'confirmed' => false,
            'active' => false,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_states_can_be_confirmed()
    {
        // confirming user
        $response = $this->json('patch', '/api/v1/users/' . $this->user->id, [
            'confirmed' => true,
        ]);

        Event::assertDispatched(UserConfirmed::class);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(true, data_get($result, 'confirmed'));

        // unconfirming user
        $response = $this->json('patch', '/api/v1/users/' . $this->user->id, [
            'confirmed' => false,
        ]);

        Event::assertDispatched(UserUnconfirmed::class);

        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(false, data_get($result, 'confirmed'));
    }

    public function test_user_can_be_activated()
    {
        // activate user
        $response = $this->json('patch', '/api/v1/users/' . $this->user->id, [
            'active' => true,
        ]);
        Event::assertDispatched(UserReactivated::class);

        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(true, data_get($result, 'active'));

        // deactivate user
        $response = $this->json('patch', '/api/v1/users/' . $this->user->id, [
            'active' => false,
        ]);
        Event::assertDispatched(UserDeactivated::class);

        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(false, data_get($result, 'active'));
    }
}
