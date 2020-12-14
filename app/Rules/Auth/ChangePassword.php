<?php

namespace App\Rules\Auth;

use App\Helpers\Auth\PasswordHelper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

/**
 * Class ChangePassword.
 */
class ChangePassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validator = Validator::make([
            'password' => $value,
        ], [
            'password' => PasswordHelper::rules(),
        ]);


        return $validator->passes();
//        $uppercase = preg_match('@[A-Z]@', $value);
//        $lowercase = preg_match('@[a-z]@', $value);
//        $number = preg_match('@\d@', $value);
//        return $uppercase && $lowercase && $number && \strlen($value) >= 8;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('auth.password_rules');
    }
}
