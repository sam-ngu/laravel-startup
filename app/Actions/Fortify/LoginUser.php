<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginUser
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return false;
        }

        // check confirmed
        if(!$user->confirmed){
            return false;
        }

        // check active
        if(!$user->active){
            return false;
        }

        if (Hash::check($request->password, $user->password)) {
            return $user;
        }
    }
}
