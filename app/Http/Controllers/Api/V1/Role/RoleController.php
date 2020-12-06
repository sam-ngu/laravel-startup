<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Events\Models\Role\RolePermanentlyDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Role\StoreRoleRequest;
use App\Http\Requests\Api\V1\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repositories\Api\V1\RoleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    const RELATIONSHIPS = [
        'users', 'permissions',
    ];

    /**
     * Display a listing of Role.
     * @queryParam filter array An array to filter fields. Example: [name]="john"
     * @queryParam search string String to conduct full text search. Example: John Doe
     * @queryParam page_size int Number of items to return per page. Example: 50
     * @queryParam sort string Sort results by field. Example: -name will sort results by name in descending order
     * @apiResourceCollection App\Http\Resources\RoleResource
     * @apiResourceModel App\Models\Role
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, RoleRepository $repository)
    {
        $searchKeyword = (string)$request->search ?? null;
        $pageSize = (int)$request->page_size ?? 25;

        $roles = $repository->buildQuery()->with(self::RELATIONSHIPS);

        if ($searchKeyword) {
            $roles = $repository->search($searchKeyword)->query(function (Builder $builder) use ($roles) {
                $builder->with(self::RELATIONSHIPS);
                $builder->whereIn('id', $roles->get()->pluck('id'));
            });
        }

        return RoleResource::collection($roles->paginate($pageSize))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request, RoleRepository $repository)
    {
        $result = $repository->create($request->only('name', 'associated-permissions', 'permissions', 'sort', 'guard_name'));

        return (new RoleResource($result))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return (new RoleResource($role->loadMissing(self::RELATIONSHIPS)))->response();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role, RoleRepository $repository)
    {
        $result = $repository->update($role, $request->only('name', 'permissions'));

        return (new RoleResource($result))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role, RoleRepository $repository)
    {
        $result = $repository->forceDelete($role);

        event(new RolePermanentlyDeleted($role));

        return new JsonResponse(null, 204);
    }
}
