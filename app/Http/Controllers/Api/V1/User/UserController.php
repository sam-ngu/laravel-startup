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

class UserController extends Controller
{
    const RELATIONSHIPS = [
        'roles',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, UserRepository $repository)
    {
        $searchKeyword = (string)$request->search ?? null;
        $pageSize = (int)$request->page_size ?? 25;

        $users = $repository->buildQuery()->with(self::RELATIONSHIPS);

        if ($searchKeyword) {
            $users = $repository->search($searchKeyword)->query(function (Builder $builder) use ($users) {
                $builder->with(self::RELATIONSHIPS);
                $builder->whereIn('id', $users->get()->pluck('id'));
            });
        }

        return UserResource::collection($users->paginate($pageSize))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, UserRepository $repository)
    {
        $result = $repository->create($request->only(
            'name',
            'email',
            'password',
            'active',
            'confirmed',
            'confirmation_email',
            'roles',
            'permissions'
        ));

        return (new UserResource($result))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return (new UserResource($user->loadMissing(self::RELATIONSHIPS)))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user, UserRepository $repository)
    {
        $result = $repository->update($user, $request->only(
            'name',
            'email',
            'roles',
            'active',
            'confirmed',
            'permissions'
        ));
        // only update password if logged in user is admin
        if ($request->password) {
            $result = $repository->updatePassword($user, $request->get('password'));
        }

        return (new UserResource($result))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, UserRepository $repository)
    {
        $result = $repository->softDelete($user);

        event(new UserDeleted($user));

        return new JsonResponse(['data' => 'success'], 200);
    }

    public function updateProfilePicture(ChangeProfilePictureRequest $request, User $user, UserRepository $repository)
    {
        $result = $repository->update($user, [
            'avatar_img' => $request->avatar_img,
        ]);

        return (new UserResource($result))->response();
    }

}
