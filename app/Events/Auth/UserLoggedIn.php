<?php

namespace App\Events\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserLoggedIn.
 */
class UserLoggedIn
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @param User|Authenticatable $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
