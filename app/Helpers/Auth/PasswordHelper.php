<?php


namespace App\Helpers\Auth;

class PasswordHelper
{
    public static function rules()
    {
        return [
//            'required',
            'string',
            'min:8',             // must be at least 8 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
        ];
    }

    public static function changePasswordRules($oldPassword = null)
    {
        $rules = self::rules();
        if ($oldPassword) {
            $rules = array_merge($rules, [
                'different:' . $oldPassword,
            ]);
        }

        return $rules;
    }
}
