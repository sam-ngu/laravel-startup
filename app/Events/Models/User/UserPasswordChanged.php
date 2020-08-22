<?php

namespace App\Events\Models\User;

use Illuminate\Queue\SerializesModels;

/**
 * Class UserPasswordChanged.
 */
class UserPasswordChanged
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
