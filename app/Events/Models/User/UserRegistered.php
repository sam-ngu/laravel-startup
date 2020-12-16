<?php

namespace App\Events\Models\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserRegistered.
 */
class UserRegistered
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        event(new Registered($user));
    }
}
