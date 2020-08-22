<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Events\Backend\Auth\User\UserDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\UserRepository;
use function DeepCopy\deep_copy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class UserStatusController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     * @param                   $status
     *
     * @return JsonResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function mark(ManageUserRequest $request, User $user, $status)
    {
        $result = $this->userRepository->mark($user, $status);
        return (new UserResource($result))->response();
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $deletedUser
     *
     * @return JsonResponse
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function delete(ManageUserRequest $request, User $deletedUser)
    {
        $result = $this->userRepository->forceDelete($deletedUser);
        return (new UserResource($result))->response();
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $deletedUser
     *
     * @return JsonResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(ManageUserRequest $request, User $deletedUser)
    {
        $result = $this->userRepository->restore($deletedUser);
        return (new UserResource($result))->response();
    }
}
