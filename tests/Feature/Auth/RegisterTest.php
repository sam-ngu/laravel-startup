<?php

namespace Tests\Feature\Auth;

use App\Events\Models\User\UserRegistered;
use Illuminate\Support\Facades\Event;
use Tests\ApiTestCase;
use Tests\Utils\Database\Seeder;

class RegisterTest extends ApiTestCase
{
    const REGISTER_URL = '/register';

    private function register(string $firstName, string $lastName, string $email, string $password)
    {
        return $this->postJson(self::REGISTER_URL, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password
        ]);
    }

    protected function setUp() : void
    {
        parent::setUp();
        Event::fake();
    }


    public function test_user_can_register()
    {
        Seeder::seed();
        // wrong email format will fail

        $response = $this->register('laksa', 'laa', 'laksa', 'Secretsecret123!!!!');
        $response->assertStatus(422);

        $response = $this->register('laksa', 'laa', 'laksa@kolok.ko', 'Secretsecret123!!!!');

        $response->assertStatus(200);

        Event::assertDispatched(UserRegistered::class);

    }

    public function test_cant_register_with_existing_username()
    {
        $user = $this->createUser();

        $response = $this->register('laksa', 'laa', $user->email, 'Secretsecret123!!!!');
        $response->assertStatus(422);
    }

    public function test_password_must_follow_rules()
    {
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
    }
}
