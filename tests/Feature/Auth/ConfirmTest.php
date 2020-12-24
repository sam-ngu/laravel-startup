<?php

namespace Tests\Feature\Auth;

use Tests\ApiTestCase;
use Tests\Utils\Traits\WithRegistration;

class ConfirmTest extends ApiTestCase
{
    const CONFIRM_URL = '/confirm';

    use WithRegistration;

    private function confirmUrl()
    {
    }

    private function confirm()
    {
        $this->postJson();
    }
}
