<?php

namespace App\Actions\Fortify;

use App\Helpers\Auth\PasswordHelper;
use App\Models\User;
use App\Repositories\Api\V1\UserRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => PasswordHelper::rules(),
        ])->validate();

        $repository = new UserRepository();

        return $repository->create(array_merge(
            Arr::only($input, ['name', 'email', 'password']),
            [
                'roles' => [config('access.users.default_role')],
            ]
        ));


    }
}
