<?php

namespace App\Actions\Fortify;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginUser
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return false;
        }

        if (!Hash::check($request->password, $user->password)) {
            return false;
        }

        // check confirmed
        if (! $user->confirmed) {
            throw new GeneralJsonException('Unconfirmed account');
        }

        // check active
        if (! $user->active) {
            throw new GeneralJsonException('Deactivated account');
        }


    }
}
