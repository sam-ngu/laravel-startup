<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Events\Models\User\UserDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ChangeProfilePictureRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Api\V1\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class UserTwoFactorAuthController extends Controller
{
    public function update2FA(Request $request, User $user)
    {
        // this can only run by admin
        if(filter_var($request->two_factor, FILTER_VALIDATE_BOOLEAN)){
            app(EnableTwoFactorAuthentication::class)($user);
        }else{
            app(DisableTwoFactorAuthentication::class)($user);
        }
        return new JsonResponse([
            'data' => 'success'
        ]);
    }
}
