<?php

namespace App\Http\Requests\Auth;

use App\Rules\Auth\ConfirmationCodeExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ConfirmCodeRequest extends FormRequest
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
        // get the confirmation token from url
        $code = Request::segment(3);

        return [
            new ConfirmationCodeExists($code),
        ];
    }
}
