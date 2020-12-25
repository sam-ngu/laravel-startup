<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Password\UpdatePasswordRequest;
use App\Models\User;
use App\Repositories\Api\V1\UserRepository;
use Illuminate\Http\JsonResponse;

class UserPasswordController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request, User $user, UserRepository $repository)
    {
        $repository->updatePassword($user, $request->password);

        return new JsonResponse([
            'data' => 'updated',
        ]);
    }
}
