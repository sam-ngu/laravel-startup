<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client;

class PassportClient extends Client
{
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }
}
