<?php

namespace Tests\Feature\Auth;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserRegistered;
use App\Models\User;
use App\Notifications\User\RegistrationConfirmation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\ApiTestCase;
use Tests\Utils\Database\Seeder;

class RegisterTest extends ApiTestCase
{
    const REGISTER_URL = '/register';
    use WithFaker;

    private function register(string $firstName, string $lastName, string $email, string $password)
    {
        return $this->postJson(self::REGISTER_URL, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
        ]);
    }

    protected function setUp() : void
    {
        parent::setUp();
    }


    public function test_user_can_register()
    {
        Event::fake();
        Seeder::seed();
        // wrong email format will fail

        $response = $this->register('laksa', 'laa', 'laksa', 'Secretsecret123!!!!');
        $response->assertStatus(422);

        $response = $this->register('laksa', 'laa', 'laksa@kolok.ko', 'Secretsecret123!!!!');

        $response->assertStatus(200);

        Event::assertDispatched(UserRegistered::class);
        Event::assertDispatched(UserCreated::class);
    }

    public function test_cant_register_with_existing_username()
    {
        Event::fake();

        $user = $this->createUser();

        $response = $this->register('laksa', 'laa', $user->email, 'Secretsecret123!!!!');
        $response->assertStatus(422);
    }

    public function test_password_must_follow_rules()
    {
        Event::fake();
        $response = $this
            ->register('laksa', 'laa', 'alalala@alala.coa', '123')
            ->assertStatus(422);

        $response = $this
            ->register('laksa', 'laa', 'alalala@alala.coa', 'aa123')
            ->assertStatus(422);
        $response = $this
            ->register('laksa', 'laa', 'alalala@alala.coa', 'aa123AA')
            ->assertStatus(422);


        $response = $this
            ->register('laksa', 'laa', 'alalala@alala.coa', 'aa123AA!@$#')
            ->assertStatus(200);
    }

    public function test_confirmation_email_is_sent_once_registered()
    {
        Notification::fake();
        $email = $this->faker->email;
        // register user
        $response = $this->register('lak', 'sa', $email, 'Seaca122@!@');
        $user = User::query()->where('email', '=', $email)->first();

        Notification::assertSentTo($user, RegistrationConfirmation::class);
    }
}