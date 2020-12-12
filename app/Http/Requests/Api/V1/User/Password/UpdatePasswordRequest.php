<?php

namespace App\Http\Requests\Api\V1\User\Password;

use App\Helpers\Auth\PasswordHelper;
use App\Rules\Auth\ChangePassword;
use App\Rules\Auth\SamePassword;
use App\Rules\Auth\UnusedPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $resourceId = (int)\Illuminate\Support\Facades\Request::segment(4);
        // make sure the user can only change own's password or user is admin
        return auth()->user()->getAuthIdentifier() === $resourceId || auth()->user()->isAdmin();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => [
                'required',
                new SamePassword(auth()->user()),
            ],
            'password' => array_merge(
                [
                    new ChangePassword(),
                    new UnusedPassword($this->user()),
                    'confirmed'
                ],
                PasswordHelper::changePasswordRules(
                    config('access.users.password_history') ? 'old_password' : null
                ),

            ),

        ];
    }
}
