<?php

namespace Tests\Feature\Api\V1\User\Profile;

use Tests\ApiTestCase;

class UserChangePictureTest extends ApiTestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
