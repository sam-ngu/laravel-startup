<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Api\V1\UserRepository;
use function DeepCopy\deep_copy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, UserRepository $repository)
    {
        $searchKeyword = (string)$request->search ?? null;
        $pageSize = (int)$request->page_size ?? 25;


        if($searchKeyword){
            $users = $repository->search($searchKeyword);
        }else{
            $users = $repository->buildQuery();
        }

        return UserResource::collection($users->paginate($pageSize))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->userRepository->create($request->only(
            'first_name',
            'last_name',
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
        return (new UserResource($user))->response();
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
            'first_name',
            'last_name',
            'email',
            'roles',
            'permissions'
        ));
        if($request->password){
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
    public function destroy(User $user)
    {
        $result = $this->userRepository->deleteById($user->id);

        event(new UserDeleted($user));

        return JsonResponse::create(["status" => "success", "data" => null]);
    }



}
