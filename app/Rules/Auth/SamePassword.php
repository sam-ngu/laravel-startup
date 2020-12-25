<?php

namespace App\Rules\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SamePassword implements Rule
{
    protected $user;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
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
        return Hash::check($value, $this->user->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not match our record.';
    }
}
