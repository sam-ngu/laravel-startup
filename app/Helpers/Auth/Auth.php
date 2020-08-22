<?php

namespace App\Helpers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class Auth.
 */
class Auth
{
    /**
     * Remove old session variables from admin logging in as user.
     */
    public static function flushTempSession()
    {
        // Remove any old session variables
        session()->forget('admin_user_id');
        session()->forget('admin_user_name');
        session()->forget('temp_user_id');
    }

    /**
     * @param $token
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public static function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return User::query()->where('email', $row->email)->first();
            }
        }

        return false;
    }
}
