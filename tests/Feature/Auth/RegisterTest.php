<?php

namespace Tests\Feature\Auth;

use App\Events\Models\User\UserCreated;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\ApiTestCase;
use Tests\Utils\Database\WithSeeder;
use Tests\Utils\Traits\WithRegistration;

class RegisterTest extends ApiTestCase
{
    const REGISTER_URL = '/register';
    use WithFaker, WithRegistration, WithSeeder;

    protected function setUp() : void
    {
        parent::setUp();
    }


    public function test_user_can_register()
    {
        Event::fake();
        $this->seed();
        // wrong email format will fail

        $response = $this->register('laksa', 'laksa', 'Secretsecret123!!!!');
        $response->assertStatus(422);

        $response = $this->register('laksa', 'laksa@kolok.ko', 'Secretsecret123!!!!');

        $response->assertStatus(201);

        Event::assertDispatched(Registered::class);
        Event::assertDispatched(UserCreated::class);
    }

    public function test_cant_register_with_existing_username()
    {
        Event::fake();

        $user = $this->createUser();

        $response = $this->register('laksa', $user->email, 'Secretsecret123!!!!');
        $response->assertStatus(422);
    }

    public function test_password_must_follow_rules()
    {
        Event::fake();
        $response = $this
            ->register('laksa', $this->faker->email, '123')
            ->assertStatus(422);

        $response = $this
            ->register('laksa', $this->faker->email, 'aa123')
            ->assertStatus(422);
        $response = $this
            ->register('laksa', $this->faker->email, 'aa123AA')
            ->assertStatus(422);


        $response = $this
            ->register('laksa', $this->faker->email, 'aa123AA!@$#')
            ->assertStatus(201);
    }

    public function test_verify_email_is_sent_once_registered()
    {
        Notification::fake();
        $email = $this->faker->email;
        // register user
        $response = $this->register('lak',  $email, 'Seaca122@!@');
        $user = User::query()->where('email', '=', $email)->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
