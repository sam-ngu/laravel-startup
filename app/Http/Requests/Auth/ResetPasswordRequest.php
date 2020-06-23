<?php

namespace App\Http\Requests\Auth;

use App\Rules\Auth\ChangePassword;
use App\Rules\Auth\UnusedPassword;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordRequest.
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => array_merge(
                [
                    new ChangePassword(),
                    new UnusedPassword($this->get('token')),
                ],
                self::changePassword($this->email)
            ),
        ];
    }


    public static function changePassword($username, $oldPassword = null)
    {
        $rules = [
            'required',
            'string',
            'min:8',
            'confirmed',
//            new SequentialCharacters(),  // from langleyFoxall Password Rules
//            new RepetitiveCharacters(),
//            new DictionaryWords(),
//            new ContextSpecificWords($username),
//            new DerivativesOfContextSpecificWords($username),
//            new BreachedPasswords(),
        ];

        if ($oldPassword) {
            $rules = array_merge($rules, [
                'different:' . $oldPassword,
            ]);
        }

        return $rules;
    }
}
