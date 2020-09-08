<?php

namespace App\Models;

use Laravel\Passport\Client;

class PassportClient extends Client
{
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }
}
