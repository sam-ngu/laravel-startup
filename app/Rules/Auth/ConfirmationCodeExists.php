<?php

namespace App\Rules\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ConfirmationCodeExists implements Rule
{
    private $code;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::query()->where('confirmation_code', '=', $this->code)->first();

        $hasUserAlreadyConfirmed = $user->confirmed === 1;

        return ($user instanceof User) && ! $hasUserAlreadyConfirmed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Confirmation code is not valid';
    }
}
