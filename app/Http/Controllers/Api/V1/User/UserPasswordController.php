<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Password\UpdatePasswordRequest;
use App\Models\User;

class UserPasswordController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        // check old password and new password

        // validate password -- eg has num, has symbol, has upper and lower case

        // check for expiry
        return '';
    }
}
