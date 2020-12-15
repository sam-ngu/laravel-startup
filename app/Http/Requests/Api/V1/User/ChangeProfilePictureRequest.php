<?php

namespace App\Http\Requests\Api\V1\User;

use App\Helpers\Auth\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class ChangeProfilePictureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return RequestHelper::isCurrentUserAuthorisedToCallResource(4);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
